<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bekleyen Sonuçlar - EduCoach</title>
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
        
        /* Table Styles */
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table thead th {
            background-color: #f5f0e8;
            font-weight: 600;
            color: #5a4a3f;
        }
        
        .table tbody tr:hover {
            background-color: #f5f0e8;
        }
        
        /* Status and Action Buttons */
        .status-waiting {
            background-color: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
        }
        
        .btn-approve {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-approve:hover {
            background-color: #218838;
        }
        
        .btn-reject {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-reject:hover {
            background-color: #c82333;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 0;
            color: #8d7b6e;
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
        
        /* Alert Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#fff">
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
        <h2 class="section-title">Onay Bekleyen Sonuçlar</h2>

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

        <?php if (count($bekleyenSonuclar) > 0): ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Öğrenci</th>
                            <th>Ders</th>
                            <th>Tarih</th>
                            <th>Çözülen</th>
                            <th>Doğru</th>
                            <th>Yanlış</th>
                            <th>Boş</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bekleyenSonuclar as $sonuc): ?>
                            <tr>
                                <td><?php echo $sonuc->ogrenci_adi; ?></td>
                                <td><?php echo $sonuc->ders_adi; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($sonuc->tarih)); ?></td>
                                <td><?php echo $sonuc->cozuldu_soru; ?></td>
                                <td><?php echo $sonuc->dogru; ?></td>
                                <td><?php echo $sonuc->yanlis; ?></td>
                                <td><?php echo $sonuc->bos; ?></td>
                                <td>
                                    <span class="status-waiting">Beklemede</span>
                                </td>
                                <td>
                                    <button class="btn-approve" onclick="openApproveModal(<?php echo $sonuc->id; ?>, 'onaylandi')">Onayla</button>
                                    <button class="btn-reject" onclick="openApproveModal(<?php echo $sonuc->id; ?>, 'reddedildi')">Reddet</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-message">Onay bekleyen sonuç bulunmuyor</div>
                <div class="empty-state-submessage">Öğrencileriniz görevlerinde ilerleme kaydettikçe burada görüntülenecektir.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Approval Modal -->
    <div id="approvalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeApproveModal()">&times;</span>
            <h3 id="modalTitle">Sonuç Onaylama</h3>
            <form id="approvalForm" action="" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" id="approvalStatus" name="onay_durumu" value="">
                
                <div style="margin-bottom: 20px;">
                    <label for="not" style="display: block; margin-bottom: 10px; font-weight: 500;">Not (İsteğe Bağlı)</label>
                    <textarea id="not" name="not" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                </div>
                
                <div style="display: flex; justify-content: flex-end;">
                    <button type="button" onclick="closeApproveModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 15px; border-radius: 5px; margin-right: 10px;">İptal</button>
                    <button type="submit" id="confirmButton" style="background-color: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 5px;">Onayla</button>
                </div>
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
        // Modal functions
        function openApproveModal(id, status) {
            document.getElementById('approvalForm').action = '/koc/sonuc-onayla/' + id;
            document.getElementById('approvalStatus').value = status;
            
            // Set modal title and button text based on status
            if (status === 'onaylandi') {
                document.getElementById('modalTitle').textContent = 'Sonuç Onaylama';
                document.getElementById('confirmButton').textContent = 'Onayla';
                document.getElementById('confirmButton').style.backgroundColor = '#28a745';
            } else {
                document.getElementById('modalTitle').textContent = 'Sonuç Reddetme';
                document.getElementById('confirmButton').textContent = 'Reddet';
                document.getElementById('confirmButton').style.backgroundColor = '#dc3545';
            }
            
            // Show modal
            document.getElementById('approvalModal').style.display = 'block';
        }
        
        function closeApproveModal() {
            document.getElementById('approvalModal').style.display = 'none';
            document.getElementById('not').value = '';
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('approvalModal');
            if (event.target == modal) {
                closeApproveModal();
            }
        }
        
        // Sidebar Toggle Script for Mobile
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