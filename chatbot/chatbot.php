<?php
/**
 * ProxiE Chatbot Widget
 * IoT Web Application - ProxiEat
 * 
 * HTML structure for the ProxiE chatbot interface.
 * Styling:  chatbot.css
 * Behavior: chatbot.js
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProxiE - ProxiEat Chatbot</title>
    <link rel="stylesheet" href="chatbot.css">
</head>
<body>

    <!-- ============================================
         FLOATING CHATBOT TOGGLE BUTTON
         ============================================ -->
    <button
        id="proxieat-chatbot-toggle"
        class="chatbot__toggle"
        type="button"
        aria-label="Open ProxiE Chat Assistant"
        aria-expanded="false"
        aria-controls="proxieat-chatbot"
    >
            <span class="chatbot__toggle-icon" aria-hidden="true">
                <img
                    src="assets/proxie-logo.png"
                    alt=""
                    class="chatbot__toggle-image"
                >
            </span>
        <span class="chatbot__toggle-text">Need help?</span>
    </button>

    <!-- ============================================
         MAIN CHATBOT CONTAINER
         ============================================ -->
    <div
        id="proxieat-chatbot"
        class="chatbot"
        role="dialog"
        aria-modal="true"
        aria-label="ProxiE Chat Assistant"
        hidden
    >

        <!-- ============================================
             CHATBOT HEADER
             ============================================ -->
        <header class="chatbot__header">
            <div class="chatbot__header-brand">
                <div class="chatbot__header-avatar" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="9" cy="9" r="1" fill="currentColor"/>
                        <circle cx="15" cy="9" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <div class="chatbot__header-info">
                    <h2 class="chatbot__header-title">ProxiE</h2>
                    <p class="chatbot__header-subtitle">Your IoT Assistant</p>
                </div>
            </div>
            <button
                id="chatbot-close"
                class="chatbot__close"
                type="button"
                aria-label="Close ProxiE Chat"
            >
                <span aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
        </header>

        <!-- ============================================
             MESSAGES CONTAINER
             ============================================ -->
        <main
            id="chatbot-messages"
            class="chatbot__messages"
            aria-label="Chat messages"
            aria-live="polite"
            tabindex="0"
        >
            <div class="chatbot__messages-list">

                <!-- Bot Welcome Message -->
                <article class="message message--bot">
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
                            <p>Hello! I'm <strong>ProxiE</strong>, your ProxiEat IoT assistant. How can I help you today?</p>
                        </div>
                        <footer class="message__meta">
                            <time class="message__timestamp" datetime="2026-07-27T18:34:22+08:00">Just now</time>
                        </footer>
                    </div>
                </article>

            </div>
        </main>

        <!-- ============================================
             QUICK ACTION CHIPS
             ============================================ -->
        <nav class="chatbot__quick-actions" aria-label="Quick actions">
            <div class="chatbot__quick-actions-list">
                <button class="chip" type="button" data-action="check-status">
                    <span class="chip__icon" aria-hidden="true">📡</span>
                    <span class="chip__label">Device Status</span>
                </button>
                <button class="chip" type="button" data-action="view-analytics">
                    <span class="chip__icon" aria-hidden="true">📊</span>
                    <span class="chip__label">Analytics</span>
                </button>
                <button class="chip" type="button" data-action="get-support">
                    <span class="chip__icon" aria-hidden="true">🛟</span>
                    <span class="chip__label">Support</span>
                </button>
            </div>
        </nav>

        <!-- ============================================
             INPUT SECTION
             ============================================ -->
        <footer class="chatbot__input-section">
            <form id="chatbot-form" class="chatbot__form" aria-label="Chat message form">
                <div class="chatbot__input-wrapper">
                    <label for="chatbot-input" class="chatbot__input-label">Type your message</label>
                    <input
                        type="text"
                        id="chatbot-input"
                        class="chatbot__input"
                        placeholder="Ask ProxiE anything..."
                        autocomplete="off"
                        aria-describedby="chatbot-input-hint"
                    >
                    <span id="chatbot-input-hint" class="chatbot__input-hint">Press Enter to send</span>
                </div>
                <button
                    id="chatbot-send"
                    class="chatbot__send"
                    type="submit"
                    aria-label="Send message"
                    disabled
                >
                    <span aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="22" y1="2" x2="11" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </span>
                </button>
            </form>
        </footer>

    </div>

    <script src="chatbot.js"></script>
</body>
</html>
