// Tracks whether the user has interacted with the chat (first message sent)
// After the first interaction, suggested actions are permanently hidden.
let suggestionsDismissed = false;

// Tracks whether the empty-state section has been dismissed.
// The empty state is shown on first open and removed after the user
// sends their first message. It never reappears during the session.
let emptyStateDismissed = false;

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
