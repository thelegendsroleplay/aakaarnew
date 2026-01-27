/**
 * Aakaari Admin Chat Handler
 * Integrates with existing admin dashboard
 */

(function() {
    'use strict';

    const config = window.aakaariAdmin || {};

    const state = {
        currentConversationId: null,
        lastMessageId: 0,
        lastCheckTime: null,
        pollInterval: null,
        agentStatus: 'available'
    };

    /**
     * Initialize admin chat functionality
     */
    function init() {
        // Set agent status to available on page load
        setAgentStatus('available');

        // Start polling for updates
        startPolling();

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        // Handle page visibility
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                // Refresh data when tab becomes visible
                pollForUpdates();
            }
        });

        // Handle beforeunload - set offline
        window.addEventListener('beforeunload', () => {
            setAgentStatus('offline');
        });

        console.log('Aakaari Admin Chat initialized');
    }

    /**
     * Set agent status
     */
    function setAgentStatus(status) {
        state.agentStatus = status;

        fetch(config.restUrl + 'admin/status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': config.restNonce
            },
            body: JSON.stringify({ status: status })
        }).catch(console.error);
    }

    /**
     * Start polling for updates
     */
    function startPolling() {
        if (state.pollInterval) return;

        state.lastCheckTime = new Date().toISOString();

        const poll = () => {
            pollForUpdates();
        };

        // Poll every 3 seconds
        state.pollInterval = setInterval(poll, config.pollInterval || 3000);

        // Also poll immediately
        poll();
    }

    /**
     * Poll for updates
     */
    async function pollForUpdates() {
        try {
            const response = await fetch(
                `${config.restUrl}admin/poll?since=${encodeURIComponent(state.lastCheckTime)}`,
                {
                    headers: { 'X-WP-Nonce': config.restNonce }
                }
            );

            const data = await response.json();

            // Handle new chats
            if (data.new_chats && data.new_chats.length > 0) {
                data.new_chats.forEach(chat => {
                    showNewChatNotification(chat);
                });
            }

            // Handle new messages for current conversation
            if (data.new_messages && state.currentConversationId) {
                data.new_messages.forEach(msg => {
                    if (msg.conversation_id == state.currentConversationId) {
                        // Add to chat UI if exists
                        addMessageToUI(msg);
                    }
                });
            }

            // Update last check time
            if (data.timestamp) {
                state.lastCheckTime = data.timestamp;
            }

        } catch (error) {
            console.error('Poll error:', error);
        }
    }

    /**
     * Show notification for new chat
     */
    function showNewChatNotification(chat) {
        // Browser notification
        if (Notification.permission === 'granted') {
            const notification = new Notification('New Chat Request', {
                body: `${chat.visitor_name || 'Visitor'} is waiting to chat`,
                icon: '/favicon.ico',
                tag: 'aakaari-chat-' + chat.id
            });

            notification.onclick = () => {
                window.focus();
                notification.close();
                // Could navigate to chat or open modal
            };
        }

        // Also show toast notification
        showToast(`New chat from ${chat.visitor_name || 'Visitor'}`, 'warning');

        // Update page title
        updatePageTitle();
    }

    /**
     * Show toast notification
     */
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `aakaari-toast ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;cursor:pointer;margin-left:12px;">&times;</button>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    /**
     * Update page title with notification count
     */
    function updatePageTitle() {
        // Could be enhanced to show unread count
    }

    /**
     * Add message to chat UI
     */
    function addMessageToUI(msg) {
        const container = document.getElementById('aakaari-messages') ||
                          document.getElementById('messages-container');

        if (!container) return;

        if (parseInt(msg.id) <= state.lastMessageId) return;

        const time = new Date(msg.created_at).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        const div = document.createElement('div');
        div.className = `aakaari-message ${msg.sender_type}`;
        div.innerHTML = `
            <div class="aakaari-message-bubble">${escapeHtml(msg.message_text)}</div>
            <div class="aakaari-message-time">${time}</div>
        `;

        container.appendChild(div);
        container.scrollTop = container.scrollHeight;

        state.lastMessageId = parseInt(msg.id);

        // Play sound if visitor message
        if (msg.sender_type === 'visitor') {
            playNotificationSound();
        }
    }

    /**
     * Play notification sound
     */
    function playNotificationSound() {
        // Could add an audio notification here
    }

    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Load conversation
     */
    window.aakaariLoadConversation = function(id) {
        state.currentConversationId = id;
        state.lastMessageId = 0;

        fetch(`${config.restUrl}admin/conversation/${id}`, {
            headers: { 'X-WP-Nonce': config.restNonce }
        })
        .then(r => r.json())
        .then(data => {
            // Render conversation - this would be handled by page-specific code
            if (window.renderConversation) {
                window.renderConversation(data);
            }

            // Track last message ID
            if (data.messages && data.messages.length > 0) {
                state.lastMessageId = Math.max(...data.messages.map(m => parseInt(m.id)));
            }
        })
        .catch(console.error);
    };

    /**
     * Send message
     */
    window.aakaariSendMessage = function(conversationId, message) {
        if (!message.trim()) return Promise.reject('Empty message');

        return fetch(`${config.restUrl}admin/conversation/${conversationId}/message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': config.restNonce
            },
            body: JSON.stringify({ message: message })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Add to UI immediately
                addMessageToUI({
                    id: data.message_id,
                    sender_type: 'agent',
                    message_text: message,
                    created_at: new Date().toISOString()
                });
            }
            return data;
        });
    };

    /**
     * Accept chat
     */
    window.aakaariAcceptChat = function(conversationId) {
        return fetch(`${config.restUrl}admin/conversation/${conversationId}/accept`, {
            method: 'POST',
            headers: { 'X-WP-Nonce': config.restNonce }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Chat accepted', 'success');
            }
            return data;
        });
    };

    /**
     * End chat
     */
    window.aakaariEndChat = function(conversationId, outcome = 'closed') {
        return fetch(`${config.restUrl}admin/conversation/${conversationId}/end`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': config.restNonce
            },
            body: JSON.stringify({ outcome: outcome })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                state.currentConversationId = null;
                showToast('Chat ended', 'success');
            }
            return data;
        });
    };

    /**
     * Get conversations
     */
    window.aakaariGetConversations = function(status = 'active') {
        return fetch(`${config.restUrl}admin/conversations?status=${status}`, {
            headers: { 'X-WP-Nonce': config.restNonce }
        })
        .then(r => r.json());
    };

    /**
     * Get stats
     */
    window.aakaariGetStats = function() {
        return fetch(`${config.restUrl}admin/stats`, {
            headers: { 'X-WP-Nonce': config.restNonce }
        })
        .then(r => r.json());
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
