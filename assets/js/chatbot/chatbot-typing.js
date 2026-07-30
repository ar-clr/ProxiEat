
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