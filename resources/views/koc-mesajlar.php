<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlar - Koç Paneli</title>
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
            background-color: #f5f0e8;
            color: #5a4a3f;
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
            background-color: #8B6B4E;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        @media (min-width: 768px) {
            .sidebar {
                width: 250px;
                height: 100vh;
                position: sticky;
                top: 0;
                padding: 30px 0;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1);
                overflow-y: auto;
            }
        }
        
        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            fill: #fff;
        }
        
        .logo h1 {
            font-size: 24px;
            color: #fff;
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
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        @media (min-width: 768px) {
            .menu-item {
                padding: 15px 20px;
            }
        }
        
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item.active {
            background-color: #C4A484;
            color: #8B6B4E;
            font-weight: 500;
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
            background-color: #8B6B4E;
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
                margin-top: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #5a4a3f;
            border-bottom: 2px solid #C4A484;
            padding-bottom: 10px;
            width: 100%;
            max-width: 1200px;
        }
        
        /* Messages Styles */
        .messages-container {
            max-width: 1200px;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 150px);
        }
        
        @media (min-width: 768px) {
            .messages-container {
                flex-direction: row;
            }
        }
        
        /* Students List */
        .students-list {
            width: 100%;
            border-bottom: 1px solid #e9e1d9;
            overflow-y: auto;
            max-height: 30vh;
        }
        
        @media (min-width: 768px) {
            .students-list {
                width: 280px;
                border-right: 1px solid #e9e1d9;
                border-bottom: none;
                height: 100%;
                max-height: none;
            }
        }
        
        .student-item {
            padding: 15px;
            border-bottom: 1px solid #e9e1d9;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #5a4a3f;
        }
        
        .student-item:hover {
            background-color: #f5f0e8;
        }
        
        .student-item.active {
            background-color: #f5f0e8;
            border-left: 3px solid #8B6B4E;
        }
        
        .student-avatar, .student-avatar-header {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #8B6B4E;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 20px;
            object-fit: cover;
            overflow: hidden;
        }
        
        .student-info {
            flex: 1;
        }
        
        .student-name {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .student-status {
            font-size: 12px;
            color: #8d7b6e;
        }
        
        /* Chat Area */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: calc(70vh - 150px);
        }
        
        @media (min-width: 768px) {
            .chat-area {
                height: auto;
            }
        }
        
        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #e9e1d9;
            display: flex;
            align-items: center;
        }
        
        .chat-title {
            font-size: 18px;
            font-weight: 600;
            color: #5a4a3f;
        }
        
        .student-role {
            font-size: 14px;
            color: #8d7b6e;
        }
        
        .messages-list {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            background-color: #f5f0e8;
        }
        
        .message {
            max-width: 40%;
            padding: 12px 16px;
            border-radius: 18px;
            margin-bottom: 15px;
            position: relative;
            word-break: break-word;
        }
        
        .message-sent {
            align-self: flex-end;
            background-color: #8B6B4E;
            color: #ffffff;
            border-bottom-right-radius: 5px;
            margin-left: auto;
        }
        
        .message-received {
            align-self: flex-start;
            background-color: #e9e1d9;
            color: #5a4a3f;
            border-bottom-left-radius: 5px;
            margin-right: auto;
        }
        
        .message-time {
            font-size: 10px;
            margin-top: 3px;
            opacity: 0.8;
            text-align: right;
        }
        
        .message-sent .message-time {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .message-received .message-time {
            color: #8d7b6e;
        }
        
        @media (max-width: 576px) {
            .message {
                max-width: 85%;
            }
        }
        
        /* Message Input */
        .message-input-container {
            padding: 15px 20px;
            border-top: 1px solid #e9e1d9;
            display: flex;
            gap: 10px;
            background-color: white;
        }
        
        .message-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #dfd3c3;
            border-radius: 24px;
            font-size: 15px;
            resize: none;
            min-height: 45px;
            max-height: 120px;
            outline: none;
            transition: border-color 0.3s;
        }
        
        .message-input:focus {
            outline: none;
            border-color: #8B6B4E;
        }
        
        .btn-send {
            background-color: #8B6B4E;
            color: white;
            border: none;
            border-radius: 24px;
            padding: 0 20px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-send:hover {
            background-color: #725639;
        }
        
        .no-student-selected {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #8d7b6e;
            flex-direction: column;
        }
        
        .no-student-selected svg {
            width: 80px;
            height: 80px;
            fill: #dfd3c3;
            margin-bottom: 20px;
        }
        
        .no-student-selected p {
            font-size: 18px;
        }
        
        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #8d7b6e;
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
        
        /* Logout Button Style */
        .logout-button {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logout-button:hover {
            background-color: rgba(255, 255, 255, 0.1);
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
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9z"/>
                <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
            </svg>
            <h1>Koç Paneli</h1>
        </div>
        
        <ul class="menu">
            <li>
                <a href="/koc/ogrenciler" class="menu-item <?php echo $active_page === 'ogrenciler' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Öğrencilerim
                </a>
            </li>
            <li>
                <a href="/koc/gorevler" class="menu-item <?php echo $active_page === 'gorevler' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                    </svg>
                    Görev Yönetimi
                </a>
            </li>
            <li>
                <a href="/koc/bekleyen-sonuclar" class="menu-item <?php echo $active_page === 'bekleyen_sonuclar' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2zm0 15-5-2.18L7 18V5h10v13z"/>
                    </svg>
                    Bekleyen Sonuçlar
                </a>
            </li>
            <li>
                <a href="/koc/mesajlar" class="menu-item <?php echo $active_page === 'mesajlar' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                    </svg>
                    Mesajlar
                </a>
            </li>
            <li>
                <a href="/koc/istatistik" class="menu-item <?php echo $active_page === 'istatistik' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    İstatistikler
                </a>
            </li>
            <li>
                <a href="/koc/profil" class="menu-item <?php echo $active_page === 'profil' ? 'active' : ''; ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Profilim
                </a>
            </li>
            <li>
                <form action="/logout" method="POST" style="margin: 0;">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="logout-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                        Çıkış Yap
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="section-title">Mesajlar</h2>
        
        <?php if (session('success')): ?>
            <div class="notification success">
                <?php echo session('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if (count($ogrenciler) > 0): ?>
            <div class="messages-container">
                <!-- Students List -->
                <div class="students-list">
                    <?php foreach ($ogrenciler as $ogrenci): ?>
                        <a href="/koc/mesajlar?ogrenci_id=<?php echo $ogrenci->id; ?>" class="student-item <?php echo ($seciliOgrenci && $seciliOgrenci->id == $ogrenci->id) ? 'active' : ''; ?>">
                            <span class="student-avatar-wrapper">
                                <?php if ($ogrenci->profile_photo): ?>
                                    <img src="<?php echo asset($ogrenci->profile_photo); ?>" alt="<?php echo $ogrenci->name; ?>" class="student-avatar" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                    <span class="student-avatar" style="display:none;"><?php echo mb_strtoupper(mb_substr($ogrenci->name,0,1)); ?></span>
                                <?php else: ?>
                                    <span class="student-avatar"><?php echo mb_strtoupper(mb_substr($ogrenci->name,0,1)); ?></span>
                                <?php endif; ?>
                            </span>
                            <div class="student-info">
                                <div class="student-name"><?php echo $ogrenci->name; ?></div>
                                <div class="student-status">
                                    <?php
                                    // Get last message date for this student
                                    $lastMessage = \App\Models\Mesaj::where(function($query) use ($ogrenci) {
                                        $query->where('gonderen_id', $ogrenci->id)
                                            ->where('alici_id', auth()->id());
                                    })->orWhere(function($query) use ($ogrenci) {
                                        $query->where('gonderen_id', auth()->id())
                                            ->where('alici_id', $ogrenci->id);
                                    })->orderBy('tarih', 'desc')->first();
                                    
                                    if ($lastMessage) {
                                        echo 'Son mesaj: ' . date('d.m.Y H:i', strtotime($lastMessage->tarih));
                                    } else {
                                        echo 'Henüz mesaj yok';
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Chat Area -->
                <div class="chat-area">
                    <?php if ($seciliOgrenci): ?>
                        <div class="chat-header">
                            <span class="student-avatar-wrapper">
                                <?php if ($seciliOgrenci && $seciliOgrenci->profile_photo): ?>
                                    <img src="<?php echo asset($seciliOgrenci->profile_photo); ?>" alt="<?php echo $seciliOgrenci->name; ?>" class="student-avatar-header" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                    <span class="student-avatar-header" style="display:none;"><?php echo mb_strtoupper(mb_substr($seciliOgrenci->name,0,1)); ?></span>
                                <?php elseif ($seciliOgrenci): ?>
                                    <span class="student-avatar-header"><?php echo mb_strtoupper(mb_substr($seciliOgrenci->name,0,1)); ?></span>
                                <?php endif; ?>
                            </span>
                            <div>
                                <div class="chat-title"><?php echo $seciliOgrenci ? $seciliOgrenci->name : ''; ?></div>
                                <div class="student-role">Öğrenci</div>
                            </div>
                        </div>
                        
                        <!-- Messages List -->
                        <div class="messages-list" id="messages-list">
                            <div id="messages-container">
                                <?php if (count($mesajlar) > 0): ?>
                                    <?php foreach ($mesajlar as $mesaj): ?>
                                        <div class="message <?php echo $mesaj->gonderen_id == auth()->id() ? 'message-sent' : 'message-received'; ?>">
                                            <?php echo nl2br(htmlspecialchars($mesaj->mesaj)); ?>
                                            <div class="message-time"><?php echo date('d.m.Y H:i', strtotime($mesaj->tarih)); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-state" id="no-messages">
                                        <div class="empty-state-icon">💬</div>
                                        <div class="empty-state-text">
                                            Henüz mesaj yok. Bir mesaj göndererek konuşmaya başlayın.
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Message Input -->
                        <form id="message-form" class="message-input-container">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="alici_id" value="<?php echo $seciliOgrenci->id; ?>">
                            
                            <textarea name="mesaj" id="message-input" class="message-input" placeholder="Mesajınızı yazın..." required></textarea>
                            <button type="submit" class="btn-send">Gönder</button>
                        </form>
                    <?php else: ?>
                        <div class="no-student-selected">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                            </svg>
                            <p>Mesajlaşmak için bir öğrenci seçin</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="no-students" style="background-color: white; padding: 30px; text-align: center; border-radius: 10px; width: 100%; max-width: 1200px;">
                <p>Henüz hiç öğrenciniz bulunmuyor.</p>
            </div>
        <?php endif; ?>
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
        // Auto-scroll to bottom of messages when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const messagesList = document.getElementById('messages-list');
            if (messagesList) {
                messagesList.scrollTop = messagesList.scrollHeight;
            }
            
            // Make textarea auto-expand
            const textarea = document.querySelector('.message-input');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }
            
            // Setup real-time messaging if a student is selected
            if (document.getElementById('message-form')) {
                setupRealTimeMessaging();
                setupMessageForm();
                
                // Force a refresh of messages on page load to ensure consistent styling
                const aliciId = document.querySelector('input[name="alici_id"]').value;
                fetch(`/koc/mesajlar/veri?ogrenci_id=${aliciId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            updateMessagesUI(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching messages on page load:', error);
                    });
            }
        });
        
        // Real-time messaging with polling
        function setupRealTimeMessaging() {
            // Get the selected student ID
            const aliciId = document.querySelector('input[name="alici_id"]').value;
            
            // Keep track of the last message count to detect new messages
            let lastMessageCount = 0;
            let messagesContainer = document.getElementById('messages-container');
            
            // Determine the last message count from initial messages
            const initialMessages = document.querySelectorAll('.message');
            if (initialMessages.length > 0) {
                lastMessageCount = initialMessages.length;
            }
            
            // Poll for new messages every 5 seconds
            setInterval(fetchMessages, 5000);
            
            function fetchMessages() {
                fetch(`/koc/mesajlar/veri?ogrenci_id=${aliciId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            return;
                        }
                        
                        // If we have more messages now than before, update the UI
                        if (data.length > lastMessageCount) {
                            updateMessagesUI(data);
                            lastMessageCount = data.length;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching messages:', error);
                    });
            }
        }
        
        // Function to update the messages UI
        function updateMessagesUI(messages) {
            const messagesContainer = document.getElementById('messages-container');
            
            // Clear the no-messages div if it exists
            const noMessages = document.getElementById('no-messages');
            if (noMessages) {
                noMessages.remove();
            }
            
            // Clear existing messages
            messagesContainer.innerHTML = '';
            
            // Add all messages
            messages.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.className = 'message ' + (message.isSent ? 'message-sent' : 'message-received');
                
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
            const messagesList = document.getElementById('messages-list');
            messagesList.scrollTop = messagesList.scrollHeight;
        }
        
        // Handle message form submission
        function setupMessageForm() {
            const form = document.getElementById('message-form');
            const input = document.getElementById('message-input');
            const aliciId = document.querySelector('input[name="alici_id"]').value;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!input.value.trim()) {
                    return;
                }
                
                // Get form data
                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('alici_id', aliciId);
                formData.append('mesaj', input.value);
                
                // Send the message
                fetch('/koc/mesaj-gonder', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Clear the input
                        input.value = '';
                        input.style.height = 'auto';
                        
                        // Immediately fetch messages to show the sent message
                        fetch(`/koc/mesajlar/veri?ogrenci_id=${aliciId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    updateMessagesUI(data);
                                }
                            });
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            });
        }
        
        // Sidebar Toggle Script
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html> 