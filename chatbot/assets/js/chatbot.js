
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
