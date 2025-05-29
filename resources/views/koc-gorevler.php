<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görev Yönetimi - Koç Paneli</title>
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
        }
        
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
                margin-top: 0;
            }
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #5a4a3f;
            border-bottom: 2px solid #C4A484;
            padding-bottom: 10px;
        }
        
        /* Task Management Styles */
        .tasks-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 100%;
        }
        
        .tasks-row {
            display: flex;
            gap: 30px;
            width: 100%;
            margin-bottom: 30px;
        }
        
        @media (max-width: 991.98px) {
            .tasks-row {
                flex-direction: column;
                gap: 20px;
            }
        }
        
        /* Add Task Form */
        .add-task-form {
            flex: 1;
            min-width: 0;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 25px;
        }
        
        .form-title {
            font-size: 20px;
            color: #5a4a3f;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1;
        }
        
        @media (min-width: 768px) {
            .form-group.full-width {
                grid-column: span 2;
            }
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #5a4a3f;
        }
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dfd3c3;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            background-color: #fff;
            color: #5a4a3f;
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #8B6B4E;
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .btn-submit {
            background-color: #8B6B4E;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-submit:hover {
            background-color: #725639;
        }
        
        /* Tasks Table */
        .tasks-table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 25px;
            overflow-x: auto;
        }
        
        .tasks-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .tasks-table th, .tasks-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9e1d9;
        }
        
        .tasks-table th {
            font-weight: 600;
            color: #5a4a3f;
            background-color: #f5f0e8;
        }
        
        /* Responsive table */
        @media (max-width: 767.98px) {
            .tasks-table {
                display: block;
                width: 100%;
                overflow-x: auto;
            }
            
            .tasks-table th, .tasks-table td {
                min-width: 120px;
            }
        }
        
        .tasks-table tr:last-child td {
            border-bottom: none;
        }
        
        .task-actions {
            display: flex;
            gap: 10px;
        }
        
        @media (max-width: 576px) {
            .task-actions {
                flex-direction: column;
                gap: 5px;
            }
        }
        
        .btn-edit, .btn-delete {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }
        
        .btn-edit {
            background-color: #C4A484;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #b3906f;
        }
        
        .btn-delete {
            background-color: #d9534f;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c9302c;
        }
        
        .no-tasks {
            text-align: center;
            padding: 30px 0;
            color: #8d7b6e;
        }
        
        .progress-bar {
            height: 10px;
            background-color: #e9e1d9;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #8B6B4E;
            border-radius: 5px;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-title {
            font-size: 20px;
            color: #5a4a3f;
            font-weight: 600;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #8d7b6e;
        }
        
        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 350px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Daily Goal Calendar Styles */
        .daily-goal-calendar {
            flex: 1;
            min-width: 0;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 25px;
        }
        
        .days-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .day-btn {
            flex: 1;
            min-width: 40px;
            text-align: center;
            padding: 8px;
            background-color: #f8f7fe;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .day-btn.active {
            background-color: #8B6B4E;
            color: white;
        }
        
        .day-goals-container {
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 15px;
        }
        
        .day-goals {
            margin-bottom: 20px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .goal-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
            background-color: #f8f7fe;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .goal-info {
            flex: 1;
        }
        
        .goal-delete {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        
        .add-goal-form {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        @media (max-width: 576px) {
            .days-container {
                gap: 3px;
            }
            
            .day-btn {
                min-width: 35px;
                padding: 6px;
                font-size: 14px;
            }
            
            .goal-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .goal-delete {
                align-self: flex-end;
            }
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
        <div class="tasks-container">
            <?php if (session('success')): ?>
                <div class="notification success">
                    <?php echo session('success'); ?>
                </div>
            <?php endif; ?>
            
            <?php if (session('error')): ?>
                <div class="notification error">
                    <?php echo session('error'); ?>
                </div>
            <?php endif; ?>
            
            <div class="tasks-row">
                <!-- Add Task Form -->
                <div class="add-task-form">
                    <h3 class="form-title">Yeni Görev Ekle</h3>
                    
                    <form action="/koc/gorev-ekle" method="POST">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="ogrenci_id" class="form-label">Öğrenci</label>
                                <select name="ogrenci_id" id="ogrenci_id" class="form-select" required>
                                    <option value="">Öğrenci Seçin</option>
                                    <?php foreach ($ogrenciler as $ogrenci): ?>
                                        <option value="<?php echo $ogrenci->id; ?>"><?php echo $ogrenci->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="ders_adi" class="form-label">Ders</label>
                                <select name="ders_adi" id="ders_adi" class="form-select" required>
                                    <option value="">Ders Seçin</option>
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
                            
                            <div class="form-group">
                                <label for="toplam_soru_sayisi" class="form-label">Toplam Soru Sayısı</label>
                                <input type="number" name="toplam_soru_sayisi" id="toplam_soru_sayisi" class="form-input" min="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="hedef_tarih" class="form-label">Hedef Tarih (Opsiyonel)</label>
                                <input type="date" name="hedef_tarih" id="hedef_tarih" class="form-input">
                            </div>
                            
                            <div class="form-group form-buttons">
                                <button type="submit" class="btn-submit">Görev Ekle</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Daily Goal Calendar -->
                <div class="daily-goal-calendar">
                    <h3 class="form-title">Günlük Hedef Takvimi</h3>
                    
                    <div class="days-container">
                        <?php
                        $days = ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'];
                        $fullDays = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];
                        ?>
                        
                        <?php foreach ($days as $index => $day): ?>
                            <div class="day-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-day="<?php echo $fullDays[$index]; ?>">
                                <?php echo $day; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="day-goals-container">
                        <div class="day-goals" id="dayGoals">
                            <!-- Goals will be loaded here dynamically -->
                        </div>
                        
                        <div class="add-goal-form">
                            <div class="form-group">
                                <label for="goal_ders_adi" class="form-label">Ders Adı</label>
                                <select id="goal_ders_adi" class="form-select">
                                    <option value="">Ders Seçin</option>
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
                            
                            <div class="form-group">
                                <label for="goal_hedef_soru" class="form-label">Soru Sayısı</label>
                                <input type="number" id="goal_hedef_soru" class="form-input" min="1">
                            </div>
                            
                            <button type="button" id="addGoalBtn" class="btn-submit">Hedef Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- YKS Tasks List -->
            <div class="tasks-list">
                <h3 class="form-title">YKS Görevleri</h3>
                
                <?php if (count($gorevler) > 0): ?>
                    <div class="tasks">
                        <?php foreach ($gorevler as $gorev): ?>
                            <div class="task-card">
                                <div class="task-header">
                                    <div class="task-title"><?php echo $gorev->ders_adi; ?></div>
                                    <form action="/koc/gorev-yks-sil/<?php echo $gorev->id; ?>" method="POST" onsubmit="return confirm('Bu görevi silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <button type="submit" class="btn-delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="task-details">
                                    <div class="detail">
                                        <span class="detail-label">Öğrenci:</span>
                                        <span class="detail-value"><?php echo $gorev->ogrenci_adi; ?></span>
                                    </div>
                                    <div class="detail">
                                        <span class="detail-label">Toplam Soru:</span>
                                        <span class="detail-value"><?php echo $gorev->toplam_soru_sayisi; ?></span>
                                    </div>
                                    <div class="detail">
                                        <span class="detail-label">Hedef Tarih:</span>
                                        <span class="detail-value">
                                            <?php echo $gorev->hedef_tarih ? date('d.m.Y', strtotime($gorev->hedef_tarih)) : 'Belirtilmedi'; ?>
                                        </span>
                                    </div>
                                    <div class="detail">
                                        <span class="detail-label">İlerleme:</span>
                                        <span class="detail-value"><?php echo $gorev->tamamlama_yuzdesi; ?>%</span>
                                    </div>
                                </div>
                                
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $gorev->tamamlama_yuzdesi; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-tasks">Henüz YKS görevi eklenmemiş.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Görevi Düzenle</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            
            <form id="editTaskForm" method="POST" action="">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                
                <div class="form-group">
                    <label for="edit_gorev_adi" class="form-label">Görev Adı</label>
                    <input type="text" name="gorev_adi" id="edit_gorev_adi" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_aciklama" class="form-label">Açıklama</label>
                    <textarea name="aciklama" id="edit_aciklama" class="form-textarea"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_tamamlanma_orani" class="form-label">Tamamlanma Oranı (%)</label>
                    <input type="number" name="tamamlanma_orani" id="edit_tamamlanma_orani" class="form-input" min="0" max="100">
                </div>
                
                <button type="submit" class="btn-submit">Güncelle</button>
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
        // Edit Modal Functions
        function openEditModal(id, gorevAdi, aciklama, tamamlanmaOrani) {
            document.getElementById('editTaskForm').action = '/koc/gorev-guncelle/' + id;
            document.getElementById('edit_gorev_adi').value = gorevAdi;
            document.getElementById('edit_aciklama').value = aciklama;
            document.getElementById('edit_tamamlanma_orani').value = tamamlanmaOrani;
            
            document.getElementById('editTaskModal').classList.add('show');
        }
        
        function closeEditModal() {
            document.getElementById('editTaskModal').classList.remove('show');
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editTaskModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }
        
        // Sidebar Toggle Script
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
    
    <!-- Add JavaScript for Daily Goal Calendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Daily Goal Calendar functionality
            const dayButtons = document.querySelectorAll('.day-btn');
            const dayGoalsContainer = document.getElementById('dayGoals');
            const addGoalBtn = document.getElementById('addGoalBtn');
            const dersSelect = document.getElementById('goal_ders_adi');
            const hedefSoruInput = document.getElementById('goal_hedef_soru');
            let currentDay = 'Pazartesi'; // Default day
            
            // Load goals for the default day (Pazartesi)
            loadGoals(currentDay);
            
            // Day button click handler
            dayButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    dayButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Update current day
                    currentDay = this.getAttribute('data-day');
                    
                    // Load goals for the selected day
                    loadGoals(currentDay);
                });
            });
            
            // Add goal button click handler
            addGoalBtn.addEventListener('click', function() {
                const dersAdi = dersSelect.value;
                const hedefSoru = hedefSoruInput.value;
                
                if (!dersAdi || !hedefSoru || hedefSoru < 1) {
                    alert('Lütfen ders adı ve soru sayısını doğru bir şekilde girin.');
                    return;
                }
                
                addGoal(currentDay, dersAdi, hedefSoru);
            });
            
            // Function to load goals for a specific day
            function loadGoals(day) {
                fetch(`/koc/haftalik-hedefler/${day}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            displayGoals(data.hedefler);
                        } else {
                            console.error('Error loading goals:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
            
            // Function to display goals
            function displayGoals(hedefler) {
                dayGoalsContainer.innerHTML = '';
                
                if (hedefler.length === 0) {
                    dayGoalsContainer.innerHTML = '<div class="empty-goals">Bu gün için hedef bulunmuyor.</div>';
                    return;
                }
                
                hedefler.forEach(hedef => {
                    const goalItem = document.createElement('div');
                    goalItem.className = 'goal-item';
                    goalItem.innerHTML = `
                        <div class="goal-info">
                            <strong>${hedef.ders_adi}</strong> - ${hedef.hedef_soru} Soru
                        </div>
                        <button class="goal-delete" data-id="${hedef.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                        </button>
                    `;
                    
                    dayGoalsContainer.appendChild(goalItem);
                });
                
                // Add event listeners for delete buttons
                document.querySelectorAll('.goal-delete').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const hedefId = this.getAttribute('data-id');
                        deleteGoal(hedefId);
                    });
                });
            }
            
            // Function to add a goal
            function addGoal(gun, dersAdi, hedefSoru) {
                const formData = new FormData();
                formData.append('gun', gun);
                formData.append('ders_adi', dersAdi);
                formData.append('hedef_soru', hedefSoru);
                formData.append('_token', "<?php echo csrf_token(); ?>");
                
                fetch('/koc/haftalik-hedef-ekle', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>"
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Clear form inputs
                        dersSelect.value = '';
                        hedefSoruInput.value = '';
                        
                        // Reload goals
                        loadGoals(currentDay);
                    } else {
                        alert('Hata: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            }
            
            // Function to delete a goal
            function deleteGoal(hedefId) {
                if (!confirm('Bu hedefi silmek istediğinize emin misiniz?')) {
                    return;
                }
                
                const formData = new FormData();
                formData.append('_token', "<?php echo csrf_token(); ?>");
                
                fetch(`/koc/haftalik-hedef-sil/${hedefId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>"
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Reload goals
                        loadGoals(currentDay);
                    } else {
                        alert('Hata: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            }
        });
    </script>
</body>
</html> 