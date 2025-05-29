<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim - Koç Paneli</title>
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
            text-align: center;
        }
        
        /* Profile Form Styles */
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        
        @media (min-width: 576px) {
            .profile-header {
                flex-direction: row;
                align-items: center;
            }
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            background: #e9e1d9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        @media (min-width: 576px) {
            .profile-avatar {
                margin: 0 20px 0 0;
            }
        }
        
        .profile-title {
            font-size: 24px;
            color: #5a4a3f;
            font-weight: 600;
            margin-bottom: 5px;
            text-align: center;
        }
        
        @media (min-width: 576px) {
            .profile-title {
                text-align: left;
            }
        }
        
        .profile-subtitle {
            color: #8d7b6e;
            font-size: 16px;
            text-align: center;
        }
        
        @media (min-width: 576px) {
            .profile-subtitle {
                text-align: left;
            }
        }
        
        .form-title {
            font-size: 20px;
            color: #5a4a3f;
            margin-bottom: 20px;
            font-weight: 600;
            border-bottom: 2px solid #e9e1d9;
            padding-bottom: 10px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        @media (min-width: 576px) {
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
        
        @media (min-width: 576px) {
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
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dfd3c3;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            background-color: #fff;
            color: #5a4a3f;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #8B6B4E;
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
        
        .notification {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 14px;
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
        
        .btn-photo {
            background-color: #8B6B4E;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: inline-block;
        }

        .btn-photo:hover {
            background-color: #725639;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
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
        <div class="profile-container">
            <h2 class="section-title">Profilim</h2>
            
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
            
            <!-- 1. Profile Photo Section -->
            <div class="profile-card">
                <h3 class="form-title">Profil Fotoğrafı</h3>
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="<?php echo $user->profile_photo ? asset($user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8B6B4E&color=fff&size=150'; ?>" alt="<?php echo $user->name; ?>" id="avatarPreview">
                    </div>
                    <div>
                        <h3 class="profile-title"><?php echo $user->name; ?></h3>
                        <p class="profile-subtitle"><?php echo $user->email; ?></p>
                        <form action="/koc/profil-guncelle" method="POST" enctype="multipart/form-data" id="photoForm">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="update_photo_only" value="1">
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;" onchange="this.form.submit()">
                            <button type="button" class="btn-photo" onclick="document.getElementById('profile_photo').click()">Profil Fotoğrafı Değiştir</button>
                            <?php if (isset($errors) && $errors->has('profile_photo')): ?>
                                <div class="error-message"><?php echo $errors->first('profile_photo'); ?></div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Personal Info and Password Form -->
            <form action="/koc/profil-guncelle" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                
                <!-- 2. Personal Information Section -->
                <div class="profile-card">
                    <h3 class="form-title">Kişisel Bilgiler</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input type="text" id="name" name="name" class="form-input" value="<?php echo $user->name; ?>" required>
                            <?php if (isset($errors) && $errors->has('name')): ?>
                                <div class="error-message"><?php echo $errors->first('name'); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" id="email" name="email" class="form-input" value="<?php echo $user->email; ?>" required>
                            <?php if (isset($errors) && $errors->has('email')): ?>
                                <div class="error-message"><?php echo $errors->first('email'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- 3. Password Change Section -->
                <div class="profile-card">
                    <h3 class="form-title">Şifre Değiştir</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">Yeni Şifre</label>
                            <input type="password" id="password" name="password" class="form-input">
                            <?php if (isset($errors) && $errors->has('password')): ?>
                                <div class="error-message"><?php echo $errors->first('password'); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Bilgileri Güncelle</button>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit when a new photo is selected
            const fileInput = document.getElementById('profile_photo');
            const photoForm = document.getElementById('photoForm');
            const previewImg = document.getElementById('avatarPreview');
            
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Show loading state on the preview
                    previewImg.style.opacity = '0.5';
                    
                    // Submit the form automatically
                    photoForm.submit();
                }
            });
            
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
        });
    </script>
</body>
</html> 