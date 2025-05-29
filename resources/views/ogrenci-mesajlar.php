<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlaşma - EduCoach</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f7fe;
            color: #333;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        
        @media (min-width: 768px) {
            body {
                flex-direction: row;
            }
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 100%;
            background-color: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #e1e1e1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        @media (min-width: 768px) {
            .sidebar {
                width: 250px;
                height: 100vh;
                position: sticky;
                top: 0;
                padding: 30px 0;
                border-right: 1px solid #e1e1e1;
                border-bottom: none;
                box-shadow: 2px 0 5px rgba(0,0,0,0.05);
                overflow-y: auto;
            }
        }
        
        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 15px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
        }
        
        @media (min-width: 768px) {
            .logo {
                padding: 0 20px 30px;
                margin-bottom: 20px;
            }
        }
        
        .logo svg {
            margin-right: 10px;
        }
        
        .logo h1 {
            font-size: 24px;
            color: #6c4ab6;
            font-weight: 600;
        }
        
        .menu {
            list-style: none;
            margin-bottom: 0;
            padding-left: 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        @media (min-width: 768px) {
            .menu-item {
                padding: 15px 20px;
            }
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: #6c4ab6;
            color: white;
        }
        
        .menu-item svg {
            margin-right: 10px;
        }
        
        /* Toggle button for mobile */
        .sidebar-toggle {
            display: block;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #6c4ab6;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        @media (min-width: 768px) {
            .sidebar-toggle {
                display: none;
            }
        }
        
        /* For mobile view */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            body.sidebar-open {
                overflow: hidden;
            }
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-top: 15px;
        }
        
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
                margin-top: 0;
            }
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }
        
        /* Messaging Styles */
        .messaging-container {
            display: flex;
            height: calc(100vh - 150px);
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }
        
        .coach-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            background-color: #6c4ab6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 20px;
        }
        
        .coach-name {
            font-size: 18px;
            font-weight: 600;
        }
        
        .coach-role {
            font-size: 14px;
            color: #666;
        }
        
        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .message {
            max-width: 40%;
            padding: 12px 16px;
            border-radius: 18px;
            margin-bottom: 15px;
            position: relative;
            word-break: break-word;
        }
        
        .message.received {
            align-self: flex-start;
            background-color: #f0f0f0;
            color: #333;
            border-bottom-left-radius: 4px;
            margin-right: auto;
        }
        
        .message.sent {
            align-self: flex-end;
            background-color: #6c4ab6;
            color: white;
            border-bottom-right-radius: 4px;
            margin-left: auto;
        }
        
        .message-time {
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.7;
        }
        
        .message.received .message-time {
            text-align: left;
        }
        
        .message.sent .message-time {
            text-align: right;
        }
        
        .chat-footer {
            padding: 15px 20px;
            border-top: 1px solid #f0f0f0;
        }
        
        .message-form {
            display: flex;
            gap: 10px;
        }
        
        .message-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            border-radius: 24px;
            font-size: 15px;
            resize: none;
            min-height: 45px;
            max-height: 120px;
            outline: none;
            transition: border-color 0.3s;
        }
        
        .message-input:focus {
            border-color: #6c4ab6;
        }
        
        .send-button {
            background-color: #6c4ab6;
            color: white;
            border: none;
            border-radius: 24px;
            padding: 0 20px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .send-button:hover {
            background-color: #5a3d99;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #888;
            text-align: center;
            padding: 20px;
        }
        
        .empty-state-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
        
        .empty-state-text {
            font-size: 16px;
            max-width: 300px;
            line-height: 1.5;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Logout Button Style */
        .logout-button {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 12px 20px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logout-button:hover {
            background-color: #6c4ab6;
            color: white;
        }
        
        .logout-button svg {
            margin-right: 10px;
            fill: currentColor;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#6c4ab6">
                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z"/>
            </svg>
            <h1>EduCoach</h1>
        </div>
        
        <ul class="menu">
            <li>
                <a href="/ogrenci-panel" class="menu-item <?php echo $active_page === 'gorevler' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z"/>
                        <path d="M7 12H9V17H7V12Z"/>
                        <path d="M15 7H17V17H15V7Z"/>
                        <path d="M11 14H13V17H11V14Z"/>
                        <path d="M11 10H13V12H11V10Z"/>
                    </svg>
                    Görevlerim
                </a>
            </li>
            <li>
                <a href="/ogrenci/mesajlar" class="menu-item <?php echo $active_page === 'mesajlar' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                    </svg>
                    Mesajlaşma
                </a>
            </li>
            <?php if (Auth::user()->alan !== null): ?>
            <li>
                <a href="/ogrenci/siralama" class="menu-item <?php echo $active_page === 'siralama' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2 20h20v-4H2v4zm2-3h2v2H4v-2zM2 4v4h20V4H2zm4 3H4V5h2v2zm-4 7h20v-4H2v4zm2-3h2v2H4v-2z"/>
                    </svg>
                    Sıralama
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="/istatistikler" class="menu-item <?php echo $active_page === 'istatistikler' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z"/>
                        <path d="M7 12H9V17H7V12Z"/>
                        <path d="M15 7H17V17H15V7Z"/>
                        <path d="M11 14H13V17H11V14Z"/>
                        <path d="M11 10H13V12H11V10Z"/>
                    </svg>
                    İstatistikler
                </a>
            </li>
            <li>
                <a href="/profilim" class="menu-item <?php echo $active_page === 'profilim' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 6C13.1 6 14 6.9 14 8C14 9.1 13.1 10 12 10C10.9 10 10 9.1 10 8C10 6.9 10.9 6 12 6ZM12 13C9.33 13 4 14.34 4 17V20H20V17C20 14.34 14.67 13 12 13ZM18 18H6V17.01C6.2 16.29 9.3 15 12 15C14.7 15 17.8 16.29 18 17V18Z"/>
                    </svg>
                    Profilim
                </a>
            </li>
            <li>
                <form action="/logout" method="POST" style="margin: 0;">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="logout-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12L17 7Z"/>
                            <path d="M4 19H12V21H4C2.9 21 2 20.1 2 19V5C2 3.9 2.9 3 4 3H12V5H4V19Z"/>
                        </svg>
                        Çıkış Yap
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="section-title">Mesajlaşma</h2>
        
        <?php if (session('success')): ?>
            <div class="alert alert-success">
                <?php echo session('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if (session('error')): ?>
            <div class="alert alert-danger">
                <?php echo session('error'); ?>
            </div>
        <?php endif; ?>
        
        <div class="messaging-container">
            <div style="width: 100%; display: flex; flex-direction: column;">
                <!-- Chat Header -->
                <div class="chat-header">
                    <?php if ($koc->profile_photo): ?>
                        <img src="<?php echo asset($koc->profile_photo); ?>" alt="<?php echo $koc->name; ?>" class="coach-avatar" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <span class="coach-avatar" style="display:none;"> <?php echo mb_strtoupper(mb_substr($koc->name,0,1)); ?> </span>
                    <?php else: ?>
                        <span class="coach-avatar"> <?php echo mb_strtoupper(mb_substr($koc->name,0,1)); ?> </span>
                    <?php endif; ?>
                    <div>
                        <div class="coach-name"><?php echo $koc->name; ?></div>
                        <div class="coach-role">Koç</div>
                    </div>
                </div>
                
                <!-- Chat Body -->
                <div class="chat-body" id="chat-body">
                    <div id="messages-container">
                        <?php if (count($mesajlar) > 0): ?>
                            <?php foreach ($mesajlar as $mesaj): ?>
                                <?php 
                                    $isSent = $mesaj->gonderen_id === $user->id;
                                    $messageClass = $isSent ? 'sent' : 'received';
                                    $messageDate = \Carbon\Carbon::parse($mesaj->tarih);
                                    $formattedDate = $messageDate->format('d.m.Y H:i');
                                ?>
                                <div class="message <?php echo $messageClass; ?>">
                                    <?php echo nl2br(htmlspecialchars($mesaj->mesaj)); ?>
                                    <div class="message-time"><?php echo $formattedDate; ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state" id="empty-state">
                                <div class="empty-state-icon">💬</div>
                                <div class="empty-state-text">
                                    Henüz hiç mesaj yok. Koçunuz ile ilk mesajlaşmayı başlatmak için aşağıdaki metin kutusuna bir mesaj yazın.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Chat Footer -->
                <div class="chat-footer">
                    <form id="message-form" class="message-form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <textarea name="mesaj" id="message-input" class="message-input" placeholder="Mesajınızı yazın..." required></textarea>
                        <button type="submit" class="send-button">Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Toggle Button for Mobile -->
    <button class="sidebar-toggle d-md-none" id="sidebarToggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
        </svg>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle Functionality
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    body.classList.toggle('sidebar-open');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    body.classList.remove('sidebar-open');
                }
            });
            
            // Messaging functionality
            const chatBody = document.getElementById('chat-body');
            chatBody.scrollTop = chatBody.scrollHeight;
            
            // Make textarea auto-expand
            const textarea = document.querySelector('.message-input');
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Setup real-time message polling
            setupRealTimeMessaging();
            
            // Setup message form submission
            setupMessageForm();
        });
        
        // Real-time messaging with polling
        function setupRealTimeMessaging() {
            // Keep track of the last message ID to detect new messages
            let lastMessageId = 0;
            let messagesContainer = document.getElementById('messages-container');
            
            // Determine the last message ID from initial messages
            const initialMessages = document.querySelectorAll('.message');
            if (initialMessages.length > 0) {
                // Instead of using an ID, we'll just use the count of messages
                lastMessageId = initialMessages.length;
            }
            
            // Poll for new messages every 5 seconds
            setInterval(fetchMessages, 5000);
            
            function fetchMessages() {
                fetch('/ogrenci/mesajlar/veri')
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            return;
                        }
                        
                        // If we have more messages now than before, update the UI
                        if (data.length > lastMessageId) {
                            updateMessagesUI(data);
                            lastMessageId = data.length;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching messages:', error);
                    });
            }
            
            function updateMessagesUI(messages) {
                // Clear the empty state if it exists
                const emptyState = document.getElementById('empty-state');
                if (emptyState) {
                    emptyState.remove();
                }
                
                // Clear existing messages
                messagesContainer.innerHTML = '';
                
                // Add all messages
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.className = 'message ' + (message.isSent ? 'sent' : 'received');
                    
                    // Add message content (with newlines preserved)
                    messageElement.innerHTML = message.message.replace(/\n/g, '<br>');
                    
                    // Add timestamp
                    const timeElement = document.createElement('div');
                    timeElement.className = 'message-time';
                    timeElement.textContent = message.time;
                    messageElement.appendChild(timeElement);
                    
                    messagesContainer.appendChild(messageElement);
                });
                
                // Scroll to bottom
                const chatBody = document.getElementById('chat-body');
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }
        
        // Handle message form submission
        function setupMessageForm() {
            const form = document.getElementById('message-form');
            const input = document.getElementById('message-input');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!input.value.trim()) {
                    return;
                }
                
                // Get form data
                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('mesaj', input.value);
                
                // Send the message
                fetch('/ogrenci/mesaj-gonder', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Clear the input
                        input.value = '';
                        input.style.height = 'auto';
                        
                        // Immediately fetch messages to show the sent message
                        fetch('/ogrenci/mesajlar/veri')
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    const messagesContainer = document.getElementById('messages-container');
                                    
                                    // Clear the empty state if it exists
                                    const emptyState = document.getElementById('empty-state');
                                    if (emptyState) {
                                        emptyState.remove();
                                    }
                                    
                                    // Clear existing messages
                                    messagesContainer.innerHTML = '';
                                    
                                    // Add all messages
                                    data.forEach(message => {
                                        const messageElement = document.createElement('div');
                                        messageElement.className = 'message ' + (message.isSent ? 'sent' : 'received');
                                        
                                        // Add message content (with newlines preserved)
                                        messageElement.innerHTML = message.message.replace(/\n/g, '<br>');
                                        
                                        // Add timestamp
                                        const timeElement = document.createElement('div');
                                        timeElement.className = 'message-time';
                                        timeElement.textContent = message.time;
                                        messageElement.appendChild(timeElement);
                                        
                                        messagesContainer.appendChild(messageElement);
                                    });
                                    
                                    // Scroll to bottom
                                    const chatBody = document.getElementById('chat-body');
                                    chatBody.scrollTop = chatBody.scrollHeight;
                                }
                            });
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            });
        }
    </script>
</body>
</html>
