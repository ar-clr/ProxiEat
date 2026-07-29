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

    setTimeout(async () => {
        // Remove typing indicator before rendering the actual response
        hideTypingIndicator();

        // Intent Engine pipeline: detect intent, then generate response
        // const intent = detectIntent(text);
        // const response = generateResponse(intent);

        const response = await generateAIResponse(text);

        // Render the response text in the chat as before
        addBotMessage(response.text);

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