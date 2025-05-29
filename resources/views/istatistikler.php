<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstatistikler - EduCoach</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            padding: 15px;
            margin-top: 15px;
            width: 100%;
            overflow-x: hidden;
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
        
        /* Stats Container */
        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 10px;
            width: 100%;
        }
        
        /* Summary Stats */
        .summary-stats {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
            width: 100%;
        }
        
        @media (min-width: 576px) {
            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        
        @media (min-width: 992px) {
            .summary-stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
        }
        
        @media (min-width: 576px) {
            .stat-card {
                padding: 20px;
            }
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
            fill: #6c4ab6;
        }
        
        @media (min-width: 576px) {
            .stat-icon {
                width: 50px;
                height: 50px;
                margin: 0 auto 15px;
            }
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #6c4ab6;
            margin-bottom: 5px;
        }
        
        @media (min-width: 576px) {
            .stat-value {
                font-size: 28px;
            }
        }
        
        .stat-label {
            color: #666;
            font-size: 16px;
        }
        
        /* Chart Sections */
        .chart-section {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            width: 100%;
            overflow-x: auto;
        }
        
        @media (min-width: 576px) {
            .chart-section {
                padding: 25px;
                margin-bottom: 30px;
            }
        }
        
        .chart-title {
            font-size: 20px;
            color: #6c4ab6;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .chart-container {
            height: 250px;
            position: relative;
            width: 100%;
            min-width: 300px;
        }
        
        @media (min-width: 576px) {
            .chart-container {
                height: 300px;
            }
        }
        
        /* Two Column Layout */
        .chart-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        @media (min-width: 992px) {
            .chart-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        /* Subject Table */
        .subject-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            overflow-x: auto;
            display: block;
            -webkit-overflow-scrolling: touch;
            min-width: 600px;
        }
        
        @media (min-width: 768px) {
            .subject-table {
                display: table;
                min-width: 100%;
            }
        }
        
        @media (min-width: 992px) {
            .subject-table {
                min-width: 800px;
            }
        }
        
        @media (min-width: 1200px) {
            .subject-table {
                min-width: 1000px;
            }
        }
        
        .subject-table th, .subject-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }
        
        @media (min-width: 576px) {
            .subject-table th, .subject-table td {
                padding: 12px 15px;
            }
        }
        
        .subject-table th {
            background-color: #f8f7fe;
            font-weight: 600;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        
        .subject-table tr:last-child td {
            border-bottom: none;
        }
        
        .subject-table tr:hover {
            background-color: #f8f7fe;
        }
        
        /* Subject Stats Container */
        .subject-stats {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            width: 100%;
            overflow-x: auto;
            margin-bottom: 30px;
        }
        
        @media (min-width: 576px) {
            .subject-stats {
                padding: 25px;
            }
        }
        
        @media (min-width: 992px) {
            .subject-stats {
                padding: 30px;
            }
        }
        
        /* Table Container */
        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 auto;
            max-width: 100%;
        }
        
        @media (min-width: 768px) {
            .table-container {
                max-width: 95%;
            }
        }
        
        @media (min-width: 992px) {
            .table-container {
                max-width: 90%;
            }
        }
        
        @media (min-width: 1200px) {
            .table-container {
                max-width: 85%;
            }
        }
        
        /* Stats Grid */
        .stats-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }
        
        @media (min-width: 576px) {
            .stats-grid {
                gap: 30px;
            }
        }
        
        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 20px;
        }
        
        @media (min-width: 576px) {
            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 992px) {
            .stats-cards {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Chart Panel */
        .chart-panel, .subject-stats {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            width: 100%;
            overflow-x: auto;
        }
        
        @media (min-width: 576px) {
            .chart-panel, .subject-stats {
                padding: 25px;
            }
        }
        
        /* Custom chart styles override */
        #dailyQuestionsChart {
            display: flex;
            height: 250px !important;
            justify-content: space-between;
            align-items: flex-end;
            padding: 20px 10px 30px;
            background-color: white;
            margin-top: 20px;
        }
        
        /* Column styling */
        .chart-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            height: 100%;
            position: relative;
            justify-content: flex-end;
        }
        
        /* Bar styling */
        .chart-bar {
            width: 30px;
            background-color: #6c4ab6;
            border-radius: 8px 8px 0 0;
            position: relative;
            transition: height 0.5s ease;
        }
        
        /* Value label */
        .chart-value {
            position: absolute;
            top: -25px;
            width: 100%;
            text-align: center;
            font-weight: 600;
            color: #333;
        }
        
        /* Day label */
        .chart-label {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 20px 0;
            color: #777;
        }
        
        @media (min-width: 576px) {
            .empty-state {
                padding: 30px 0;
            }
        }
        
        .empty-state-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: #ccc;
        }
        
        @media (min-width: 576px) {
            .empty-state-icon {
                font-size: 40px;
                margin-bottom: 15px;
            }
        }
        
        .empty-state-message {
            font-size: 16px;
            margin-bottom: 8px;
        }
        
        @media (min-width: 576px) {
            .empty-state-message {
                font-size: 18px;
                margin-bottom: 10px;
            }
        }
        
        .empty-state-submessage {
            font-size: 14px;
            color: #999;
        }
        
        /* New Statistics Styles */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            margin-right: 15px;
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        
        .stat-label {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }
        
        /* Chart Panel */
        .chart-panel, .subject-stats {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        #dailyQuestionsChart {
            display: flex;
            height: 300px;
            align-items: flex-end;
            padding: 20px 10px 30px;
        }
        
        .chart-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 5px;
        }
        
        .chart-bar {
            width: 80%;
            background-color: #6c4ab6;
            border-radius: 5px 5px 0 0;
            min-height: 5px;
            position: relative;
            transition: height 0.5s ease;
        }
        
        .chart-value {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 600;
            color: #333;
        }
        
        .chart-label {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }
        
        /* Responsive adjustments for stats cards and charts */
        @media (max-width: 767.98px) {
            .summary-stats,
            .stats-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .chart-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
        
        @media (min-width: 768px) and (max-width: 991.98px) {
            .summary-stats,
            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }
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
        <h2 class="section-title">İstatistikler</h2>
        
        <?php if (session('success')): ?>
            <div class="alert alert-success">
                <?php echo session('success'); ?>
            </div>
        <?php endif; ?>
        
        <div class="stats-grid">
            <!-- Top Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="#6c4ab6">
                            <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z"/>
                            <path d="M7 12H9V17H7V12Z"/>
                            <path d="M15 7H17V17H15V7Z"/>
                            <path d="M11 14H13V17H11V14Z"/>
                            <path d="M11 10H13V12H11V10Z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $toplamCozulenSoru; ?></div>
                        <div class="stat-label">Toplam Çözülen Soru</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="#6c4ab6">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $toplamDogru; ?></div>
                        <div class="stat-label">Toplam Doğru</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="#6c4ab6">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $toplamYanlis; ?></div>
                        <div class="stat-label">Toplam Yanlış</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="#6c4ab6">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $toplamBos; ?></div>
                        <div class="stat-label">Toplam Boş</div>
                    </div>
                </div>
            </div>
            
            <!-- Daily Question Chart -->
            <div class="chart-panel">
                <h3 class="chart-title">Günlük Soru Çözümü</h3>
                <div id="dailyQuestionsChart" class="chart-container"></div>
            </div>
            
            <!-- Subject Statistics -->
            <div class="subject-stats">
                <h3 class="chart-title">Ders İstatistikleri</h3>
                
                <?php if (count($dersIstatistikleri) > 0): ?>
                    <div class="table-container">
                        <table class="subject-table">
                            <thead>
                                <tr>
                                    <th>Ders</th>
                                    <th>Çözülen</th>
                                    <th>Doğru</th>
                                    <th>Yanlış</th>
                                    <th>Boş</th>
                                    <th>Başarı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dersIstatistikleri as $ders): ?>
                                    <tr>
                                        <td><?php echo $ders->ders_adi; ?></td>
                                        <td><?php echo $ders->toplam_cozulen; ?></td>
                                        <td><?php echo $ders->toplam_dogru; ?></td>
                                        <td><?php echo $ders->toplam_yanlis; ?></td>
                                        <td><?php echo $ders->toplam_bos; ?></td>
                                        <td>
                                            <?php 
                                                $basari = $ders->toplam_cozulen > 0 
                                                    ? round(($ders->toplam_dogru / $ders->toplam_cozulen) * 100) 
                                                    : 0;
                                                echo $basari . '%';
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📊</div>
                        <div class="empty-state-message">Henüz istatistik bulunmuyor.</div>
                        <div class="empty-state-submessage">Görevlerinizi tamamladıkça istatistikleriniz burada görüntülenecek.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Create the daily questions chart
        function createDailyQuestionsChart() {
            const container = document.getElementById('dailyQuestionsChart');
            const days = <?php echo json_encode(array_keys($gunlukSorular)); ?>;
            const counts = <?php echo json_encode(array_values($gunlukSorular)); ?>;
            
            // Clear the container first
            container.innerHTML = '';
            
            // Find the maximum value for scaling (minimum 1 to avoid division by zero)
            const maxCount = Math.max(...counts, 1);
            
            // Create each column
            for (let i = 0; i < days.length; i++) {
                // Create column element
                const column = document.createElement('div');
                column.className = 'chart-column';
                
                // Create bar element
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                
                // Set height (minimum 2px if there's any value)
                const heightPercentage = counts[i] > 0 ? Math.max((counts[i] / maxCount) * 100, 2) : 0;
                bar.style.height = `${heightPercentage}%`;
                
                // Create value label
                const value = document.createElement('div');
                value.className = 'chart-value';
                value.textContent = counts[i];
                
                // Create day label
                const label = document.createElement('div');
                label.className = 'chart-label';
                label.textContent = days[i];
                
                // Append elements
                bar.appendChild(value);
                column.appendChild(bar);
                column.appendChild(label);
                container.appendChild(column);
            }
        }
        
        // Initialize chart when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            createDailyQuestionsChart();
        });
    </script>

    <!-- Sidebar Toggle Button for Mobile -->
    <button class="sidebar-toggle d-md-none" id="sidebarToggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
        </svg>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
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