async function processMessage(text) {
    // Dismiss suggested actions and empty state on first interaction
    hideSuggestedActions();
    dismissEmptyState();

    // Add the user's message immediately
    addUserMessage(text);

    // Show typing indicator while the bot "thinks"
    showTypingIndicator();

    const delay = 500 + Math.random() * 200;

    setTimeout(async () => {

        try {

            const response = await generateAIResponse(text);

            console.log("response.model =", response.model);

            window.currentModel = response.model;

            console.log("window.currentModel =", window.currentModel);

            hideTypingIndicator();

            addBotMessage(response.text);

        } catch (error) {

            console.error(error);

            // Remove typing indicator if the request failed
            hideTypingIndicator();

            addBotMessage(
                "⚠️ Sorry, I couldn't contact the AI service right now. Please try again in a moment."
            );

        }

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