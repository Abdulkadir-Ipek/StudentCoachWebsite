<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $ogrenci->name; ?> Görevleri - Koç Paneli</title>
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
        
        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            color: #8B6B4E;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .back-button svg {
            margin-right: 8px;
        }
        
        /* Student Info Styles */
        .student-header {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        
        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            background-color: #8B6B4E;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 32px;
            overflow: hidden;
        }
        
        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .student-info {
            flex: 1;
        }
        
        .student-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #5a4a3f;
        }
        
        .student-email {
            color: #8d7b6e;
            font-size: 16px;
        }
        
        /* Tasks Table Styles */
        .tasks-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .tasks-title {
            padding: 20px;
            border-bottom: 1px solid #e9e1d9;
            font-size: 20px;
            font-weight: 600;
        }
        
        .tasks-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .tasks-table th,
        .tasks-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9e1d9;
        }
        
        .tasks-table th {
            background-color: #f5f0e8;
            font-weight: 600;
            color: #5a4a3f;
        }
        
        .tasks-table tbody tr:hover {
            background-color: #f9f7f4;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .badge-started {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-progress {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .no-tasks {
            padding: 50px;
            text-align: center;
            color: #8d7b6e;
        }

        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Öğrencilerim
                </a>
            </li>
            <li>
                <a href="/koc/gorevler" class="menu-item <?php echo $active_page === 'gorevler' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                    </svg>
                    Görev Yönetimi
                </a>
            </li>
            <li>
                <a href="/koc/mesajlar" class="menu-item <?php echo $active_page === 'mesajlar' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                    </svg>
                    Mesajlar
                </a>
            </li>
            <li>
                <a href="/koc/istatistik" class="menu-item <?php echo $active_page === 'istatistik' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    İstatistikler
                </a>
            </li>
            <li>
                <a href="/koc/profil" class="menu-item <?php echo $active_page === 'profil' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Profilim
                </a>
            </li>
            <li>
                <form action="/logout" method="POST" style="margin: 0;">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="menu-item" style="width: 100%; text-align: left; background: none; border: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
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
        <a href="/koc/ogrenciler" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Öğrencilerim
        </a>
        
        <h2 class="section-title">Öğrenci Görevleri</h2>
        
        <?php if (session('error')): ?>
            <div class="notification error">
                <?php echo session('error'); ?>
            </div>
        <?php endif; ?>
        
        <?php if (session('success')): ?>
            <div class="notification success">
                <?php echo session('success'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Student Info -->
        <div class="student-header">
            <div class="student-avatar">
                <?php if ($ogrenci->profile_photo): ?>
                    <img src="<?php echo asset($ogrenci->profile_photo); ?>" alt="<?php echo $ogrenci->name; ?>">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($ogrenci->name); ?>&background=8B6B4E&color=fff&size=150" alt="<?php echo $ogrenci->name; ?>">
                <?php endif; ?>
            </div>
            <div class="student-info">
                <h3 class="student-name"><?php echo $ogrenci->name; ?></h3>
                <p class="student-email"><?php echo $ogrenci->email; ?></p>
            </div>
        </div>
        
        <!-- Tasks Table -->
        <div class="tasks-container">
            <h3 class="tasks-title">Görev Listesi</h3>
            
            <?php if (count($gorevler) > 0): ?>
                <table class="tasks-table">
                    <thead>
                        <tr>
                            <th>Ders</th>
                            <th>Atanan Soru</th>
                            <th>Çözülen</th>
                            <th>Doğru</th>
                            <th>Yanlış</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gorevler as $gorev): ?>
                            <tr>
                                <td><?php echo $gorev->ders_adi; ?></td>
                                <td><?php echo $gorev->toplam_soru_sayisi; ?></td>
                                <td><?php echo $gorev->cozulen_soru; ?></td>
                                <td><?php echo $gorev->dogru; ?></td>
                                <td><?php echo $gorev->yanlis; ?></td>
                                <td>
                                    <?php if ($gorev->durum === 'Başlamadı'): ?>
                                        <span class="badge badge-started">Başlamadı</span>
                                    <?php elseif ($gorev->durum === 'Devam Ediyor'): ?>
                                        <span class="badge badge-progress">Devam Ediyor</span>
                                    <?php else: ?>
                                        <span class="badge badge-completed">Tamamlandı</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-tasks">
                    <p>Bu öğrenciye henüz hiç görev atanmamış.</p>
                </div>
            <?php endif; ?>
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