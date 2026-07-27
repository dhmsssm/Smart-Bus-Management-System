<!-- Floating Chat Trigger Button -->
<button type="button" id="buslink-chat-trigger" class="btn-chat-trigger" title="Chat with BusLink Assistant">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="pulse-indicator"></span>
</button>

<!-- Chat Window Container -->
<div id="buslink-chat-window" class="chat-window-container">
    <!-- Chat Header -->
    <div class="chat-header-bar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="avatar-wrapper bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 1.25rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <i class="bi bi-bus-front"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-white" style="font-family: var(--font-heading);">BusLink Assistant</h6>
                <small class="text-white-50 d-flex align-items-center gap-1">
                    <span class="active-dot"></span> Online
                </small>
            </div>
        </div>
        <button type="button" id="buslink-chat-close" class="btn-close-chat" aria-label="Close Chat">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Chat Body -->
    <div id="buslink-chat-body" class="chat-messages-body">
        <div class="message-bubble bot-message message-pop">
            <div class="message-text">
                Hello 👋 Welcome to BusLink.
            </div>
        </div>
        
        <!-- Options Menu -->
        <div id="chat-options-menu" class="chat-quick-replies message-pop">
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Search Bus')">🔍 Search Bus</button>
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Book Seat')">🎫 Book Seat</button>
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Live Tracking')">📍 Live Tracking</button>
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Login/Register')">🔑 Login/Register</button>
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Contact Support')">📞 Contact Support</button>
            <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('FAQ')">❓ FAQ</button>
        </div>
    </div>
</div>

<style>
    /* Chat Trigger Button */
    .btn-chat-trigger {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
        color: white;
        border: none;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        cursor: pointer;
        z-index: 999;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-chat-trigger:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 15px 30px rgba(79, 70, 229, 0.45);
    }
    .btn-chat-trigger:active {
        transform: scale(0.95);
    }
    .pulse-indicator {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background-color: #ef4444;
        border: 2px solid white;
        border-radius: 50%;
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    /* Chat Window Container */
    .chat-window-container {
        position: fixed;
        bottom: 105px;
        right: 30px;
        width: 360px;
        height: 520px;
        max-width: calc(100vw - 60px);
        max-height: calc(100vh - 150px);
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 15px 45px rgba(15, 23, 42, 0.15);
        border: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 998;
        transform: translateY(20px) scale(0.95);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .chat-window-container.show {
        transform: translateY(0) scale(1);
        opacity: 1;
        visibility: visible;
    }

    /* Header Bar */
    .chat-header-bar {
        background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
        padding: 16px 20px;
        color: white;
    }
    .active-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: var(--success);
        border-radius: 50%;
        border: 1px solid white;
        animation: pulse-green 1.5s infinite;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .btn-close-chat {
        background: transparent;
        border: none;
        color: white;
        opacity: 0.8;
        font-size: 1.15rem;
        cursor: pointer;
        transition: var(--transition);
        padding: 4px;
    }
    .btn-close-chat:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Messages Body */
    .chat-messages-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 15px;
        scroll-behavior: smooth;
    }

    /* Message Bubbles */
    .message-bubble {
        max-width: 85%;
        padding: 12px 16px;
        border-radius: 18px;
        font-size: 0.92rem;
        line-height: 1.5;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
    }
    .bot-message {
        background-color: #ffffff;
        color: #1e293b;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .user-message {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    /* Quick Reply Options */
    .chat-quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 5px;
        align-self: flex-start;
        max-width: 95%;
    }
    .btn-quick-reply {
        background-color: #ffffff;
        border: 1.5px solid rgba(16, 185, 129, 0.3);
        color: var(--success);
        font-size: 0.85rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 99px;
        transition: var(--transition);
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.01);
    }
    .btn-quick-reply:hover {
        background-color: rgba(16, 185, 129, 0.06);
        border-color: var(--success);
        color: var(--success-dark);
        transform: translateY(-1.5px);
    }
    .btn-quick-reply:active {
        transform: translateY(0);
    }

    /* Message Pop Animation */
    .message-pop {
        animation: popIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    @keyframes popIn {
        0% { transform: translateY(10px) scale(0.96); opacity: 0; }
        100% { transform: translateY(0) scale(1); opacity: 1; }
    }

    /* Typing Dots Animation */
    .typing-indicator-bubble {
        background-color: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 18px;
        border-bottom-left-radius: 4px;
        padding: 12px 20px;
        align-self: flex-start;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .typing-dot {
        width: 6px;
        height: 6px;
        background-color: #94a3b8;
        border-radius: 50%;
        animation: bounce-typing 1.4s infinite ease-in-out both;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce-typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }
    @media (max-width: 991.98px) {
        .btn-chat-trigger {
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
        .chat-window-container {
            bottom: 80px;
            right: 20px;
            width: calc(100vw - 40px);
            height: calc(100vh - 120px);
            max-height: 480px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatTrigger = document.getElementById('buslink-chat-trigger');
        const chatWindow = document.getElementById('buslink-chat-window');
        const chatClose = document.getElementById('buslink-chat-close');
        const chatBody = document.getElementById('buslink-chat-body');

        // Toggle chat window
        chatTrigger.addEventListener('click', function() {
            chatWindow.classList.toggle('show');
            // Remove pulse indicator once opened
            const pulse = chatTrigger.querySelector('.pulse-indicator');
            if (pulse) pulse.remove();
        });

        chatClose.addEventListener('click', function() {
            chatWindow.classList.remove('show');
        });

        // Predefined answers mapping
        const answers = {
            'Search Bus': 'To search for buses, please use the search bar at the top of our Home page. Select your **Departure Location**, **Destination Location**, and **Travel Date**, then click **"Search"**.',
            'Book Seat': 'Booking is simple! Once you find a bus after searching, click **"Book Seat"** to open our interactive seat layout. Choose your seats, click **"Confirm"**, and secure your ticket.',
            'Live Tracking': 'BusLink offers real-time GPS tracking. Once your trip starts, visit your **Passenger Dashboard** and select **"Live Tracking"** to see your bus location and ETA live on the map.',
            'Login/Register': 'You can sign in by clicking **"Login"** or **"Register"** in the top-right corner of the navigation bar. Access dashboards for passengers, drivers, and admins.',
            'Contact Support': 'Our support team is here to help! <br>📞 **Phone**: +94 788508456, +94 742859361<br>✉️ **Email**: support@buslink.com, info@buslink.com<br>📍 **Address**: 120 street, Smart City, colombo.',
            'FAQ': 'For frequently asked questions about bookings, cancellations, refunds, or driver registration, please view the **Help & FAQ Center** inside your Passenger/Driver Dashboard, or click **"Contact Support"** to reach us directly.'
        };

        // Render Bot response after delay
        window.sendQuickReply = function(option) {
            // Append User message bubble
            appendMessage(option, 'user');

            // Hide the active quick reply menu
            const oldMenu = document.getElementById('chat-options-menu');
            if (oldMenu) oldMenu.remove();

            // Append typing indicator
            const typingIndicator = appendTypingIndicator();
            chatBody.scrollTop = chatBody.scrollHeight;

            setTimeout(() => {
                // Remove typing indicator
                typingIndicator.remove();

                // Get answer content
                const botResponse = answers[option] || "I'm sorry, I didn't understand that option.";
                appendMessage(botResponse, 'bot');

                // Append options menu again so user can ask more questions
                appendMenuOptions();

                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);
        };

        function appendMessage(text, sender) {
            const bubble = document.createElement('div');
            bubble.classList.add('message-bubble', sender === 'user' ? 'user-message' : 'bot-message', 'message-pop');
            
            // Format bold markdown and linebreaks nicely
            let formattedText = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            formattedText = formattedText.replace(/\n/g, '<br>');
            
            bubble.innerHTML = `<div class="message-text">${formattedText}</div>`;
            chatBody.appendChild(bubble);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function appendTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.classList.add('typing-indicator-bubble', 'message-pop');
            indicator.innerHTML = `
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            `;
            chatBody.appendChild(indicator);
            return indicator;
        }

        function appendMenuOptions() {
            const menu = document.createElement('div');
            menu.id = 'chat-options-menu';
            menu.classList.add('chat-quick-replies', 'message-pop');
            menu.innerHTML = `
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Search Bus')">🔍 Search Bus</button>
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Book Seat')">🎫 Book Seat</button>
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Live Tracking')">📍 Live Tracking</button>
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Login/Register')">🔑 Login/Register</button>
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('Contact Support')">📞 Contact Support</button>
                <button type="button" class="btn btn-quick-reply" onclick="sendQuickReply('FAQ')">❓ FAQ</button>
            `;
            chatBody.appendChild(menu);
        }
    });
</script>
