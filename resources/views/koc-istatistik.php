<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstatistikler - Koç Paneli</title>
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
            justify-content: center;
        }
        
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
                margin-top: 0;
                display: flex;
                justify-content: center;
            }
        }
        
        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: #5a4a3f;
            border-bottom: 2px solid #C4A484;
            padding-bottom: 10px;
            width: 100%;
            max-width: 1000px;
        }
        
        /* Statistics Styles */
        .stats-container {
            max-width: 1000px;
            width: 100%;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        @media (min-width: 576px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-value {
            font-size: 40px;
            font-weight: 600;
            color: #8B6B4E;
            margin: 20px 0;
        }
        
        .stat-label {
            font-size: 14px;
            color: #8d7b6e;
            margin-bottom: 10px;
        }
        
        .best-student {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        @media (min-width: 576px) {
            .best-student {
                flex-direction: row;
                align-items: center;
            }
        }
        
        .student-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background-color: #e9e1d9;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .student-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        @media (min-width: 576px) {
            .student-image {
                margin: 0 20px 0 0;
            }
        }
        
        .student-details h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #5a4a3f;
            text-align: center;
        }
        
        @media (min-width: 576px) {
            .student-details h3 {
                text-align: left;
            }
        }
        
        .student-details p {
            font-size: 14px;
            color: #8d7b6e;
            margin-bottom: 10px;
            text-align: center;
        }
        
        @media (min-width: 576px) {
            .student-details p {
                text-align: left;
            }
        }
        
        .progress-container {
            margin-top: 10px;
            width: 100%;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .progress-label span {
            font-size: 14px;
            color: #8d7b6e;
        }
        
        .progress-bar {
            height: 10px;
            background-color: #e9e1d9;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #8B6B4E;
            border-radius: 5px;
        }
        
        .chart-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .chart-title {
            font-size: 18px;
            color: #5a4a3f;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        /* Subject Performance Table Styles */
        .subject-performance-container {
            display: flex;
            overflow-x: auto;
            padding: 0 10px 10px;
            align-items: flex-end;
            gap: 10px;
            min-width: 1000px; /* Ensure enough space for all subjects */
        }
        
        .chart-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            height: 100%;
            position: relative;
            justify-content: flex-end;
            min-width: 60px;
        }
        
        .chart-bar {
            width: 30px;
            background-color: #8B6B4E;
            border-radius: 8px 8px 0 0;
            position: relative;
            transition: height 0.5s ease;
        }
        
        .chart-value {
            position: absolute;
            top: -25px;
            width: 100%;
            text-align: center;
            font-weight: 600;
            color: #333;
        }
        
        .chart-label {
            margin-top: 5px;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }
        
        .progress {
            height: 20px !important;
            background-color: #e9e1d9;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 0;
        }
        
        .progress-bar {
            background-color: #8B6B4E !important;
            border-radius: 5px;
            transition: width 0.5s ease;
        }
        
        /* Add padding to ensure elements aren't cut off */
        #subjectPerformanceChart {
            display: flex;
            height: 250px !important;
            justify-content: space-between;
            align-items: flex-end;
            padding: 30px 10px 20px;
            background-color: white;
            margin-top: 20px;
            min-width: 1000px; /* Ensure enough space for all subjects */
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
        <div class="stats-container">
            <h2 class="section-title">İstatistikler</h2>
            
            <!-- Özet Bilgiler -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Toplam Öğrenci Sayısı</div>
                    <div class="stat-value"><?php echo $toplam_ogrenci; ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Toplam Görev Sayısı</div>
                    <div class="stat-value"><?php echo $toplam_gorev; ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Ortalama Doğru Oranı</div>
                    <div class="stat-value"><?php echo number_format($ortalama_dogru_orani, 1); ?>%</div>
                </div>
            </div>
            
            <!-- En Başarılı Öğrenci -->
            <div class="best-student">
                <div class="student-image">
                    <?php if ($en_basarili_ogrenci && isset($en_basarili_ogrenci->profile_photo)): ?>
                        <img src="<?php echo asset($en_basarili_ogrenci->profile_photo); ?>" alt="<?php echo $en_basarili_ogrenci->name; ?>">
                    <?php elseif ($en_basarili_ogrenci): ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($en_basarili_ogrenci->name); ?>&background=8B6B4E&color=fff&size=150" alt="<?php echo $en_basarili_ogrenci->name; ?>">
                    <?php endif; ?>
                </div>
                
                <div class="student-details">
                    <h3>En Başarılı Öğrenci: <?php echo $en_basarili_ogrenci ? $en_basarili_ogrenci->name : 'Henüz Yok'; ?></h3>
                    <p><?php echo $en_basarili_ogrenci ? $en_basarili_ogrenci->toplam_dogru . ' doğru / ' . $en_basarili_ogrenci->toplam_soru . ' soru' : ''; ?></p>
                    
                    <?php if ($en_basarili_ogrenci): ?>
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Doğru Cevap Oranı</span>
                                <span><?php echo $en_basarili_ogrenci->basari_yuzdesi; ?>%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $en_basarili_ogrenci->basari_yuzdesi; ?>%"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Ders Bazında Performans Grafiği -->
            <div class="chart-container">
                <h3 class="chart-title">Ders Bazında Performans</h3>
                <div id="subjectPerformanceChart" class="subject-performance-container">
                    <!-- Bar charts will be dynamically created here -->
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
    
    <script>
        // Create subject performance chart with bars
        function createSubjectPerformanceChart() {
            const container = document.getElementById('subjectPerformanceChart');
            
            // Get data directly from PHP variables
            const subjects = <?php echo json_encode($dersler); ?>;
            const performanceData = <?php echo json_encode($ders_dogru_oranlari); ?>;
            
            // Clear container
            container.innerHTML = '';
            
            // Find the maximum value (minimum 1 to avoid division by zero)
            const maxValue = Math.max(...performanceData, 1);
            
            // Create columns for each subject
            for (let i = 0; i < subjects.length; i++) {
                const subject = subjects[i];
                const value = performanceData[i] || 0;
                
                // Calculate height percentage (minimum 2px if there's any value)
                const heightPercentage = value > 0 ? Math.max((value / maxValue) * 100, 2) : 0;
                
                // Create column element
                const column = document.createElement('div');
                column.className = 'chart-column';
                
                // Create bar element
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = `${heightPercentage}%`;
                
                // Create value label
                const valueElement = document.createElement('div');
                valueElement.className = 'chart-value';
                valueElement.textContent = value.toFixed(1);
                
                // Create subject label
                const label = document.createElement('div');
                label.className = 'chart-label';
                label.textContent = subject;
                label.title = subject; // For tooltip on hover
                
                // Append elements
                bar.appendChild(valueElement);
                column.appendChild(bar);
                column.appendChild(label);
                container.appendChild(column);
            }
        }
        
        // Call functions when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            createSubjectPerformanceChart();
            
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