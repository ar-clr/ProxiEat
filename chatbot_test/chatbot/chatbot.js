// ============================================
// ProxiE Chatbot
// ProxiEat Boarding Assistant
// ============================================
//
// This file contains the frontend-only chat experience.
// No backend, no APIs, no AI — purely hardcoded responses.
//
// Architecture notes for future developers:
// - ProxiE is NOT a feeder controller.
// - The feeder remains inside the veterinary clinic.
// - Owners interact with monitoring features only.
// - processMessage() is the single entry point for ALL user messages.
//   Whether the user types, clicks a suggestion, or a future API returns data,
//   everything flows through this one function.
// - hideSuggestedActions() removes the Suggested Actions container after the
//   first user interaction so they never appear again during the session.
// - dismissEmptyState() removes the empty-state section with a fade + translateY
//   animation after the user sends their first message. It never reappears
//   during the same session.
// - detectIntent() determines the user's intent by matching keywords.
// - generateResponse() picks a random response for a given intent
//   and returns contextual follow-up suggestions.
// - The knowledge base (responses object) is where new intents are added.
// - Each intent now supports a `suggestions` array for contextual
//   follow-up prompts shown after the bot responds.
// ============================================

// ============================================
// DOM References
// ============================================
const toggle = document.getElementById("proxieat-chatbot-toggle");
const chatbot = document.getElementById("proxieat-chatbot");
const closeBtn = document.getElementById("chatbot-close");
const form = document.getElementById("chatbot-form");
const input = document.getElementById("chatbot-input");
const sendButton = document.getElementById("chatbot-send");
const messagesList = document.querySelector(".chatbot__messages-list");

// All suggested action buttons — used to attach click listeners and to remove on first interaction
const suggestions = document.querySelectorAll(".chatbot__suggestion");

// Tracks whether the user has interacted with the chat (first message sent)
// After the first interaction, suggested actions are permanently hidden.
let suggestionsDismissed = false;

// Tracks whether the empty-state section has been dismissed.
// The empty state is shown on first open and removed after the user
// sends their first message. It never reappears during the session.
let emptyStateDismissed = false;

// Lightweight conversation context.
// Remembers the last successfully detected intent so that vague follow-up
// messages (e.g. "what about that?", "how?", "okay") can be handled
// without requiring the user to re-state their intent.
//
// This is a single-topic memory — it only tracks the most recent intent.
// In a future phase, this will be replaced by AI conversation history
// that maintains full context across multiple turns.
let currentIntent = null;

// Phrases that indicate the user is following up on the previous topic
// rather than starting a new conversation thread.
// These are checked when detectIntent() finds no keyword match,
// allowing the chatbot to reuse the current intent instead of falling back.
const VAGUE_FOLLOW_UP_PHRASES = [
    'what about that',
    'can I change it',
    'how',
    'why',
    'when',
    'where',
    'really?',
    'okay'
];

// ============================================
// Suggested Actions Helper
// ============================================

/**
 * Removes the Suggested Actions container from the DOM and marks it as dismissed.
 *
 * Exists as a single source of truth for hiding suggestions so they are never
 * shown again during the current session. Once the user has interacted, the
 * quick-action prompts are no longer relevant and cluttering the UI.
 */
function hideSuggestedActions() {
    if (suggestionsDismissed) {
        return;
    }

    const container = document.getElementById("chatbot-suggested-actions");
    if (container) {
        container.remove();
    }

    suggestionsDismissed = true;
}

/**
 * Dismisses the empty-state section with a fade + translateY animation.
 * Called once when the user sends their first message.
 * The empty state never reappears during the same session.
 *
 * The animation duration (300ms) matches the CSS --proxie-transition-fast
 * timing so the removal feels snappy and consistent with the design system.
 */
function dismissEmptyState() {
    if (emptyStateDismissed) {
        return;
    }

    const emptyState = document.getElementById("chatbot-empty-state");
    if (!emptyState) {
        emptyStateDismissed = true;
        return;
    }

    emptyState.classList.add("is-dismissing");

    // Wait for the dismiss animation to finish before removing from DOM
    emptyState.addEventListener("animationend", () => {
        emptyState.remove();
    }, { once: true });

    emptyStateDismissed = true;
}

// ============================================
// Chatbot Open / Close
// ============================================

/**
 * Opens the chatbot panel.
 * Removes the hidden attribute and triggers the open animation.
 * Also focuses the input field so the user can start typing immediately.
 */
function openChatbot() {
    chatbot.hidden = false;
    chatbot.classList.add("is-open");
    toggle.classList.add("is-hidden");

    // UX: immediately focus the input so the user can type without clicking
    input.focus();
}

/**
 * Closes the chatbot panel.
 * Waits for the close animation to finish before hiding.
 */
function closeChatbot() {
    chatbot.classList.remove("is-open");

    setTimeout(() => {
        chatbot.hidden = true;
        toggle.classList.remove("is-hidden");
    }, 400);
}

// ============================================
// Helper Functions
// ============================================

/**
 * Scrolls the messages container to the bottom.
 * Ensures the newest message is always visible to the user.
 *
 * Later: may also be called after receiving a streaming response.
 */
function scrollToBottom() {
    const messagesContainer = document.getElementById("chatbot-messages");
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

/**
 * Creates a user message element and appends it to the chat.
 *
 * @param {string} text - The message text entered by the user
 */
function addUserMessage(text) {
    const article = document.createElement("article");
    article.className = "message message--user";

    article.innerHTML = `
        <div class="message__avatar" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="9" cy="9" r="1" fill="currentColor"/>
                <circle cx="15" cy="9" r="1" fill="currentColor"/>
            </svg>
        </div>
        <div class="message__body">
            <div class="message__content">
                <p>${escapeHtml(text)}</p>
            </div>
            <footer class="message__meta">
                <time class="message__timestamp">Just now</time>
            </footer>
        </div>
    `;

    messagesList.appendChild(article);
    scrollToBottom();
}

/**
 * Creates a bot message element and appends it to the chat.
 *
 * @param {string} text - The response text from the bot
 */
function addBotMessage(text) {
    const article = document.createElement("article");
    article.className = "message message--bot";

    article.innerHTML = `
        <div class="message__avatar" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="9" cy="9" r="1" fill="currentColor"/>
                <circle cx="15" cy="9" r="1" fill="currentColor"/>
            </svg>
        </div>
        <div class="message__body">
            <div class="message__content">
                <p>${escapeHtml(text)}</p>
            </div>
            <footer class="message__meta">
                <time class="message__timestamp">Just now</time>
            </footer>
        </div>
    `;

    messagesList.appendChild(article);
    scrollToBottom();
}

/**
 * Escapes HTML special characters to prevent XSS.
 *
 * @param {string} text - Raw user input
 * @returns {string} Safe HTML string
 */
function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

// ============================================
// Typing Indicator
// ============================================

/**
 * Stores a reference to the current typing indicator element.
 * Ensures only ONE typing indicator exists at any time.
 */
let typingIndicatorElement = null;

/**
 * Shows a typing indicator in the chat.
 * If one already exists, it does nothing (prevents duplicates).
 *
 * Future: This will be called right before/after initiating a fetch() to the backend.
 * AI streaming responses may replace or extend this indicator.
 */
function showTypingIndicator() {
    if (typingIndicatorElement) {
        return; // Already showing a typing indicator
    }

    const article = document.createElement("article");
    article.className = "message message--bot message--typing";

    article.innerHTML = `
        <div class="message__avatar" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="9" cy="9" r="1" fill="currentColor"/>
                <circle cx="15" cy="9" r="1" fill="currentColor"/>
            </svg>
        </div>
        <div class="message__body">
            <div class="message__content">
                <p class="message__typing-text">ProxiE is thinking...</p>
                <div class="message__typing">
                    <span class="message__typing-dot"></span>
                    <span class="message__typing-dot"></span>
                    <span class="message__typing-dot"></span>
                </div>
            </div>
        </div>
    `;

    messagesList.appendChild(article);
    typingIndicatorElement = article;
    scrollToBottom();
}

/**
 * Removes the typing indicator from the chat.
 * Safely does nothing if no indicator exists.
 *
 * Future: Called when the backend response arrives or streaming completes.
 *
 * @returns {boolean} True if an indicator was removed, false otherwise
 */
function hideTypingIndicator() {
    if (!typingIndicatorElement) {
        return false;
    }

    typingIndicatorElement.remove();
    typingIndicatorElement = null;
    return true;
}

// ============================================
// Knowledge Base
// ============================================

/**
 * Centralized knowledge base for ProxiE responses.
 *
 * Each intent contains:
 * - keywords: terms that trigger this response (partial match supported)
 * - responses: array of possible replies (randomly chosen for variety)
 *
 * Future: Replace this object with a fetch() call to a backend API.
 * The AI will return a response string, and this structure will become
 * the prompt/context passed to the model.
 */
const responses = {
    greeting: {
        keywords: ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'],
        responses: [
            "Hello! 👋\n\nI'm ProxiE, your ProxiEat boarding assistant.\n\nI can help you monitor your pet during their stay at our veterinary clinic.\n\nI can answer questions about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• General Support\n\nHow can I help you today?",
            "Hi there! 👋\n\nI'm ProxiE, your ProxiEat boarding assistant.\n\nI can help you monitor your pet during their stay at our veterinary clinic.\n\nI can answer questions about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• General Support\n\nHow can I help you today?",
            "Welcome back! 👋\n\nI'm ProxiE, your ProxiEat boarding assistant.\n\nI can help you monitor your pet during their stay at our veterinary clinic.\n\nI can answer questions about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• General Support\n\nHow can I help you today?",
            "Nice to see you! 👋\n\nI'm ProxiE, your ProxiEat boarding assistant.\n\nI can help you monitor your pet during their stay at our veterinary clinic.\n\nI can answer questions about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• General Support\n\nHow can I help you today?"
        ],
        suggestions: [
            "Device Status",
            "Feeding Schedule",
            "Analytics",
            "Boarding",
            "Reservations",
            "Support"
        ]
    },
    device: {
        keywords: ['device', 'status', 'offline', 'online', 'wifi', 'network', 'connection'],
        responses: [
            "You can view your pet's feeder status from the Device Status page on the dashboard.\n\nIf the feeder appears offline or there are connectivity issues, veterinary staff will restore the connection and handle device maintenance as needed."
        ],
        suggestions: [
            "Feeding Schedule",
            "Analytics",
            "Boarding"
        ]
    },
    feeding: {
        keywords: ['feed', 'feeding', 'schedule', 'food', 'meal'],
        responses: [
            "Feeding schedules are managed by the veterinary clinic staff.\n\nThe chatbot cannot dispense food or perform feeding actions.\n\nAll feeding operations are performed by authorized clinic staff during your pet's stay."
        ],
        suggestions: [
            "Device Status",
            "Analytics",
            "Boarding"
        ]
    },
    analytics: {
        keywords: ['analytics', 'history', 'logs', 'reports', 'statistics', 'graph'],
        responses: [
            "The Analytics page provides monitoring information collected while your pet is boarding.\n\nExamples include:\n\n• Feeding history\n• Food consumption\n• Feeder activity\n• Boarding records\n\nThis data is accessible from the dashboard."
        ],
        suggestions: [
            "Device Status",
            "Feeding Schedule",
            "Boarding"
        ]
    },
    support: {
        keywords: ['support', 'help', 'problem', 'issue', 'broken', 'error'],
        responses: [
            "I'm here to help with questions about the ProxiEat boarding system.\n\nIf your issue requires staff intervention — such as device maintenance, refilling food, or cleaning the feeder — please contact the veterinary clinic directly.\n\nFor general questions about features and monitoring, I'm happy to assist."
        ],
        suggestions: [
            "Device Status",
            "Feeding Schedule",
            "Analytics"
        ]
    },
    boarding: {
        keywords: ['boarding', 'booking', 'reservation', 'hotel'],
        responses: [
            "ProxiEat provides a boarding monitoring experience for pets staying at our veterinary clinic.\n\nYou can:\n\n• Monitor your pet's status from the dashboard\n• Review boarding information and records\n• View and manage reservations\n• Access updates from the clinic\n\nThe smart feeder is located inside the veterinary clinic and is maintained by clinic staff."
        ],
        suggestions: [
            "Device Status",
            "Feeding Schedule",
            "Analytics"
        ]
    },
    fallback: {
        responses: [
            "I'm sorry, I don't have an answer for that yet.\n\nTry asking me about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• Support",
            "I'm still learning. More features are coming soon!\n\nIn the meantime, you can ask me about:\n\n• Boarding\n• Feeding schedules\n• Device Status\n• Analytics\n• Reservations\n• Support"
        ],
        suggestions: []
    }
};

/**
  * Detects the user's intent by matching their message against
  * keyword patterns in the knowledge base.
  *
  * Normalizes the message, then searches every intent's keywords
  * using partial matching. Returns the first matching intent name.
  * If no intent matches, checks for vague follow-up phrases.
  * If a follow-up is detected and a currentIntent exists,
  * reuses the current intent instead of returning "fallback".
  * Otherwise, returns "fallback".
  *
  * Side effect: when a non-fallback intent is detected, stores it
  * in currentIntent so follow-up messages can be handled.
  *
  * This function only determines the intent — it does not return
  * a response. That responsibility belongs to generateResponse().
  *
  * Future: Replace keyword matching with an AI classification call
  * that returns an intent label and confidence score.
  *
  * @param {string} text - The user's message
  * @returns {string} The detected intent name
  */
function detectIntent(text) {
    const normalized = text.toLowerCase().trim();

    // Check each intent for keyword matches (partial matching)
    for (const intent of Object.keys(responses)) {
        if (intent === 'fallback') continue;

        const intentData = responses[intent];
        const matched = intentData.keywords.some(keyword => normalized.includes(keyword));

        if (matched) {
            // Store the detected intent for follow-up context
            currentIntent = intent;
            return intent;
        }
    }

    // No keyword match — check if this is a vague follow-up
    // to the previous topic (e.g. "what about that?", "how?", "okay")
    const isFollowUp = VAGUE_FOLLOW_UP_PHRASES.some(phrase => normalized.includes(phrase));

    if (isFollowUp && currentIntent !== null) {
        // Reuse the previous intent so the conversation flows naturally
        return currentIntent;
    }

    // No intent matched and not a follow-up — return fallback
    return 'fallback';
}

/**
  * Generates a bot response for a given intent.
  *
  * Randomly selects one response from the intent's response array
  * and returns it alongside the intent's contextual follow-up suggestions.
  *
  * If the intent has no responses (e.g. malformed data), returns
  * a safe default message with an empty suggestions array.
  *
  * Future: Replace random selection with an AI-generated response
  * based on the intent and conversation context.
  *
  * @param {string} intent - The detected intent name
  * @returns {{ text: string, suggestions: string[] }} Response object with text and follow-up suggestions
  */
function generateResponse(intent) {
    const intentData = responses[intent];

    if (!intentData || !intentData.responses || intentData.responses.length === 0) {
        return {
            text: "I'm sorry, something went wrong. Please try again.",
            suggestions: []
        };
    }

    const randomIndex = Math.floor(Math.random() * intentData.responses.length);
    const text = intentData.responses[randomIndex];
    const suggestions = intentData.suggestions || [];

    return { text, suggestions };
}

// ============================================
// Central Message Processing
// ============================================

/**
    * The single pipeline for processing every user message.
    *
    * This function is called by:
    * - Keyboard input (form submit)
    * - Send button click
    * - Suggested action buttons
    *
    * All messages flow through this one function so there is a
    * single source of truth for message handling. No duplicate
    * logic exists for different input sources.
    *
    * Flow:
    * 1. Hide suggested actions (first interaction only)
    * 2. Add user message to chat
    * 3. Show typing indicator
    * 4. Wait 500–700ms
    * 5. Hide typing indicator
    * 6. detectIntent() — classify the user's message
    * 7. generateResponse() — produce a response for the detected intent
    * 8. Add bot response to chat
    *
    * ProxiE is a boarding assistant — it does not control the feeder.
    * The feeder remains inside the veterinary clinic and is managed by clinic staff.
    * Owners interact with monitoring features only.
    *
    * Future: Steps 6–7 will be replaced by an async fetch() to the backend.
    * The typing indicator will show while waiting for the API response.
    *
    * @param {string} text - The user's message text
    */
function processMessage(text) {
    // Dismiss suggested actions and empty state on first interaction
    // so they never appear again during this session (ChatGPT-style behavior)
    hideSuggestedActions();
    dismissEmptyState();

    // Add the user's message immediately
    addUserMessage(text);

    // Show typing indicator while the bot "thinks"
    showTypingIndicator();

    // Simulate natural typing delay (500–700ms)
    // In Phase 2+, replace this setTimeout with an actual API call.
    const delay = 500 + Math.random() * 200;

    setTimeout(() => {
        // Remove typing indicator before rendering the actual response
        hideTypingIndicator();

        // Intent Engine pipeline: detect intent, then generate response
        const intent = detectIntent(text);
        const response = generateResponse(intent);

        // Render the response text in the chat as before
        addBotMessage(response.text);

        // TODO (Phase 4): Render contextual follow-up suggestions beneath
        // the bot response in the UI. For now, log them to the console
        // so developers can verify the data structure is correct.
        // Future: replace this with DOM rendering of suggestion buttons.
        console.log(response.suggestions);
    }, delay);
}

// ============================================
// Form Handling
// ============================================

/**
 * Handles the chat form submission.
 * Delegates to processMessage() so all input sources share the same pipeline.
 *
 * @param {Event} event - Form submit event
 */
function handleSendMessage(event) {
    event.preventDefault();

    const text = input.value.trim();

    // Ignore empty or whitespace-only messages
    if (!text) {
        return;
    }

    // Clear input after reading
    input.value = "";

    // Update send button state (should be disabled now)
    updateSendButtonState();

    // Process the message through the central pipeline
    processMessage(text);
}

/**
 * Enables or disables the Send button based on whether the input has text.
 * Prevents sending empty messages.
 */
function updateSendButtonState() {
    const hasText = input.value.trim().length > 0;
    sendButton.disabled = !hasText;
}

// ============================================
// Suggested Actions
// ============================================

/**
  * Handles suggested action button clicks.
  * Extracts the suggestion text and sends it through the same processMessage()
  * pipeline used by manual input.
  *
  * Future: Suggestions may send structured data (data-action IDs) to the backend
  * instead of plain text. The backend will then return the appropriate response.
  *
  * @param {Event} event - Suggestion click event
  */
function handleSuggestionClick(event) {
    const suggestion = event.currentTarget;
    const textElement = suggestion.querySelector(".chatbot__suggestion-text");

    if (!textElement) {
        return;
    }

    const suggestionText = textElement.textContent.trim();

    if (!suggestionText) {
        return;
    }

    // Send the suggestion text through the same conversation pipeline
    processMessage(suggestionText);
}

// ============================================
// Event Listeners
// ============================================

// Open chatbot when floating button is clicked
toggle.addEventListener("click", openChatbot);

// Close chatbot when close button is clicked
closeBtn.addEventListener("click", closeChatbot);

// Handle message sending via form submit (Enter key or Send button)
form.addEventListener("submit", handleSendMessage);

// Update send button state as the user types
input.addEventListener("input", updateSendButtonState);

// Initialize send button state on page load
updateSendButtonState();

// Attach click handlers to all suggested action buttons
suggestions.forEach(suggestion => {
    suggestion.addEventListener("click", handleSuggestionClick);
});
