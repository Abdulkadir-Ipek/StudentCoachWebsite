<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Paneli - EduCoach</title>
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
        
        /* Content Container */
        .content-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        /* Mobile order of sections */
        @media (max-width: 991px) {
            .tasks-panel {
                order: 1;
            }
            
            .weekly-goals {
                order: 2;
            }
            
            .message-panel {
                order: 3;
            }
        }
        
        @media (min-width: 992px) {
            .content-container {
                display: grid;
                grid-template-columns: 2fr 1fr;
                grid-template-areas:
                    "welcome welcome"
                    "tasks goals"
                    "tasks message";
                gap: 30px;
            }

            .welcome-banner {
                grid-area: welcome;
            }

            .tasks-panel {
                grid-area: tasks;
                margin-bottom: 0;
            }

            .weekly-goals {
                grid-area: goals;
            }

            .message-panel {
                grid-area: message;
                margin-bottom: 0;
            }
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }
        
        /* Tasks Panel */
        .tasks-panel {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            width: 100%;
            height: fit-content;
        }
        
        .task-item {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .task-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .task-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        @media (min-width: 768px) {
            .task-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }
        
        .task-name {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }
        
        .task-percentage {
            font-weight: 600;
            color: #6c4ab6;
            font-size: 16px;
        }
        
        .progress-bar {
            height: 12px;
            background-color: #eee;
            border-radius: 6px;
            overflow: hidden;
            margin: 15px 0;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #6c4ab6;
            border-radius: 6px;
            transition: width 0.3s ease;
        }
        
        .task-stats {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 15px;
            margin: 15px 0;
            background-color: #f8f7fe;
            border-radius: 5px;
            padding: 15px;
        }
        
        @media (min-width: 576px) {
            .task-stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .task-stat-item {
            text-align: center;
            padding: 10px;
        }
        
        .stat-label {
            display: block;
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #6c4ab6;
        }
        
        .btn-result {
            width: 100%;
            background-color: #6c4ab6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }
        
        @media (min-width: 576px) {
            .btn-result {
                width: auto;
            }
        }
        
        .btn-result:hover {
            background-color: #5a3d99;
        }
        
        /* Course Filter Styles */
        .course-filter {
            margin-bottom: 20px;
        }
        
        .course-filter select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
            transition: border-color 0.2s;
        }
        
        .course-filter select:focus {
            border-color: #6c4ab6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(108, 74, 182, 0.2);
        }
        
        .course-filter select option {
            padding: 10px;
        }
        
        /* Message Panel */
        .message-panel {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            height: fit-content;
        }
        
        .message-container {
            display: flex;
            align-items: flex-start;
        }
        
        .message-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .message-content {
            flex: 1;
        }
        
        .message-text {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        /* User Info */
        .user-info {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .user-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .user-email {
            color: #777;
            margin-bottom: 20px;
        }
        
        /* Weekly Goals */
        .weekly-goals {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: fit-content;
            min-height: 400px;
        }
        
        .goals-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .chart-container {
            height: 250px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .chart-bar {
            width: 15%;
            background-color: #6c4ab6;
            border-radius: 5px 5px 0 0;
            position: relative;
        }
        
        .chart-label {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        
        /* Coach Selection Panel */
        .coach-selection-panel {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 800px;
            margin: 50px auto;
        }
        
        .coach-selection-title {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .coach-selection-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .coach-selection-form {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #333;
            text-align: left;
        }
        
        .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }
        
        .btn-submit {
            background-color: #6c4ab6;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-submit:hover {
            background-color: #5a3d99;
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
        
        .empty-state {
            text-align: center;
            padding: 30px 0;
            color: #777;
        }
        
        .empty-state-icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: #ccc;
        }
        
        .empty-state-message {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .empty-state-submessage {
            font-size: 14px;
            color: #999;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow: auto;
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: modal-appear 0.3s ease-out;
        }
        
        @keyframes modal-appear {
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .modal-title {
            font-size: 22px;
            color: #333;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        
        .modal-close:hover {
            color: #333;
        }
        
        /* Welcome Banner Styles */
        
        .welcome-heading {
            font-size: 28px;
            font-weight: 600;
            color: #6c4ab6;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        
        .welcome-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        @media (max-width: 768px) {
            .welcome-heading {
                font-size: 24px;
            }
        }
        
        /* Task Stats Styles */
        .task-stats {
            display: flex;
            margin: 15px 0;
            background-color: #f8f7fe;
            border-radius: 5px;
            padding: 10px;
        }
        
        .task-stat-item {
            flex: 1;
            text-align: center;
            padding: 0 10px;
        }
        
        .stat-label {
            display: block;
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #6c4ab6;
        }
        
        .btn-result {
            background-color: #6c4ab6;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        
        .btn-result:hover {
            background-color: #5a3d99;
        }
        
        .task-info-display {
            background-color: #f8f7fe;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
        }
        
        /* Daily Goals Styles */
        .daily-goals-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
            max-height: 300px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        /* Custom scrollbar for daily goals */
        .daily-goals-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .daily-goals-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .daily-goals-list::-webkit-scrollbar-thumb {
            background: #bdb4d9;
            border-radius: 10px;
        }
        
        .daily-goals-list::-webkit-scrollbar-thumb:hover {
            background: #6c4ab6;
        }
        
        .daily-goal-item {
            background-color: #f8f7fe;
            border-radius: 5px;
            padding: 12px 15px;
            transition: all 0.2s;
        }
        
        .daily-goal-item.completed {
            background-color: #e4f0e2;
            opacity: 0.8;
        }
        
        .goal-checkbox {
            display: flex;
            align-items: center;
        }
        
        .goal-checkbox input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .goal-checkbox label {
            margin: 0;
            font-size: 16px;
            cursor: pointer;
        }
        
        .daily-goal-item.completed .goal-checkbox label {
            text-decoration: line-through;
            color: #5c8a5c;
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
        
        @media (max-width: 768px) {
            .daily-goals-list {
                max-height: 250px;
            }
            
            .weekly-goals {
                min-height: 350px;
            }
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
        
        <?php if ($coach_id_null): ?>
            <!-- Coach Selection Panel -->
            <div class="coach-selection-panel">
                <h2 class="coach-selection-title">Hoş Geldiniz!</h2>
                <p class="coach-selection-message">
                    Sistemi kullanmaya başlamadan önce size rehberlik edecek bir koç seçmeniz gerekiyor. 
                    Koçunuz size özel görevler atayacak, ilerlemenizi takip edecek ve hedeflerinize ulaşmanıza yardımcı olacak.
                </p>
                
                <form action="<?php echo route('koc-sec'); ?>" method="POST" class="coach-selection-form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="form-group">
                        <label for="coach_id" class="form-label">Koçunuzu Seçin:</label>
                        <select name="coach_id" id="coach_id" class="form-select" required>
                            <option value="">Bir Koç Seçin</option>
                            <?php foreach ($koclar as $koc): ?>
                                <option value="<?php echo $koc->id; ?>"><?php echo $koc->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-submit">Koçumu Seç</button>
                </form>
            </div>
        <?php elseif (Auth::user()->alan === null): ?>
            <!-- Field Selection Panel -->
            <div class="coach-selection-panel">
                <h2 class="coach-selection-title">Alan Seçimi</h2>
                <p class="coach-selection-message">
                    Devam etmeden önce eğitim alanınızı seçmeniz gerekmektedir. 
                    Bu seçim, size uygun içerik ve sıralamaların gösterilmesi için kullanılacaktır.
                </p>
                
                <form action="<?php echo route('alan-sec'); ?>" method="POST" class="coach-selection-form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="form-group">
                        <label for="alan" class="form-label">Alanınızı Seçin:</label>
                        <select name="alan" id="alan" class="form-select" required>
                            <option value="">Alan Seçin</option>
                            <option value="sayısal">Sayısal</option>
                            <option value="eşit">Eşit Ağırlık</option>
                            <option value="sözel">Sözel</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-submit">Alanımı Seç</button>
                </form>
            </div>
        <?php else: ?>
            <!-- Regular content when coach is selected and field is selected -->
            <div class="content-container">
                <!-- Welcome Banner -->
                <div class="welcome-banner" style="grid-column: 1 / -1; margin-bottom: 30px;">
                    <h1 class="welcome-heading">
                        <img src="<?php echo $user->profile_photo ? asset($user->profile_photo) : 'https://picsum.photos/seed/'.$user->id.'/200'; ?>" alt="" class="welcome-avatar"> 
                        Hoşgeldin, <?php echo $user->name; ?>!
                    </h1>
                </div>
                
                <!-- Tasks Panel -->
                <div class="tasks-panel">
                    <h2 class="section-title">YKS Görevlerim</h2>
                    
                    <!-- Ders Filtresi -->
                    <div class="course-filter">
                        <select id="courseFilter" class="form-select mb-4" onchange="filterTasks()">
                            <option value="all">Hepsi</option>
                            <option value="TYT Türkçe">TYT Türkçe</option>
                            <option value="TYT Matematik">TYT Matematik</option>
                            <option value="TYT Tarih">TYT Tarih</option>
                            <option value="TYT Coğrafya">TYT Coğrafya</option>
                            <option value="TYT Din">TYT Din</option>
                            <option value="TYT Felsefe">TYT Felsefe</option>
                            <option value="TYT Fizik">TYT Fizik</option>
                            <option value="TYT Kimya">TYT Kimya</option>
                            <option value="TYT Biyoloji">TYT Biyoloji</option>
                            <option value="AYT Matematik">AYT Matematik</option>
                            <option value="AYT Fizik">AYT Fizik</option>
                            <option value="AYT Kimya">AYT Kimya</option>
                            <option value="AYT Biyoloji">AYT Biyoloji</option>
                            <option value="AYT Edebiyat">AYT Edebiyat</option>
                            <option value="AYT Tarih">AYT Tarih</option>
                            <option value="AYT Coğrafya">AYT Coğrafya</option>
                            <option value="AYT Felsefe Grubu">AYT Felsefe Grubu</option>
                        </select>
                    </div>
                    
                    <div id="tasksContainer">
                    <?php if (count($gorevler) > 0): ?>
                        <?php foreach ($gorevler as $gorev): ?>
                            <div class="task-item" data-course="<?php echo $gorev->ders_adi; ?>">
                                <div class="task-header">
                                    <span class="task-name"><?php echo $gorev->ders_adi; ?> - <?php echo $gorev->toplam_soru_sayisi; ?> Soru</span>
                                    <span class="task-percentage"><?php echo $gorev->tamamlama_yuzdesi; ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $gorev->tamamlama_yuzdesi; ?>%"></div>
                                </div>
                                
                                <?php if (isset($gorev->cozulen_soru) && $gorev->cozulen_soru > 0): ?>
                                    <div class="task-stats">
                                        <div class="task-stat-item">
                                            <span class="stat-label">Çözülen:</span>
                                            <span class="stat-value"><?php echo $gorev->cozulen_soru; ?> / <?php echo $gorev->toplam_soru_sayisi; ?></span>
                                        </div>
                                        <div class="task-stat-item">
                                            <span class="stat-label">Doğru:</span>
                                            <span class="stat-value"><?php echo $gorev->dogru_sayisi; ?></span>
                                        </div>
                                        <div class="task-stat-item">
                                            <span class="stat-label">Yanlış:</span>
                                            <span class="stat-value"><?php echo $gorev->yanlis_sayisi; ?></span>
                                        </div>
                                        <div class="task-stat-item">
                                            <span class="stat-label">Boş:</span>
                                            <span class="stat-value"><?php echo isset($gorev->bos_sayisi) ? $gorev->bos_sayisi : 0; ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <button class="btn-result" onclick="openResultModal(<?php echo $gorev->id; ?>, '<?php echo $gorev->ders_adi; ?>', <?php echo $gorev->toplam_soru_sayisi; ?>)">
                                    Sonuç Gir
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📝</div>
                            <div class="empty-state-message">Henüz bir göreviniz bulunmuyor.</div>
                            <div class="empty-state-submessage">Koçunuz size görev atadığında burada görüntülenecek.</div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                
                <!-- Weekly Goals -->
                <div class="weekly-goals">
                    <h3 class="goals-title">📘 Bugünkü Hedefler (<?php echo $bugun; ?>)</h3>
                    
                    <?php if (isset($bugunHedefler) && count($bugunHedefler) > 0): ?>
                        <div class="daily-goals-list">
                            <?php foreach ($bugunHedefler as $hedef): ?>
                                <div class="daily-goal-item <?php echo $hedef->tamamlandi ? 'completed' : ''; ?>">
                                    <div class="goal-checkbox">
                                        <input type="checkbox" id="goal-<?php echo $hedef->id; ?>" 
                                            <?php echo $hedef->tamamlandi ? 'checked disabled' : ''; ?> 
                                            onchange="completeGoal(<?php echo $hedef->id; ?>)">
                                        <label for="goal-<?php echo $hedef->id; ?>">
                                            <?php echo $hedef->ders_adi; ?> – <?php echo $hedef->hedef_soru; ?> Soru
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">🎯</div>
                            <div class="empty-state-message">Bugün için tanımlanmış hedef bulunmuyor.</div>
                            <div class="empty-state-submessage">Koçunuz hedefler tanımladığında burada görüntülenecek.</div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Message Panel -->
                <div class="message-panel">
                    <h2 class="section-title">Son Mesaj</h2>
                    
                    <?php if ($son_mesaj): ?>
                        <div class="message-container">
                            <img src="https://picsum.photos/seed/<?php echo $son_mesaj->gonderen->id; ?>/200" alt="<?php echo $son_mesaj->gonderen->name; ?>" class="message-avatar">
                            <div class="message-content">
                                <div class="message-text"><?php echo $son_mesaj->mesaj; ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">💬</div>
                            <div class="empty-state-message">Henüz hiç mesaj yok.</div>
                            <div class="empty-state-submessage">Koçunuzla iletişim kurduğunuzda mesajlar burada görüntülenecek.</div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Results Approval Status -->
                <div class="approval-panel" style="grid-column: 1 / -1; background-color: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 20px;">
                    <h2 class="section-title">Sonuç Onay Durumları</h2>
                    
                    <?php if (count($bekleyenSonuclar) > 0): ?>
                        <div style="margin-bottom: 30px;">
                            <h3 style="font-size: 18px; color: #6c4ab6; margin-bottom: 15px;">Onay Bekleyen Sonuçlar</h3>
                            
                            <div class="table-responsive">
                                <table class="table" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background-color: #f8f7fe;">
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Ders</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Tarih</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Çözülen</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Doğru</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Yanlış</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Boş</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Durum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bekleyenSonuclar as $sonuc): ?>
                                            <tr>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->ders_adi; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo date('d.m.Y', strtotime($sonuc->tarih)); ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->cozuldu_soru; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->dogru; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->yanlis; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->bos; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                                                    <span style="background-color: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 4px; font-size: 14px;">Beklemede</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (count($sonIslemler) > 0): ?>
                        <div>
                            <h3 style="font-size: 18px; color: #6c4ab6; margin-bottom: 15px;">Son İşlemler</h3>
                            
                            <div class="table-responsive">
                                <table class="table" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background-color: #f8f7fe;">
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Ders</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Tarih</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Çözülen</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Doğru</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Yanlış</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Boş</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Durum</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee;">Not</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sonIslemler as $sonuc): ?>
                                            <tr>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->ders_adi; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo date('d.m.Y', strtotime($sonuc->tarih)); ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->cozuldu_soru; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->dogru; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->yanlis; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;"><?php echo $sonuc->bos; ?></td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                                                    <?php if ($sonuc->onay_durumu === 'onaylandi'): ?>
                                                        <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 4px; font-size: 14px;">Onaylandı</span>
                                                    <?php else: ?>
                                                        <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 4px; font-size: 14px;">Reddedildi</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                                                    <?php echo $sonuc->not ? $sonuc->not : '-'; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (count($bekleyenSonuclar) === 0 && count($sonIslemler) === 0): ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div class="empty-state-message">Henüz sonuç kaydı bulunmuyor.</div>
                            <div class="empty-state-submessage">Görevlere sonuçlarınızı girdikçe burada görüntülenecek.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Result Modal -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Soru Sonucu Gir</h3>
                <button class="modal-close" onclick="closeResultModal()">&times;</button>
            </div>
            
            <form id="resultForm" action="/sonuc-kaydet" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" id="gorev_id" name="gorev_id">
                
                <div class="form-group">
                    <div id="task-info" class="task-info-display"></div>
                </div>
                
                <div class="form-group">
                    <label for="cozuldu_soru" class="form-label">Kaç Soru Çözdün?</label>
                    <input type="number" id="cozuldu_soru" name="cozuldu_soru" class="form-input" min="1" required onchange="updateCounts()">
                </div>
                
                <div class="form-group">
                    <label for="dogru" class="form-label">Doğru Sayısı</label>
                    <input type="number" id="dogru" name="dogru" class="form-input" min="0" required onchange="updateCounts()">
                </div>
                
                <div class="form-group">
                    <label for="yanlis" class="form-label">Yanlış Sayısı</label>
                    <input type="number" id="yanlis" name="yanlis" class="form-input" min="0" required onchange="updateCounts()">
                </div>
                
                <div class="form-group">
                    <label for="bos" class="form-label">Boş Sayısı</label>
                    <input type="number" id="bos" name="bos" class="form-input" min="0" required onchange="updateCounts()">
                </div>
                
                <button type="submit" class="btn-submit">Sonucu Kaydet</button>
            </form>
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
        // Result Modal Functions
        function openResultModal(id, dersAdi, toplamSoru) {
            document.getElementById('gorev_id').value = id;
            document.getElementById('task-info').innerHTML = '<strong>' + dersAdi + '</strong> dersinden toplam <strong>' + toplamSoru + '</strong> soru';
            document.getElementById('cozuldu_soru').max = toplamSoru;
            
            document.getElementById('resultModal').classList.add('show');
        }
        
        function closeResultModal() {
            document.getElementById('resultModal').classList.remove('show');
        }
        
        function updateCounts() {
            const cozulen = parseInt(document.getElementById('cozuldu_soru').value) || 0;
            const dogru = parseInt(document.getElementById('dogru').value) || 0;
            const yanlis = parseInt(document.getElementById('yanlis').value) || 0;
            const bos = parseInt(document.getElementById('bos').value) || 0;
            
            // Hesaplanan toplam soru sayısı
            const toplam = dogru + yanlis + bos;
            
            // Eğer toplam, çözülen soru sayısından fazlaysa
            if (toplam > cozulen) {
                // Farkı boş sorudan düş
                if (bos > 0) {
                    const fark = toplam - cozulen;
                    const yeniBos = Math.max(0, bos - fark);
                    document.getElementById('bos').value = yeniBos;
                }
                // Eğer boş soru 0 ise ve yanlış varsa, yanlıştan düş
                else if (yanlis > 0) {
                    const fark = toplam - cozulen;
                    const yeniYanlis = Math.max(0, yanlis - fark);
                    document.getElementById('yanlis').value = yeniYanlis;
                }
                // Son çare olarak doğru sayısını düzelt
                else if (dogru > 0) {
                    const fark = toplam - cozulen;
                    const yeniDogru = Math.max(0, dogru - fark);
                    document.getElementById('dogru').value = yeniDogru;
                }
            }
            // Eğer toplam, çözülen soru sayısından azsa, boş soru sayısını arttır
            else if (toplam < cozulen) {
                const fark = cozulen - toplam;
                document.getElementById('bos').value = bos + fark;
            }
        }
        
        // Task filtering function
        function filterTasks() {
            const selectedCourse = document.getElementById('courseFilter').value;
            const taskItems = document.querySelectorAll('.task-item');
            const emptyState = document.querySelector('.empty-state');
            let visibleTaskCount = 0;
            
            taskItems.forEach(item => {
                const courseName = item.getAttribute('data-course');
                
                if (selectedCourse === 'all' || courseName === selectedCourse) {
                    item.style.display = 'block';
                    visibleTaskCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show empty state if no tasks match the filter
            if (emptyState && taskItems.length > 0) {
                if (visibleTaskCount === 0) {
                    emptyState.style.display = 'block';
                    emptyState.querySelector('.empty-state-message').textContent = 'Bu ders için görev bulunmuyor.';
                    emptyState.querySelector('.empty-state-submessage').textContent = 'Lütfen başka bir ders seçin veya koçunuza başvurun.';
                } else {
                    emptyState.style.display = 'none';
                }
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('resultModal');
            if (event.target === modal) {
                closeResultModal();
            }
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
            
            // Initialize task filtering
            if (document.getElementById('courseFilter')) {
                filterTasks();
            }
        });
        
        // Goal completion functionality
        function completeGoal(goalId) {
            // Send request to mark the goal as completed
            fetch('/hedef-tamamla', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>",
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    hedef_id: goalId,
                    _token: "<?php echo csrf_token(); ?>"
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Mark the goal as completed in the UI
                    const goalItem = document.getElementById('goal-' + goalId).closest('.daily-goal-item');
                    goalItem.classList.add('completed');
                    
                    // Disable the checkbox
                    document.getElementById('goal-' + goalId).disabled = true;
                } else {
                    // Show error in console for debugging
                    console.error('Error:', data.message);
                    
                    // If there was a database constraint error with Turkish goal, automatically reload the page
                    // This will pick up the newly created goal record from our backend
                    if (data.message && data.message.includes('constraint') && goalId == 3) {
                        alert('Türkçe hedefi kaydediliyor, lütfen bekleyin...');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        alert('Hata: ' + data.message);
                        // Uncheck the checkbox if there was an error
                        document.getElementById('goal-' + goalId).checked = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                // Uncheck the checkbox if there was an error
                document.getElementById('goal-' + goalId).checked = false;
            });
        }
    </script>
</body>
</html> 