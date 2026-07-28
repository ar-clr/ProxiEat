// ============================================
// ProxiE Chatbot
// IoT Web Application - ProxiEat
// ============================================
//
// This file contains the frontend-only chat experience.
// No backend, no APIs, no AI — purely hardcoded responses.
//
// Architecture notes for future developers:
// - processMessage() is the single entry point for ALL user messages.
//   Whether the user types, clicks a chip, or a future API returns data,
//   everything flows through this one function.
// - getBotResponse() is the only place to replace with AI integration.
// - The knowledge base (responses object) is where new intents are added.
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
const chips = document.querySelectorAll(".chip");

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
            "Hello! 👋 I'm ProxiE, your ProxiEat assistant.\n\nI can help you with:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding Services\n• General Support\n\nHow can I assist you today?",
            "Hi there! 👋 I'm ProxiE, your ProxiEat assistant.\n\nI can help you with:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding Services\n• General Support\n\nHow can I assist you today?",
            "Welcome back! 👋 I'm ProxiE, your ProxiEat assistant.\n\nI can help you with:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding Services\n• General Support\n\nHow can I assist you today?",
            "Nice to see you! 👋 I'm ProxiE, your ProxiEat assistant.\n\nI can help you with:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding Services\n• General Support\n\nHow can I assist you today?"
        ]
    },
    device: {
        keywords: ['device', 'status', 'offline', 'online', 'wifi', 'network', 'connection'],
        responses: [
            "You can check your feeder's connection status from the Device Status page.\n\nIf your feeder appears offline, make sure it is powered on and connected to Wi-Fi."
        ]
    },
    feeding: {
        keywords: ['feed', 'feeding', 'schedule', 'food', 'meal'],
        responses: [
            "Feeding schedules can be managed from the Feeding Schedule page.\n\nFor your pet's safety, feeding actions cannot be performed through the chatbot."
        ]
    },
    analytics: {
        keywords: ['analytics', 'history', 'logs', 'reports', 'statistics', 'graph'],
        responses: [
            "The Analytics page provides feeding history, activity records, and trends collected by your ProxiEat feeder."
        ]
    },
    support: {
        keywords: ['support', 'help', 'problem', 'issue', 'broken', 'error'],
        responses: [
            "I'm here to help.\n\nPlease describe your issue in more detail and I'll guide you to the appropriate feature or solution."
        ]
    },
    boarding: {
        keywords: ['boarding', 'booking', 'reservation', 'hotel'],
        responses: [
            "Boarding reservations can be managed through the Boarding page where you can view availability and complete bookings."
        ]
    },
    fallback: {
        responses: [
            "I'm sorry, I don't have an answer for that yet.\n\nTry asking me about:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding\n• Support",
            "I'm still learning. More features are coming soon!\n\nIn the meantime, you can ask me about:\n\n• Device Status\n• Feeding Schedule\n• Analytics\n• Boarding\n• Support"
        ]
    }
};

/**
 * Determines the bot's response based on the user's message.
 *
 * Uses partial keyword matching against the knowledge base.
 * If multiple intents match, the first matching intent is used.
 * If no intent matches, a random fallback response is returned.
 *
 * Future: Replace this function body with a fetch() call to the backend AI endpoint.
 * The knowledge base can be sent as context/prompt to the AI model.
 *
 * @param {string} text - The user's message
 * @returns {string} Bot response
 */
function getBotResponse(text) {
    const normalized = text.toLowerCase().trim();

    // Check each intent for keyword matches (partial matching)
    for (const intent of Object.keys(responses)) {
        if (intent === 'fallback') continue;

        const intentData = responses[intent];
        const matched = intentData.keywords.some(keyword => normalized.includes(keyword));

        if (matched) {
            // Return a random response from this intent's response array
            const randomIndex = Math.floor(Math.random() * intentData.responses.length);
            return intentData.responses[randomIndex];
        }
    }

    // No intent matched — return a random fallback response
    const fallbackResponses = responses.fallback.responses;
    const randomIndex = Math.floor(Math.random() * fallbackResponses.length);
    return fallbackResponses[randomIndex];
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
 * - Quick action chips
 *
 * Flow:
 * 1. Add user message to chat
 * 2. Show typing indicator
 * 3. Wait 500–700ms
 * 4. Hide typing indicator
 * 5. Generate bot response
 * 6. Add bot response to chat
 *
 * Future: Step 3 will be replaced by an async fetch() to the backend.
 * The typing indicator will show while waiting for the API response.
 *
 * @param {string} text - The user's message text
 */
function processMessage(text) {
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

        // Generate response from knowledge base (or AI in future phases)
        const response = getBotResponse(text);
        addBotMessage(response);
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
// Quick Action Chips
// ============================================

/**
 * Handles quick action chip clicks.
 * Extracts the chip label text and sends it through the same processMessage()
 * pipeline used by manual input.
 *
 * Future: Chips may send structured data (data-action IDs) to the backend
 * instead of plain text. The backend will then return the appropriate response.
 *
 * @param {Event} event - Chip click event
 */
function handleChipClick(event) {
    const chip = event.currentTarget;
    const labelElement = chip.querySelector(".chip__label");

    if (!labelElement) {
        return;
    }

    const chipText = labelElement.textContent.trim();

    if (!chipText) {
        return;
    }

    // Send the chip text through the same conversation pipeline
    processMessage(chipText);
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

// Attach click handlers to all quick action chips
chips.forEach(chip => {
    chip.addEventListener("click", handleChipClick);
});
