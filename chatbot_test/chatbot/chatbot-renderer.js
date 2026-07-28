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
 * Returns the current local time formatted as:
 * 3:42 PM
 * 10:05 AM
 *
 * Future:
 * This helper can later be expanded to support
 * relative times ("2 minutes ago") and day separators.
 *
 * @returns {string} Formatted local time
 */
function getCurrentTimestamp() {
    return new Date().toLocaleTimeString([], {
        hour: "numeric",
        minute: "2-digit",
        hour12: true
    });
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
                <time
                    class="message__timestamp"
                    datetime="${new Date().toISOString()}"
                >
                    ${getCurrentTimestamp()}
                </time>
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
                <time
                    class="message__timestamp"
                    datetime="${new Date().toISOString()}"
                >
                    ${getCurrentTimestamp()}
                </time>
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