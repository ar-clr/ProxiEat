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
 * Maps Gemini model IDs returned by the backend
 * to user-friendly names displayed in the chat UI.
 */
const MODEL_NAMES = {
    "gemini-3.6-flash": "Gemini 3.6 Flash",
    "gemini-3.5-flash": "Gemini 3.5 Flash",
    "gemini-3-flash": "Gemini 3 Flash",
    "gemini-3.1-flash-lite": "Gemini 3.1 Flash Lite",
    "gemini-2.5-flash": "Gemini 2.5 Flash",
    "gemini-2.5-flash-lite": "Gemini 2.5 Flash Lite"
};

function getModelName(model) {
    return MODEL_NAMES[model] ?? "Gemini";
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
 * Initializes interactive actions for bot messages.
 * Future actions (Regenerate, Like, Dislike, etc.) can be added here.
 *
 * @param {HTMLElement} article - The bot message article element
 */
function initMessageActions(article) {
    const copyButton = article.querySelector(".message__action");
    if (!copyButton) return;

    copyButton.addEventListener("click", async () => {
        const messageText =
            article.querySelector(".message__content")?.innerText || "";
        try {
            await navigator.clipboard.writeText(messageText);
            copyButton.classList.add("is-copied");
            copyButton.setAttribute("aria-label", "Copied");
            setTimeout(() => {
                copyButton.classList.remove("is-copied");
                copyButton.setAttribute("aria-label", "Copy message");
            }, 1500);
        } catch (err) {
            console.error("Failed to copy message text:", err);
        }
    });
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
            <div class="message__actions">
                <!-- Future actions: Regenerate, Like, Dislike -->
                <button class="message__action" aria-label="Copy message" type="button">
                    <svg class="message__action-icon message__action-icon--copy" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <svg class="message__action-icon message__action-icon--check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span class="message__action-label">Copied!</span>
                </button>
            </div>
           <div class="message__content">
                ${renderMarkdown(text)}
            </div>
                <footer class="message__meta">

                    <span class="message__model">
                        ${getModelName(window.currentModel)}
                    </span>

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

    initMessageActions(article);
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