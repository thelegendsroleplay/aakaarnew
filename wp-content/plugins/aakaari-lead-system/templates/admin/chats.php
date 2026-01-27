<?php
/**
 * Admin Chats Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

$conversations = Aakaari_Chat_Handler::get_admin_conversations('active');
?>
<div class="wrap aakaari-admin aakaari-chats-page">
    <h1><?php _e('Live Chats', 'aakaari-leads'); ?></h1>

    <style>
        .aakaari-chats-page { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .aakaari-chat-layout { display: grid; grid-template-columns: 350px 1fr; gap: 20px; margin-top: 20px; min-height: 600px; }
        .aakaari-chat-list { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .aakaari-chat-list-header { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .aakaari-chat-list-header h2 { margin: 0; font-size: 16px; }
        .aakaari-chat-items { max-height: 550px; overflow-y: auto; }
        .aakaari-chat-item { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; cursor: pointer; transition: background 0.2s; }
        .aakaari-chat-item:hover { background: #f8fafc; }
        .aakaari-chat-item.active { background: #eff6ff; border-left: 3px solid #2563eb; }
        .aakaari-chat-item.waiting { border-left: 3px solid #f59e0b; }
        .aakaari-chat-item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .aakaari-chat-item-name { font-weight: 600; color: #1e293b; }
        .aakaari-chat-item-time { font-size: 12px; color: #94a3b8; }
        .aakaari-chat-item-preview { font-size: 13px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .aakaari-chat-item-meta { display: flex; gap: 8px; margin-top: 8px; }
        .aakaari-badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 500; }
        .aakaari-badge.waiting { background: #fef3c7; color: #92400e; }
        .aakaari-badge.active { background: #d1fae5; color: #065f46; }
        .aakaari-badge.hot { background: #fef2f2; color: #dc2626; }
        .aakaari-badge.warm { background: #fffbeb; color: #d97706; }
        .aakaari-badge.cold { background: #f0f9ff; color: #0284c7; }
        .aakaari-unread { background: #2563eb; color: #fff; min-width: 18px; height: 18px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; }

        .aakaari-chat-detail { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; flex-direction: column; }
        .aakaari-chat-detail-header { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .aakaari-chat-detail-header h2 { margin: 0; font-size: 16px; }
        .aakaari-chat-detail-actions { display: flex; gap: 8px; }
        .aakaari-chat-detail-actions button { padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: #fff; cursor: pointer; font-size: 13px; transition: all 0.2s; }
        .aakaari-chat-detail-actions button:hover { background: #f8fafc; }
        .aakaari-chat-detail-actions button.primary { background: #2563eb; color: #fff; border-color: #2563eb; }
        .aakaari-chat-detail-actions button.primary:hover { background: #1d4ed8; }
        .aakaari-chat-detail-actions button.danger { color: #dc2626; border-color: #fecaca; }
        .aakaari-chat-detail-actions button.danger:hover { background: #fef2f2; }

        .aakaari-visitor-info { padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .aakaari-visitor-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .aakaari-visitor-info-item { font-size: 13px; }
        .aakaari-visitor-info-item label { display: block; color: #64748b; font-size: 11px; margin-bottom: 2px; }
        .aakaari-visitor-info-item span { color: #1e293b; font-weight: 500; }

        .aakaari-messages-container { flex: 1; overflow-y: auto; padding: 20px; background: #f8fafc; min-height: 300px; max-height: 400px; }
        .aakaari-message { max-width: 70%; margin-bottom: 12px; }
        .aakaari-message.visitor { margin-right: auto; }
        .aakaari-message.agent { margin-left: auto; }
        .aakaari-message-bubble { padding: 12px 16px; border-radius: 12px; }
        .aakaari-message.visitor .aakaari-message-bubble { background: #fff; border: 1px solid #e2e8f0; }
        .aakaari-message.agent .aakaari-message-bubble { background: #2563eb; color: #fff; }
        .aakaari-message.system .aakaari-message-bubble { background: #f1f5f9; color: #64748b; text-align: center; max-width: 100%; font-size: 13px; }
        .aakaari-message-time { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .aakaari-message.agent .aakaari-message-time { text-align: right; }
        .aakaari-typing { display: flex; gap: 4px; padding: 12px 16px; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; width: fit-content; }
        .aakaari-typing span { width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; animation: typing 1.4s infinite; }
        .aakaari-typing span:nth-child(2) { animation-delay: 0.2s; }
        .aakaari-typing span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typing { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-5px); } }

        .aakaari-chat-input { padding: 16px 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 12px; }
        .aakaari-chat-input textarea { flex: 1; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; resize: none; font-family: inherit; font-size: 14px; }
        .aakaari-chat-input textarea:focus { outline: none; border-color: #2563eb; }
        .aakaari-chat-input button { padding: 12px 24px; background: #2563eb; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; }
        .aakaari-chat-input button:hover { background: #1d4ed8; }
        .aakaari-chat-input button:disabled { background: #94a3b8; cursor: not-allowed; }

        .aakaari-canned-dropdown { position: relative; }
        .aakaari-canned-btn { padding: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; }
        .aakaari-canned-menu { position: absolute; bottom: 100%; left: 0; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px; max-height: 300px; overflow-y: auto; display: none; z-index: 10; }
        .aakaari-canned-menu.open { display: block; }
        .aakaari-canned-item { padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #f1f5f9; }
        .aakaari-canned-item:hover { background: #f8fafc; }
        .aakaari-canned-item strong { display: block; font-size: 13px; margin-bottom: 2px; }
        .aakaari-canned-item span { font-size: 12px; color: #64748b; }

        .aakaari-notes-section { padding: 16px 20px; border-top: 1px solid #e2e8f0; background: #fffbeb; }
        .aakaari-notes-section h4 { margin: 0 0 8px; font-size: 13px; color: #92400e; }
        .aakaari-notes-section textarea { width: 100%; padding: 8px; border: 1px solid #fde68a; border-radius: 6px; resize: none; font-size: 13px; background: #fff; }

        .aakaari-empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 400px; color: #64748b; }
        .aakaari-empty-state .dashicons { font-size: 48px; width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5; }
    </style>

    <div class="aakaari-chat-layout">
        <!-- Chat List -->
        <div class="aakaari-chat-list">
            <div class="aakaari-chat-list-header">
                <h2>Conversations</h2>
                <span id="chat-count"><?php echo count($conversations); ?></span>
            </div>
            <div class="aakaari-chat-items" id="chat-list">
                <?php if (empty($conversations)): ?>
                    <div class="aakaari-empty-state" style="padding: 40px;">
                        <span class="dashicons dashicons-format-chat"></span>
                        <p>No active chats</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($conversations as $chat): ?>
                        <div class="aakaari-chat-item <?php echo $chat['status']; ?>"
                             data-id="<?php echo esc_attr($chat['id']); ?>"
                             onclick="loadChat(<?php echo esc_attr($chat['id']); ?>)">
                            <div class="aakaari-chat-item-header">
                                <span class="aakaari-chat-item-name"><?php echo esc_html($chat['visitor_name'] ?: 'Visitor'); ?></span>
                                <span class="aakaari-chat-item-time"><?php echo human_time_diff(strtotime($chat['started_at'])); ?></span>
                            </div>
                            <div class="aakaari-chat-item-preview"><?php echo esc_html($chat['visitor_email'] ?: 'No email'); ?></div>
                            <div class="aakaari-chat-item-meta">
                                <span class="aakaari-badge <?php echo $chat['status']; ?>">
                                    <?php echo esc_html(ucfirst($chat['status'])); ?>
                                </span>
                                <?php
                                $temp = 'cold';
                                if ($chat['lead_score'] >= 80) $temp = 'hot';
                                elseif ($chat['lead_score'] >= 50) $temp = 'warm';
                                ?>
                                <span class="aakaari-badge <?php echo $temp; ?>">
                                    <?php echo esc_html($chat['lead_score']); ?> pts
                                </span>
                                <?php if ($chat['unread_count'] > 0): ?>
                                    <span class="aakaari-unread"><?php echo esc_html($chat['unread_count']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Chat Detail -->
        <div class="aakaari-chat-detail" id="chat-detail">
            <div class="aakaari-empty-state">
                <span class="dashicons dashicons-format-chat"></span>
                <p>Select a chat to view details</p>
            </div>
        </div>
    </div>
</div>

<script>
const restUrl = '<?php echo rest_url('aakaari/v1/'); ?>';
const restNonce = '<?php echo wp_create_nonce('wp_rest'); ?>';
const agentId = <?php echo get_current_user_id(); ?>;

let currentChatId = null;
let lastMessageId = 0;
let pollInterval = null;
let lastPollTimestamp = null;
let cannedResponses = [];

// Load canned responses
fetch(restUrl + 'admin/canned', {
    headers: { 'X-WP-Nonce': restNonce }
})
.then(r => r.json())
.then(data => { cannedResponses = data; });

function loadChat(id) {
    currentChatId = id;
    lastMessageId = 0;

    // Update active state
    document.querySelectorAll('.aakaari-chat-item').forEach(el => el.classList.remove('active'));
    document.querySelector(`.aakaari-chat-item[data-id="${id}"]`)?.classList.add('active');

    fetch(restUrl + 'admin/conversation/' + id, {
        headers: { 'X-WP-Nonce': restNonce }
    })
    .then(r => r.json())
    .then(chat => {
        renderChatDetail(chat);
        startPolling();
    });
}

function renderChatDetail(chat) {
    const detail = document.getElementById('chat-detail');
    const visitor = chat.visitor || {};
    const isWaiting = chat.status === 'waiting';

    detail.innerHTML = `
        <div class="aakaari-chat-detail-header">
            <h2>${escapeHtml(visitor.name || 'Visitor')}</h2>
            <div class="aakaari-chat-detail-actions">
                ${isWaiting ? `<button class="primary" onclick="acceptChat(${chat.id})">Accept Chat</button>
                <button class="danger" onclick="rejectChat(${chat.id})">Reject Chat</button>` : ''}
                <button onclick="convertToTicket(${chat.id})">Create Ticket</button>
                <button class="danger" onclick="endChat(${chat.id})">End Chat</button>
            </div>
        </div>

        <div class="aakaari-visitor-info">
            <div class="aakaari-visitor-info-grid">
                <div class="aakaari-visitor-info-item">
                    <label>Email</label>
                    <span>${escapeHtml(visitor.email || '-')}</span>
                </div>
                <div class="aakaari-visitor-info-item">
                    <label>Current Page</label>
                    <span>${escapeHtml(visitor.current_page || '-')}</span>
                </div>
                <div class="aakaari-visitor-info-item">
                    <label>Device</label>
                    <span>${escapeHtml(visitor.device_type || '-')}</span>
                </div>
                <div class="aakaari-visitor-info-item">
                    <label>Location</label>
                    <span>${escapeHtml((visitor.location_city || '') + ', ' + (visitor.location_country || '-'))}</span>
                </div>
                <div class="aakaari-visitor-info-item">
                    <label>Source</label>
                    <span>${escapeHtml(visitor.how_found_us || '-')}</span>
                </div>
                <div class="aakaari-visitor-info-item">
                    <label>Lead Score</label>
                    <span class="aakaari-badge ${chat.lead_score >= 80 ? 'hot' : chat.lead_score >= 50 ? 'warm' : 'cold'}">
                        ${chat.lead_score || 0} points
                    </span>
                </div>
            </div>
        </div>

        <div class="aakaari-messages-container" id="messages-container">
            ${renderMessages(chat.messages || [])}
        </div>

        ${!isWaiting ? `
        <div class="aakaari-chat-input">
            <div class="aakaari-canned-dropdown">
                <button type="button" class="aakaari-canned-btn" onclick="toggleCanned()">📝</button>
                <div class="aakaari-canned-menu" id="canned-menu">
                    ${cannedResponses.map(r => `
                        <div class="aakaari-canned-item" onclick="insertCanned('${escapeHtml(r.message_text).replace(/'/g, "\\'")}')">
                            <strong>${escapeHtml(r.title)}</strong>
                            <span>${escapeHtml(r.message_text.substring(0, 50))}...</span>
                        </div>
                    `).join('')}
                </div>
            </div>
            <textarea id="message-input" placeholder="Type your message..." rows="2"></textarea>
            <button onclick="sendMessage()">Send</button>
        </div>
        ` : ''}

        <div class="aakaari-notes-section">
            <h4>Internal Notes</h4>
            <textarea id="internal-notes" rows="2" placeholder="Add notes (not visible to visitor)..."
                      onchange="saveNotes(${chat.id}, this.value)">${escapeHtml(chat.internal_notes || '')}</textarea>
        </div>
    `;

    // Scroll to bottom
    const container = document.getElementById('messages-container');
    if (container) container.scrollTop = container.scrollHeight;

    // Track last message ID
    if (chat.messages && chat.messages.length > 0) {
        lastMessageId = Math.max(...chat.messages.map(m => parseInt(m.id)));
    }

    // Bind enter key
    const input = document.getElementById('message-input');
    if (input) {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }
}

function renderMessages(messages) {
    return messages.map(msg => {
        const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const type = msg.sender_type;

        if (type === 'system') {
            return `<div class="aakaari-message system"><div class="aakaari-message-bubble">${escapeHtml(msg.message_text)}</div></div>`;
        }

        return `
            <div class="aakaari-message ${type}">
                <div class="aakaari-message-bubble">${escapeHtml(msg.message_text)}</div>
                <div class="aakaari-message-time">${time}</div>
            </div>
        `;
    }).join('');
}

function acceptChat(id) {
    fetch(restUrl + 'admin/conversation/' + id + '/accept', {
        method: 'POST',
        headers: { 'X-WP-Nonce': restNonce }
    })
    .then(r => r.json())
    .then(() => {
        loadChat(id);
        refreshChatList();
    });
}

function rejectChat(id) {
    if (!confirm('Reject this chat request?')) return;

    fetch(restUrl + 'admin/conversation/' + id + '/reject', {
        method: 'POST',
        headers: { 'X-WP-Nonce': restNonce }
    })
    .then(r => r.json())
    .then(() => {
        currentChatId = null;
        document.getElementById('chat-detail').innerHTML = `
            <div class="aakaari-empty-state">
                <span class="dashicons dashicons-dismiss"></span>
                <p>Chat request rejected</p>
            </div>
        `;
        refreshChatList();
    });
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    if (!message || !currentChatId) return;

    input.value = '';

    // Add to UI immediately
    const container = document.getElementById('messages-container');
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    container.innerHTML += `
        <div class="aakaari-message agent">
            <div class="aakaari-message-bubble">${escapeHtml(message)}</div>
            <div class="aakaari-message-time">${time}</div>
        </div>
    `;
    container.scrollTop = container.scrollHeight;

    // Send to server
    fetch(restUrl + 'admin/conversation/' + currentChatId + '/message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce
        },
        body: JSON.stringify({ message: message })
    });
}

function endChat(id) {
    if (!confirm('Are you sure you want to end this chat?')) return;

    fetch(restUrl + 'admin/conversation/' + id + '/end', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce
        },
        body: JSON.stringify({ outcome: 'closed' })
    })
    .then(() => {
        currentChatId = null;
        document.getElementById('chat-detail').innerHTML = `
            <div class="aakaari-empty-state">
                <span class="dashicons dashicons-yes-alt"></span>
                <p>Chat ended successfully</p>
            </div>
        `;
        refreshChatList();
    });
}

function convertToTicket(id) {
    const title = prompt('Ticket title:', 'Chat inquiry');
    if (!title) return;

    fetch(restUrl + 'admin/conversation/' + id + '/ticket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce
        },
        body: JSON.stringify({ title: title })
    })
    .then(r => r.json())
    .then(data => {
        alert('Ticket created: #' + data.ticket_number);
    });
}

function saveNotes(id, notes) {
    fetch(restUrl + 'admin/conversation/' + id + '/notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce
        },
        body: JSON.stringify({ notes: notes })
    });
}

function toggleCanned() {
    document.getElementById('canned-menu').classList.toggle('open');
}

function insertCanned(text) {
    document.getElementById('message-input').value = text;
    document.getElementById('canned-menu').classList.remove('open');
}

function startPolling() {
    if (pollInterval) clearInterval(pollInterval);

    pollInterval = setInterval(() => {
        if (!currentChatId) return;

        const sinceParam = lastPollTimestamp
            ? '?since=' + encodeURIComponent(lastPollTimestamp)
            : '';

        fetch(restUrl + 'admin/poll' + sinceParam, {
            headers: { 'X-WP-Nonce': restNonce }
        })
        .then(r => r.json())
        .then(data => {
            // Handle new messages
            if (data.new_messages) {
                data.new_messages.forEach(msg => {
                    if (msg.conversation_id == currentChatId && parseInt(msg.id) > lastMessageId) {
                        const container = document.getElementById('messages-container');
                        if (container) {
                            const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                            container.innerHTML += `
                                <div class="aakaari-message visitor">
                                    <div class="aakaari-message-bubble">${escapeHtml(msg.message_text)}</div>
                                    <div class="aakaari-message-time">${time}</div>
                                </div>
                            `;
                            container.scrollTop = container.scrollHeight;
                            lastMessageId = parseInt(msg.id);
                        }
                    }
                });
            }

            // Handle new chats
            if (data.new_chats && data.new_chats.length > 0) {
                refreshChatList();
                // Play notification sound
                if (Notification.permission === 'granted') {
                    new Notification('New chat request', {
                        body: data.new_chats[0].visitor_name + ' is waiting',
                        icon: '/favicon.ico'
                    });
                }
            }

            if (data.timestamp) {
                lastPollTimestamp = data.timestamp;
            }
        });
    }, 3000);
}

function refreshChatList() {
    fetch(restUrl + 'admin/conversations?status=active', {
        headers: { 'X-WP-Nonce': restNonce }
    })
    .then(r => r.json())
    .then(chats => {
        const list = document.getElementById('chat-list');
        document.getElementById('chat-count').textContent = chats.length;

        if (chats.length === 0) {
            list.innerHTML = `
                <div class="aakaari-empty-state" style="padding: 40px;">
                    <span class="dashicons dashicons-format-chat"></span>
                    <p>No active chats</p>
                </div>
            `;
            return;
        }

        list.innerHTML = chats.map(chat => {
            const temp = chat.lead_score >= 80 ? 'hot' : chat.lead_score >= 50 ? 'warm' : 'cold';
            return `
                <div class="aakaari-chat-item ${chat.status} ${chat.id == currentChatId ? 'active' : ''}"
                     data-id="${chat.id}"
                     onclick="loadChat(${chat.id})">
                    <div class="aakaari-chat-item-header">
                        <span class="aakaari-chat-item-name">${escapeHtml(chat.visitor_name || 'Visitor')}</span>
                        <span class="aakaari-chat-item-time">${timeAgo(chat.started_at)}</span>
                    </div>
                    <div class="aakaari-chat-item-preview">${escapeHtml(chat.visitor_email || 'No email')}</div>
                    <div class="aakaari-chat-item-meta">
                        <span class="aakaari-badge ${chat.status}">${chat.status}</span>
                        <span class="aakaari-badge ${temp}">${chat.lead_score} pts</span>
                        ${chat.unread_count > 0 ? `<span class="aakaari-unread">${chat.unread_count}</span>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    });
}

function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
    if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
    return Math.floor(seconds / 86400) + 'd ago';
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Request notification permission
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

// Start polling
startPolling();

// Close canned menu on outside click
document.addEventListener('click', (e) => {
    if (!e.target.closest('.aakaari-canned-dropdown')) {
        document.getElementById('canned-menu')?.classList.remove('open');
    }
});
</script>
