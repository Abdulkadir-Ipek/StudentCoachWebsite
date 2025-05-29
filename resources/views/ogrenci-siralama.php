<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sıralama - EduCoach</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Base styles */
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

        /* Alert Styles */
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
        
        /* Subject Cards Grid */
        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .subject-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .subject-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        
        .subject-header {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        
        .subject-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        
        .ranking-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .ranking-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .ranking-item:last-child {
            border-bottom: none;
        }
        
        .ranking-position {
            width: 26px;
            height: 26px;
            background-color: #6c4ab6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
            font-size: 12px;
        }
        
        .ranking-position.top-1 {
            background-color: gold;
            color: #333;
        }
        
        .ranking-position.top-2 {
            background-color: silver;
            color: #333;
        }
        
        .ranking-position.top-3 {
            background-color: #cd7f32; /* Bronze */
            color: white;
        }
        
        .ranking-user {
            flex: 1;
        }
        
        .ranking-name {
            font-size: 14px;
            font-weight: 600;
        }
        
        .ranking-details {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
        
        .ranking-percentage {
            font-size: 16px;
            font-weight: 600;
            color: #6c4ab6;
        }
        
        .no-data-message {
            text-align: center;
            padding: 15px;
            color: #888;
            font-size: 14px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .subjects-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .subjects-grid {
                grid-template-columns: 1fr;
                gap: 15px;
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

        <h2 class="section-title">📈 Sıralama</h2>
        
        <!-- Subjects Grid with Rankings -->
        <div class="subjects-grid">
            <?php
            // Define all subjects passed from controller
            $tumDersler = array_keys($siralamaVerisi);
            
            // Output each subject card with rankings
            foreach ($tumDersler as $ders):
            ?>
                <div class="subject-card">
                    <div class="subject-header">
                        <h3 class="subject-name"><?php echo $ders; ?></h3>
                    </div>
                    
                    <ul class="ranking-list">
                        <?php
                        // Get top 5 students for this subject
                        $topOgrenciler = [];
                        if (isset($siralamaVerisi[$ders]) && count($siralamaVerisi[$ders]) > 0) {
                            $topOgrenciler = $siralamaVerisi[$ders]->slice(0, 5);
                        }
                        
                        if (count($topOgrenciler) > 0):
                            $sira = 1;
                            foreach ($topOgrenciler as $ogrenci):
                                // Calculate percentage
                                $yuzde = round($ogrenci->oran, 1);
                                
                                // Format name for privacy
                                $isim = explode(' ', $ogrenci->name);
                                $firstName = $isim[0];
                                $lastInitial = isset($isim[1]) ? mb_substr($isim[1], 0, 1) . '.' : '';
                                $formattedName = $firstName . ' ' . $lastInitial;
                        ?>
                            <li class="ranking-item">
                                <div class="ranking-position <?php echo $sira <= 3 ? 'top-' . $sira : ''; ?>">
                                    <?php echo $sira; ?>
                                </div>
                                <div class="ranking-user">
                                    <div class="ranking-name"><?php echo $formattedName; ?></div>
                                    <div class="ranking-details"><?php echo $ogrenci->dogru; ?>/<?php echo $ogrenci->toplam; ?> doğru</div>
                                </div>
                                <div class="ranking-percentage">%<?php echo $yuzde; ?></div>
                            </li>
                        <?php
                                $sira++;
                            endforeach;
                        else:
                        ?>
                            <div class="no-data-message">
                                Bu ders için henüz sıralama verileri bulunmamaktadır.
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
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
            // Sidebar Toggle Script
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