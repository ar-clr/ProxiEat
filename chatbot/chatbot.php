<?php
/**
 * ProxiE Chatbot Widget
 * ProxiEat Boarding Assistant
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
                    src="../assets/images/chatbot/proxie-logo.png"
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
                    <p class="chatbot__header-subtitle">Your ProxiEat Boarding Assistant</p>
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

<!-- Empty Conversation State
             Shown when the chatbot is opened for the first time in a session.
             Replaced by the chat history after the user sends their first message.
             This empty state provides a modern ChatGPT-like onboarding experience,
             introducing ProxiE and its capabilities before any interaction occurs.
             Future: AI personalization could tailor the greeting, description,
             and suggested actions based on the user's pet profile or history. -->
                  <div class="chatbot__empty-state" id="chatbot-empty-state">
                   <img
                       src="../assets/images/chatbot/proxie-logo.png"
                       alt="ProxiEat Assistant"
                       class="chatbot__empty-image"
                   >
                      <h2 class="chatbot__empty-title">Hi, I'm ProxiE</h2>
                      <p class="chatbot__empty-subtitle">Your ProxiEat Boarding Assistant</p>
                      <p class="chatbot__empty-description">
                          I can answer questions about your pet's boarding stay, feeding schedules, device status, analytics, reservations, and support.
                      </p>
                  </div>

                 <!-- Suggested Actions (rendered by JS, removed after first interaction) -->
                 <div class="chatbot__suggested-actions" id="chatbot-suggested-actions">
                     <div class="chatbot__suggestions">
                         <button class="chatbot__suggestion" type="button" data-suggestion="Device Status">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">📡</span>
                             <span class="chatbot__suggestion-text">Device Status</span>
                         </button>
                         <button class="chatbot__suggestion" type="button" data-suggestion="Feeding Schedule">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">🍽</span>
                             <span class="chatbot__suggestion-text">Feeding Schedule</span>
                         </button>
                         <button class="chatbot__suggestion" type="button" data-suggestion="Analytics">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">📊</span>
                             <span class="chatbot__suggestion-text">Analytics</span>
                         </button>
                         <button class="chatbot__suggestion" type="button" data-suggestion="Boarding">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">🏨</span>
                             <span class="chatbot__suggestion-text">Boarding</span>
                         </button>
                         <button class="chatbot__suggestion" type="button" data-suggestion="Reservations">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">📅</span>
                             <span class="chatbot__suggestion-text">Reservations</span>
                         </button>
                         <button class="chatbot__suggestion" type="button" data-suggestion="Support">
                             <span class="chatbot__suggestion-icon" aria-hidden="true">💬</span>
                             <span class="chatbot__suggestion-text">Support</span>
                         </button>
                     </div>
                 </div>

             </div>
         </main>

<!-- ============================================
              SUGGESTED ACTIONS
              Rendered inside the conversation by JavaScript.
              Appears only before the user's first interaction.
              Removed alongside the empty-state section on first message.
              ============================================ -->

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
</body>
</html>
