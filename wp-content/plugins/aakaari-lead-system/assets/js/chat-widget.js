/**
 * Aakaari Chat Widget
 * Lead conversion live chat system
 */

(function() {
    'use strict';

    // Configuration from WordPress
    const config = window.aakaariChat || {};

    // State
    const state = {
        isOpen: false,
        isMinimized: false,
        conversationId: null,
        visitorId: null,
        lastMessageId: 0,
        isTyping: false,
        agentTyping: false,
        pollInterval: null,
        triggerShown: false,
        triggerId: null,
        unreadCount: 0,
        status: 'idle', // idle, prechat, waiting, active, ended
        formData: {},
        pagesVisited: 1,
        scrollDepth: 0,
        timeOnPage: 0
    };

    // DOM Elements
    let widget, chatButton, chatWindow, triggerPopup;

    /**
     * Initialize widget
     */
    function init() {
        if (!config.settings?.enabled) return;

        createWidget();
        bindEvents();
        trackVisitor();
        initTriggers();

        // Restore session if exists
        restoreSession();
    }

    /**
     * Create widget DOM
     */
    function createWidget() {
        widget = document.createElement('div');
        widget.id = 'aakaari-chat-widget';
        widget.innerHTML = `
            <button class="aakaari-chat-button" aria-label="${config.i18n?.startChat || 'Start Chat'}">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                </svg>
                <span class="aakaari-unread-badge" style="display: none;">0</span>
            </button>

            <div class="aakaari-trigger-popup">
                <p></p>
                <div class="aakaari-trigger-actions">
                    <button class="aakaari-trigger-accept">${config.i18n?.startChat || 'Start Chat'}</button>
                    <button class="aakaari-trigger-dismiss">×</button>
                </div>
            </div>

            <div class="aakaari-chat-window" role="dialog" aria-label="Chat">
                <div class="aakaari-chat-header">
                    <div class="aakaari-header-avatar">AT</div>
                    <div class="aakaari-header-info">
                        <h2 class="aakaari-header-title">AAKAARI Tech</h2>
                        <div class="aakaari-header-status">
                            <span class="aakaari-status-dot ${config.settings?.offlineMode ? 'offline' : ''}"></span>
                            <span class="aakaari-status-text">${config.settings?.offlineMode ? 'Leave a message' : 'Online'}</span>
                        </div>
                    </div>
                    <button class="aakaari-close-btn" aria-label="Close">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>

                <div class="aakaari-chat-body">
                    ${renderPrechatForm()}
                </div>
            </div>
        `;

        document.body.appendChild(widget);

        // Cache elements
        chatButton = widget.querySelector('.aakaari-chat-button');
        chatWindow = widget.querySelector('.aakaari-chat-window');
        triggerPopup = widget.querySelector('.aakaari-trigger-popup');
    }

    /**
     * Render pre-chat form
     */
    function renderPrechatForm() {
        return `
            <form class="aakaari-prechat-form" id="aakaari-prechat-form">
                <h3>${config.i18n?.formTitle || 'Before we chat...'}</h3>

                <div class="aakaari-form-group">
                    <label for="aakaari-name">${config.i18n?.nameLabel || 'Your Name'} <span class="required">*</span></label>
                    <input type="text" id="aakaari-name" name="name" required minlength="3" maxlength="100" autocomplete="name">
                    <div class="error-message">${config.i18n?.requiredField || 'This field is required'}</div>
                </div>

                <div class="aakaari-form-group">
                    <label for="aakaari-email">${config.i18n?.emailLabel || 'Email Address'} <span class="required">*</span></label>
                    <input type="email" id="aakaari-email" name="email" required autocomplete="email">
                    <div class="error-message">${config.i18n?.invalidEmail || 'Please enter a valid email'}</div>
                </div>

                <div class="aakaari-form-group">
                    <label for="aakaari-website">${config.i18n?.websiteLabel || 'Website URL (optional)'}</label>
                    <input type="url" id="aakaari-website" name="website" placeholder="https://" autocomplete="url">
                </div>

                <div class="aakaari-form-group">
                    <label for="aakaari-company">${config.i18n?.companyLabel || 'Company Name (optional)'}</label>
                    <input type="text" id="aakaari-company" name="company" maxlength="100" autocomplete="organization">
                </div>

                <div class="aakaari-form-group">
                    <label for="aakaari-source">${config.i18n?.sourceLabel || 'How did you find us?'}</label>
                    <select id="aakaari-source" name="how_found_us">
                        <option value="">Select...</option>
                        <option value="google">Google Search</option>
                        <option value="referral">Referral</option>
                        <option value="social">Social Media</option>
                        <option value="ad">Advertisement</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="aakaari-form-group">
                    <label for="aakaari-question">${config.i18n?.questionLabel || 'What brings you here today?'} <span class="required">*</span></label>
                    <textarea id="aakaari-question" name="question" required minlength="5" maxlength="200" placeholder="Tell us briefly..."></textarea>
                    <div class="error-message">${config.i18n?.requiredField || 'This field is required'}</div>
                </div>

                <!-- Honeypot -->
                <div class="aakaari-hp">
                    <input type="text" name="website_url_confirm" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" name="form_token" value="${generateFormToken()}">

                <button type="submit" class="aakaari-form-submit">
                    ${config.i18n?.submitForm || 'Start Chatting'}
                </button>
            </form>
        `;
    }

    /**
     * Render chat interface
     */
    function renderChatInterface() {
        const body = widget.querySelector('.aakaari-chat-body');
        body.innerHTML = `
            ${state.status === 'waiting' ? `
                <div class="aakaari-queue-info">
                    ${config.i18n?.queuePosition || 'Your position in queue:'} <strong>#${state.queuePosition || 1}</strong>
                    <br><small>${config.i18n?.waitTime || 'Average wait time:'} ~${state.estimatedWait || 2} min</small>
                </div>
            ` : ''}

            <div class="aakaari-chat-messages" id="aakaari-messages">
                <!-- Messages will be inserted here -->
            </div>

            <div class="aakaari-chat-input">
                <div class="aakaari-input-wrapper">
                    <textarea
                        id="aakaari-message-input"
                        placeholder="${config.i18n?.typeMessage || 'Type your message...'}"
                        maxlength="1000"
                        rows="1"
                    ></textarea>
                    <button class="aakaari-send-btn" id="aakaari-send-btn" disabled aria-label="${config.i18n?.sendMessage || 'Send'}">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </div>
                <div class="aakaari-char-count"><span id="aakaari-char-count">0</span>/1000</div>
            </div>

            <div class="aakaari-end-chat">
                <button id="aakaari-end-chat">${config.i18n?.endChat || 'End Chat'}</button>
            </div>
        `;

        bindChatEvents();
    }

    /**
     * Bind events
     */
    function bindEvents() {
        // Toggle chat
        chatButton.addEventListener('click', () => {
            if (triggerPopup.classList.contains('show')) {
                triggerPopup.classList.remove('show');
            }
            toggleChat();
        });

        // Close button
        widget.querySelector('.aakaari-close-btn').addEventListener('click', () => {
            toggleChat(false);
        });

        // Trigger popup actions
        widget.querySelector('.aakaari-trigger-accept').addEventListener('click', () => {
            if (state.triggerId) {
                recordTriggerEngagement(state.triggerId);
            }
            triggerPopup.classList.remove('show');
            toggleChat(true);
        });

        widget.querySelector('.aakaari-trigger-dismiss').addEventListener('click', () => {
            triggerPopup.classList.remove('show');
            state.triggerShown = true;
            sessionStorage.setItem('aakaari_trigger_dismissed', 'true');
        });

        // Pre-chat form
        widget.addEventListener('submit', (e) => {
            if (e.target.id === 'aakaari-prechat-form') {
                e.preventDefault();
                handlePrechatSubmit(e.target);
            }
        });

        // Keyboard accessibility
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && state.isOpen) {
                toggleChat(false);
            }
        });
    }

    /**
     * Bind chat events
     */
    function bindChatEvents() {
        const input = document.getElementById('aakaari-message-input');
        const sendBtn = document.getElementById('aakaari-send-btn');
        const endBtn = document.getElementById('aakaari-end-chat');
        const charCount = document.getElementById('aakaari-char-count');

        if (!input) return;

        // Auto-resize textarea
        input.addEventListener('input', () => {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 120) + 'px';

            // Update char count
            charCount.textContent = input.value.length;

            // Enable/disable send button
            sendBtn.disabled = input.value.trim().length === 0;

            // Typing indicator
            handleTyping(input.value.length > 0);
        });

        // Send on Enter (but not Shift+Enter)
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (input.value.trim()) {
                    sendMessage();
                }
            }
        });

        // Send button click
        sendBtn.addEventListener('click', () => {
            if (input.value.trim()) {
                sendMessage();
            }
        });

        // End chat
        endBtn.addEventListener('click', endChat);
    }

    /**
     * Toggle chat open/close
     */
    function toggleChat(open = null) {
        state.isOpen = open !== null ? open : !state.isOpen;

        chatWindow.classList.toggle('open', state.isOpen);
        chatButton.classList.toggle('open', state.isOpen);
        chatButton.setAttribute('aria-expanded', state.isOpen);

        if (state.isOpen) {
            // Reset unread count
            state.unreadCount = 0;
            updateUnreadBadge();

            // Focus first input
            setTimeout(() => {
                const firstInput = chatWindow.querySelector('input, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
        }
    }

    /**
     * Handle pre-chat form submission
     */
    async function handlePrechatSubmit(form) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        // Validate
        let hasError = false;
        form.querySelectorAll('.aakaari-form-group').forEach(group => {
            group.classList.remove('has-error');
        });

        if (data.name.length < 3) {
            form.querySelector('[name="name"]').closest('.aakaari-form-group').classList.add('has-error');
            hasError = true;
        }

        if (!isValidEmail(data.email)) {
            form.querySelector('[name="email"]').closest('.aakaari-form-group').classList.add('has-error');
            hasError = true;
        }

        if (data.question.length < 5) {
            form.querySelector('[name="question"]').closest('.aakaari-form-group').classList.add('has-error');
            hasError = true;
        }

        if (hasError) return;

        // Disable submit button
        const submitBtn = form.querySelector('.aakaari-form-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="aakaari-loading"></span>';

        try {
            const response = await fetch(`${config.restUrl}chat/init`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    ...data,
                    page_url: config.currentPage?.url,
                    trigger_source: state.triggerId ? `trigger_${state.triggerId}` : 'manual'
                })
            });

            const result = await response.json();

            if (result.success || result.conversation_id) {
                state.conversationId = result.conversation_id;
                state.visitorId = result.visitor_id;
                state.status = result.agent_online ? 'waiting' : 'waiting';
                state.queuePosition = result.queue_position;
                state.estimatedWait = result.estimated_wait;
                state.formData = data;

                // Save session
                saveSession();

                // Render chat interface
                renderChatInterface();

                // Start polling
                startPolling();
            } else {
                throw new Error(result.message || 'Failed to start chat');
            }
        } catch (error) {
            console.error('Chat init error:', error);
            submitBtn.disabled = false;
            submitBtn.textContent = config.i18n?.submitForm || 'Start Chatting';
            alert(error.message || 'Failed to start chat. Please try again.');
        }
    }

    /**
     * Send message
     */
    async function sendMessage() {
        const input = document.getElementById('aakaari-message-input');
        const message = input.value.trim();

        if (!message || !state.conversationId) return;

        // Clear input
        input.value = '';
        input.style.height = 'auto';
        document.getElementById('aakaari-char-count').textContent = '0';
        document.getElementById('aakaari-send-btn').disabled = true;

        // Generate a temporary ID for deduplication
        const tempId = 'temp_' + Date.now();

        // Add message to UI immediately (optimistic update)
        addMessageToUI({
            id: tempId,
            sender_type: 'visitor',
            message_text: message,
            created_at: new Date().toISOString()
        });

        // Send to server
        try {
            const response = await fetch(`${config.restUrl}chat/message`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    conversation_id: state.conversationId,
                    visitor_id: state.visitorId,
                    message: message
                })
            });

            const result = await response.json();

            // Track the real message ID to prevent duplication from polling
            if (result.message_id) {
                if (!state.displayedMessageIds) {
                    state.displayedMessageIds = new Set();
                }
                state.displayedMessageIds.add(parseInt(result.message_id));

                // Update lastMessageId to ensure polling skips this message
                if (result.message_id > state.lastMessageId) {
                    state.lastMessageId = parseInt(result.message_id);
                }
            }
        } catch (error) {
            console.error('Send message error:', error);
        }

        // Stop typing indicator
        handleTyping(false);
    }

    /**
     * Add message to UI
     */
    function addMessageToUI(message) {
        const container = document.getElementById('aakaari-messages');
        if (!container) return;

        // Remove typing indicator if present
        const typingIndicator = container.querySelector('.aakaari-typing-indicator');
        if (typingIndicator) {
            typingIndicator.closest('.aakaari-message').remove();
        }

        const div = document.createElement('div');
        div.className = `aakaari-message ${message.sender_type}`;

        const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        let content = '';

        if (message.sender_type === 'system') {
            content = `<div class="aakaari-message-bubble">${escapeHtml(message.message_text)}</div>`;
        } else {
            if (message.sender_type !== 'visitor' && message.sender_name) {
                content += `<div class="aakaari-message-sender">${escapeHtml(message.sender_name)}</div>`;
            }
            content += `<div class="aakaari-message-bubble">${escapeHtml(message.message_text)}</div>`;

            if (message.message_type === 'image' && message.file_url) {
                content += `<img src="${escapeHtml(message.file_url)}" class="aakaari-message-image" alt="Shared image">`;
            }

            content += `<div class="aakaari-message-time">${time}</div>`;
        }

        div.innerHTML = content;
        container.appendChild(div);

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;

        // Track last message ID
        if (message.id) {
            state.lastMessageId = Math.max(state.lastMessageId, parseInt(message.id));
        }
    }

    /**
     * Show typing indicator
     */
    function showTypingIndicator() {
        const container = document.getElementById('aakaari-messages');
        if (!container || container.querySelector('.aakaari-typing-indicator')) return;

        const div = document.createElement('div');
        div.className = 'aakaari-message agent';
        div.innerHTML = `
            <div class="aakaari-typing-indicator">
                <span></span><span></span><span></span>
            </div>
        `;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    /**
     * Hide typing indicator
     */
    function hideTypingIndicator() {
        const indicator = document.querySelector('.aakaari-typing-indicator');
        if (indicator) {
            indicator.closest('.aakaari-message').remove();
        }
    }

    /**
     * Handle typing indicator
     */
    async function handleTyping(isTyping) {
        if (state.isTyping === isTyping) return;
        state.isTyping = isTyping;

        try {
            await fetch(`${config.restUrl}chat/typing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    conversation_id: state.conversationId,
                    visitor_id: state.visitorId,
                    is_typing: isTyping
                })
            });
        } catch (e) {
            // Ignore typing errors
        }
    }

    /**
     * Start polling for messages
     */
    function startPolling() {
        // Track message IDs we've already displayed to prevent duplicates
        if (!state.displayedMessageIds) {
            state.displayedMessageIds = new Set();
        }

        const poll = async () => {
            if (!state.conversationId || state.status === 'ended') {
                stopPolling();
                return;
            }

            try {
                const response = await fetch(
                    `${config.restUrl}chat/poll?conversation_id=${state.conversationId}&last_id=${state.lastMessageId}&visitor_id=${state.visitorId}`,
                    {
                        headers: { 'X-WP-Nonce': config.restNonce }
                    }
                );

                const data = await response.json();

                // Update lastMessageId from server response for reliable tracking
                if (data.last_id && data.last_id > state.lastMessageId) {
                    state.lastMessageId = data.last_id;
                }

                // Add new messages (only non-visitor messages, skip already displayed)
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        // Skip visitor's own messages and already displayed messages
                        if (msg.sender_type !== 'visitor' && msg.id && !state.displayedMessageIds.has(parseInt(msg.id))) {
                            state.displayedMessageIds.add(parseInt(msg.id));
                            addMessageToUI(msg);

                            // Increment unread if not open
                            if (!state.isOpen) {
                                state.unreadCount++;
                                updateUnreadBadge();
                                playNotificationSound();
                            }
                        }
                    });
                }

                // Update typing indicator
                if (data.agent_typing && !state.agentTyping) {
                    state.agentTyping = true;
                    showTypingIndicator();
                } else if (!data.agent_typing && state.agentTyping) {
                    state.agentTyping = false;
                    hideTypingIndicator();
                }

                // Update status
                if (data.status === 'active' && state.status === 'waiting') {
                    state.status = 'active';
                    // Remove queue info
                    const queueInfo = widget.querySelector('.aakaari-queue-info');
                    if (queueInfo) queueInfo.remove();

                    // Update header
                    if (data.agent_name) {
                        widget.querySelector('.aakaari-header-title').textContent = data.agent_name;
                    }
                }

                if (data.status === 'ended') {
                    state.status = 'ended';
                    stopPolling();
                    showChatEnded();
                }
            } catch (error) {
                console.error('Poll error:', error);
            }

            if (state.pollInterval) {
                clearTimeout(state.pollInterval);
            }

            // Poll every 1 second (non-blocking server-side now)
            state.pollInterval = setTimeout(poll, 1000);
        };

        poll();
    }

    /**
     * Stop polling
     */
    function stopPolling() {
        if (state.pollInterval) {
            clearTimeout(state.pollInterval);
            state.pollInterval = null;
        }
    }

    /**
     * End chat
     */
    async function endChat() {
        if (!state.conversationId) return;

        if (!confirm('Are you sure you want to end this chat?')) return;

        try {
            await fetch(`${config.restUrl}chat/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    conversation_id: state.conversationId,
                    visitor_id: state.visitorId
                })
            });

            state.status = 'ended';
            stopPolling();
            showChatEnded();
            clearSession();
        } catch (error) {
            console.error('End chat error:', error);
        }
    }

    /**
     * Show chat ended UI
     */
    function showChatEnded() {
        const body = widget.querySelector('.aakaari-chat-body');
        const messages = document.getElementById('aakaari-messages');

        // Add ended message
        addMessageToUI({
            sender_type: 'system',
            message_text: config.i18n?.chatEnded || 'Chat ended. Thank you for contacting us!',
            created_at: new Date().toISOString()
        });

        // Remove input area
        const inputArea = widget.querySelector('.aakaari-chat-input');
        const endBtn = widget.querySelector('.aakaari-end-chat');
        if (inputArea) inputArea.remove();
        if (endBtn) endBtn.remove();

        // Add rating
        const rating = document.createElement('div');
        rating.className = 'aakaari-rating';
        rating.innerHTML = `
            <p>How was your experience?</p>
            <div class="aakaari-stars">
                ${[1,2,3,4,5].map(n => `<button data-rating="${n}">★</button>`).join('')}
            </div>
        `;
        body.appendChild(rating);

        // Rating handler
        rating.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const value = parseInt(e.target.dataset.rating);
                submitRating(value);
                rating.innerHTML = '<p>Thank you for your feedback!</p>';
            });
        });
    }

    /**
     * Submit rating
     */
    async function submitRating(rating) {
        try {
            await fetch(`${config.restUrl}chat/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    conversation_id: state.conversationId,
                    visitor_id: state.visitorId,
                    rating: rating
                })
            });
        } catch (e) {
            // Ignore rating errors
        }
    }

    /**
     * Track visitor
     */
    async function trackVisitor() {
        try {
            const response = await fetch(`${config.restUrl}visitor/track`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({
                    page_url: config.currentPage?.url,
                    referrer: document.referrer
                })
            });

            const data = await response.json();
            if (data.visitor_id) {
                state.visitorId = data.visitor_id;
            }

            // Track page visits
            const visits = parseInt(sessionStorage.getItem('aakaari_pages') || '0') + 1;
            sessionStorage.setItem('aakaari_pages', visits);
            state.pagesVisited = visits;
        } catch (e) {
            // Ignore tracking errors
        }
    }

    /**
     * Initialize triggers
     */
    function initTriggers() {
        if (!config.triggers || sessionStorage.getItem('aakaari_trigger_dismissed')) return;

        // Track time on page
        setInterval(() => {
            state.timeOnPage++;
            checkTriggers();
        }, 1000);

        // Track scroll depth
        document.addEventListener('scroll', () => {
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            state.scrollDepth = Math.round((window.scrollY / scrollHeight) * 100) || 0;
            checkTriggers();
        });

        // Exit intent (desktop only)
        if (window.innerWidth > 768) {
            document.addEventListener('mouseleave', (e) => {
                if (e.clientY < 10) {
                    checkExitIntent();
                }
            });
        }
    }

    /**
     * Check triggers
     */
    function checkTriggers() {
        if (state.triggerShown || state.isOpen || state.conversationId) return;

        const triggers = config.triggers || [];
        const pageUrl = config.currentPage?.url || '';
        const pageType = config.currentPage?.type || '';

        for (const trigger of triggers) {
            const conditions = trigger.conditions || {};
            let shouldTrigger = false;

            switch (trigger.trigger_type) {
                case 'time':
                    if (conditions.delay && state.timeOnPage >= conditions.delay) {
                        if (conditions.page === 'homepage' && pageType === 'homepage') {
                            shouldTrigger = true;
                        } else if (conditions.page_contains && pageUrl.includes(conditions.page_contains)) {
                            shouldTrigger = true;
                        } else if (!conditions.page && !conditions.page_contains) {
                            shouldTrigger = true;
                        }
                    }
                    break;

                case 'scroll':
                    if (conditions.scroll_percent && state.scrollDepth >= conditions.scroll_percent) {
                        if (!conditions.page_contains || pageUrl.includes(conditions.page_contains)) {
                            shouldTrigger = true;
                        }
                    }
                    break;

                case 'return_visitor':
                    if (conditions.min_visits && state.pagesVisited >= conditions.min_visits) {
                        if (!conditions.delay || state.timeOnPage >= conditions.delay) {
                            shouldTrigger = true;
                        }
                    }
                    break;

                case 'action_based':
                    if (conditions.pages_visited && state.pagesVisited >= conditions.pages_visited) {
                        if (!conditions.delay || state.timeOnPage >= conditions.delay) {
                            shouldTrigger = true;
                        }
                    }
                    break;
            }

            if (shouldTrigger) {
                showTrigger(trigger);
                break;
            }
        }
    }

    /**
     * Check exit intent trigger
     */
    function checkExitIntent() {
        if (state.triggerShown || state.isOpen || state.conversationId) return;

        const exitTrigger = (config.triggers || []).find(t => t.trigger_type === 'exit_intent');
        if (exitTrigger) {
            showTrigger(exitTrigger);
        }
    }

    /**
     * Show trigger popup
     */
    function showTrigger(trigger) {
        state.triggerShown = true;
        state.triggerId = trigger.id;

        triggerPopup.querySelector('p').textContent = trigger.message;
        triggerPopup.classList.add('show');

        // Record trigger shown
        recordTriggerShown(trigger.id);
    }

    /**
     * Record trigger shown
     */
    async function recordTriggerShown(triggerId) {
        // Just track locally for now
    }

    /**
     * Record trigger engagement
     */
    async function recordTriggerEngagement(triggerId) {
        try {
            await fetch(`${config.restUrl}trigger/engaged`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.restNonce
                },
                body: JSON.stringify({ trigger_id: triggerId })
            });
        } catch (e) {
            // Ignore
        }
    }

    /**
     * Update unread badge
     */
    function updateUnreadBadge() {
        const badge = widget.querySelector('.aakaari-unread-badge');
        if (state.unreadCount > 0) {
            badge.textContent = state.unreadCount > 9 ? '9+' : state.unreadCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    /**
     * Play notification sound
     */
    function playNotificationSound() {
        // Optional: Add a subtle notification sound
    }

    /**
     * Save session
     */
    function saveSession() {
        sessionStorage.setItem('aakaari_session', JSON.stringify({
            conversationId: state.conversationId,
            visitorId: state.visitorId,
            status: state.status,
            formData: state.formData
        }));
    }

    /**
     * Restore session
     */
    function restoreSession() {
        const saved = sessionStorage.getItem('aakaari_session');
        if (!saved) return;

        try {
            const data = JSON.parse(saved);
            if (data.conversationId && data.status !== 'ended') {
                state.conversationId = data.conversationId;
                state.visitorId = data.visitorId;
                state.status = data.status;
                state.formData = data.formData;

                // Render chat interface
                renderChatInterface();

                // Load existing messages from server
                loadExistingMessages().then(() => {
                    // Start polling for new messages after loading existing ones
                    startPolling();
                });
            }
        } catch (e) {
            clearSession();
        }
    }

    /**
     * Load existing messages for restored session
     */
    async function loadExistingMessages() {
        if (!state.conversationId || !state.visitorId) return;

        // Initialize displayedMessageIds set
        if (!state.displayedMessageIds) {
            state.displayedMessageIds = new Set();
        }

        try {
            // Fetch all messages by passing last_id=0
            const response = await fetch(
                `${config.restUrl}chat/poll?conversation_id=${state.conversationId}&last_id=0&visitor_id=${state.visitorId}`,
                {
                    headers: { 'X-WP-Nonce': config.restNonce }
                }
            );

            const data = await response.json();

            if (data.messages && data.messages.length > 0) {
                // Sort messages by ID to display in correct order
                const sortedMessages = data.messages.sort((a, b) => parseInt(a.id) - parseInt(b.id));

                sortedMessages.forEach(msg => {
                    const msgId = parseInt(msg.id);
                    if (!state.displayedMessageIds.has(msgId)) {
                        state.displayedMessageIds.add(msgId);
                        addMessageToUI(msg);
                    }
                });
            }

            // Update last_id from server response
            if (data.last_id) {
                state.lastMessageId = data.last_id;
            }

            // Update status
            if (data.status) {
                state.status = data.status;

                if (data.status === 'active') {
                    // Remove queue info if present
                    const queueInfo = widget.querySelector('.aakaari-queue-info');
                    if (queueInfo) queueInfo.remove();

                    // Update header with agent name
                    if (data.agent_name) {
                        widget.querySelector('.aakaari-header-title').textContent = data.agent_name;
                    }
                }

                if (data.status === 'ended') {
                    showChatEnded();
                }
            }
        } catch (error) {
            console.error('Error loading existing messages:', error);
        }
    }

    /**
     * Clear session
     */
    function clearSession() {
        sessionStorage.removeItem('aakaari_session');
    }

    /**
     * Generate form token
     */
    function generateFormToken() {
        return btoa(Date.now() + ':' + Math.random().toString(36).substr(2));
    }

    /**
     * Validate email
     */
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
