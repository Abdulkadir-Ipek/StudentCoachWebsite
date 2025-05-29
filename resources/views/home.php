<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCoach - Öğrenci Koçluğu</title>
    <link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
    <header id="header">
        <div class="container header-container">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="brand-name">EduCoach</span>
            </a>
            
            <div class="menu-toggle" id="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            
            <nav class="navbar" id="navbar">
                <a href="/" class="nav-link active">Ana Sayfa</a>
                <a href="#features" class="nav-link">Özellikler</a>
                <a href="#how-it-works" class="nav-link">Nasıl Çalışır</a>
                <a href="#testimonials" class="nav-link">Başarı Hikayeleri</a>
                <a href="/login" class="btn btn-outline">Giriş Yap</a>
                <a href="/register" class="btn btn-primary">Kayıt Ol</a>
            </nav>
        </div>
    </header>
        
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div id="particles-js" class="hero-particles"></div>
            <div class="container">
                <div class="row">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-star"></i>
                            <span>Türkiye'nin En İyi Öğrenci Koçluk Platformu</span>
                        </div>
                        <h1 class="hero-title">Öğrenci Koçluğunda Yeni Nesil Yaklaşım</h1>
                        <p class="hero-subtitle">Profesyonel koçların rehberliğiyle akademik hedeflerine ulaş, görevlerini düzenli takip et ve başarı grafiğini sürekli yükselt.</p>
                        <div class="hero-btns">
                            <a href="/register" class="btn btn-primary">
                                <i class="fas fa-rocket"></i> Hemen Başla
                            </a>
                            <a href="#features" class="btn btn-outline">
                                <i class="fas fa-info-circle"></i> Daha Fazla Bilgi
                            </a>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="floating-stats">
                            <div class="stat-element" style="animation-delay: 0s;">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-text">5,000+ Aktif Öğrenci</div>
                            </div>
                            <div class="stat-element" style="animation-delay: 0.5s;">
                                <div class="stat-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stat-text">%92 Başarı Oranı</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hero-illustration">
                        
                        <!-- Dynamic floating icons -->
                        <div class="floating-icon" style="top: 5%; left: 15%; animation-delay: 0.7s;">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="floating-icon" style="top: 85%; right: 25%; animation-delay: 1.3s;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="floating-icon" style="top: 35%; right: 8%; animation-delay: 2.1s;">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <!-- Yeni uçan semboller -->
                    
                        <div class="floating-icon size-lg" style="top: 75%; left: 55%; animation-delay: 2s;">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                  
                        <div class="floating-icon size-lg" style="top: 48%; left: 28%; animation-delay: 3s;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    
                        <div class="floating-icon size-sm" style="top: 32%; left: 65%; animation-delay: 3.5s;">
                            <i class="fas fa-users"></i>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- Scroll indicator -->
            <div class="scroll-indicator">
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
                <div class="scroll-text">Kaydır</div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section id="features" class="features-section">
            <div class="container">
                <div class="section-header reveal">
                    <span class="section-subtitle">Neler Sunuyoruz?</span>
                    <h2 class="section-title">EduCoach'un Yenilikçi Özellikleri</h2>
                    <p class="section-description">Öğrencilerin akademik gelişimini desteklemek için tasarlanmış yenilikçi özelliklerimizle tanışın.</p>
                </div>
                
                <div class="tab-container">
                    <div class="feature-tabs">
                        <button class="feature-tab active" data-tab="tab1">
                            <i class="fas fa-tasks"></i>
                            <span>Görev Takibi</span>
                        </button>
                        <button class="feature-tab" data-tab="tab2">
                            <i class="fas fa-chart-line"></i>
                            <span>Performans</span>
                        </button>
                        <button class="feature-tab" data-tab="tab3">
                            <i class="fas fa-comments"></i>
                            <span>İletişim</span>
                        </button>
                        <button class="feature-tab" data-tab="tab4">
                            <i class="fas fa-brain"></i>
                            <span>Yapay Zeka</span>
                        </button>
                    </div>
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="tab-grid">
                                <div class="tab-info reveal-left">
                                    <h3 class="feature-title">Akıllı Görev Takibi</h3>
                                    <p class="feature-description">Yapay zeka destekli görev takip sistemi ile koçunuzun atadığı görevleri önceliklendirir ve zamanında tamamlamanızı sağlar.</p>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i> Akıllı önceliklendirme</li>
                                        <li><i class="fas fa-check"></i> Hatırlatma bildirimleri</li>
                                        <li><i class="fas fa-check"></i> Kolay görev tamamlama</li>
                                        <li><i class="fas fa-check"></i> İlerleme takibi</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Daha Fazla <i class="fas fa-arrow-right"></i></a>
                                </div>
                                <div class="tab-image reveal-right">
                                    <div class="feature-card-3d">
                                        <div class="card-icon-container">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="task-list">
                                                <div class="task-item">
                                                    <span class="task-checkbox completed"><i class="fas fa-check"></i></span>
                                                    <span class="task-text">Matematik Ödevi</span>
                                                </div>
                                                <div class="task-item">
                                                    <span class="task-checkbox in-progress"><i class="fas fa-clock"></i></span>
                                                    <span class="task-text">Fizik Formülleri</span>
                                                </div>
                                                <div class="task-item">
                                                    <span class="task-checkbox"><i class="fas fa-circle"></i></span>
                                                    <span class="task-text">İngilizce Testi</span>
                                                </div>
                                            </div>
                                            <div class="floating-icons-container">
                                                <div class="floating-mini-icon" style="top: 10%; left: 10%;"><i class="fas fa-check-circle"></i></div>
                                                <div class="floating-mini-icon" style="top: 70%; left: 80%;"><i class="fas fa-calendar-check"></i></div>
                                                <div class="floating-mini-icon" style="top: 40%; left: 90%;"><i class="fas fa-bell"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tab2">
                            <div class="tab-grid">
                                <div class="tab-info reveal-left">
                                    <h3 class="feature-title">Performans Analizi</h3>
                                    <p class="feature-description">İnteraktif grafikler ve detaylı raporlarla çalışma performansınızı analiz edin, güçlü ve zayıf yönlerinizi keşfedin.</p>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i> Gerçek zamanlı grafikler</li>
                                        <li><i class="fas fa-check"></i> Kişisel gelişim analizleri</li>
                                        <li><i class="fas fa-check"></i> Hedefe göre ilerleme takibi</li>
                                        <li><i class="fas fa-check"></i> Gelişim raporları</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Daha Fazla <i class="fas fa-arrow-right"></i></a>
                                </div>
                                <div class="tab-image reveal-right">
                                    <div class="feature-card-3d">
                                        <div class="card-icon-container">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="performance-chart">
                                                <div class="chart-column" style="height: 40%;">
                                                    <div class="column-bar"></div>
                                                    <div class="column-label">Pzt</div>
                                                </div>
                                                <div class="chart-column" style="height: 65%;">
                                                    <div class="column-bar"></div>
                                                    <div class="column-label">Sal</div>
                                                </div>
                                                <div class="chart-column" style="height: 35%;">
                                                    <div class="column-bar"></div>
                                                    <div class="column-label">Çar</div>
                                                </div>
                                                <div class="chart-column" style="height: 80%;">
                                                    <div class="column-bar"></div>
                                                    <div class="column-label">Per</div>
                                                </div>
                                                <div class="chart-column highlighted" style="height: 90%;">
                                                    <div class="column-bar"></div>
                                                    <div class="column-label">Cum</div>
                                                </div>
                                            </div>
                                            <div class="floating-icons-container">
                                                <div class="floating-mini-icon" style="top: 20%; left: 20%;"><i class="fas fa-trophy"></i></div>
                                                <div class="floating-mini-icon" style="top: 60%; left: 80%;"><i class="fas fa-arrow-up"></i></div>
                                                <div class="floating-mini-icon" style="top: 80%; left: 40%;"><i class="fas fa-medal"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tab3">
                            <div class="tab-grid">
                                <div class="tab-info reveal-left">
                                    <h3 class="feature-title">Gerçek Zamanlı İletişim</h3>
                                    <p class="feature-description">Koçunuzla anlık mesajlaşma, sesli ve görüntülü görüşme özellikleriyle iletişimi kesintisiz sürdürün.</p>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i> Anlık mesajlaşma</li>
                                        <li><i class="fas fa-check"></i> Sesli ve görüntülü görüşme</li>
                                        <li><i class="fas fa-check"></i> Dosya paylaşımı</li>
                                        <li><i class="fas fa-check"></i> Ekran paylaşımı</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Daha Fazla <i class="fas fa-arrow-right"></i></a>
                                </div>
                                <div class="tab-image reveal-right">
                                    <div class="feature-card-3d">
                                        <div class="card-icon-container">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="chat-window">
                                                <div class="chat-message coach">
                                                    <div class="message-avatar">K</div>
                                                    <div class="message-bubble">Sınava hazır mısın?</div>
                                                </div>
                                                <div class="chat-message student">
                                                    <div class="message-bubble">Konuları bitirdim!</div>
                                                </div>
                                                <div class="chat-message coach">
                                                    <div class="message-avatar">K</div>
                                                    <div class="message-bubble">Harika! Birlikte test çözelim.</div>
                                                </div>
                                            </div>
                                            <div class="floating-icons-container">
                                                <div class="floating-mini-icon" style="top: 15%; left: 15%;"><i class="fas fa-video"></i></div>
                                                <div class="floating-mini-icon" style="top: 70%; left: 85%;"><i class="fas fa-phone"></i></div>
                                                <div class="floating-mini-icon" style="top: 50%; left: 90%;"><i class="fas fa-file-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tab4">
                            <div class="tab-grid">
                                <div class="tab-info reveal-left">
                                    <h3 class="feature-title">Yapay Zeka Desteği</h3>
                                    <p class="feature-description">Çalışma alışkanlıklarınızı analiz eden ve size özel öneriler sunan yapay zeka algoritmalarıyla verimli çalışın.</p>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i> Kişiselleştirilmiş öneriler</li>
                                        <li><i class="fas fa-check"></i> Öğrenme tarzı analizi</li>
                                        <li><i class="fas fa-check"></i> Çalışma programı optimizasyonu</li>
                                        <li><i class="fas fa-check"></i> Akıllı kaynak önerileri</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Daha Fazla <i class="fas fa-arrow-right"></i></a>
                                </div>
                                <div class="tab-image reveal-right">
                                    <div class="feature-card-3d">
                                        <div class="card-icon-container">
                                            <i class="fas fa-brain"></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="ai-recommendation">
                                                <div class="ai-header">
                                                    <i class="fas fa-robot"></i>
                                                    <span>Yapay Zeka Önerisi</span>
                                                </div>
                                                <div class="ai-body">
                                                    <p>Son 2 haftada matematik performansın %15 arttı!</p>
                                                    <div class="ai-stats">
                                                        <div class="stat-item">
                                                            <div class="stat-value">92<span>%</span></div>
                                                            <div class="stat-label">Verimlilik</div>
                                                        </div>
                                                        <div class="stat-item">
                                                            <div class="stat-value">8.5</div>
                                                            <div class="stat-label">Saat/Hafta</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="floating-icons-container">
                                                <div class="floating-mini-icon" style="top: 10%; left: 30%;"><i class="fas fa-lightbulb"></i></div>
                                                <div class="floating-mini-icon" style="top: 80%; left: 20%;"><i class="fas fa-cogs"></i></div>
                                                <div class="floating-mini-icon" style="top: 50%; left: 10%;"><i class="fas fa-magic"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="features-counter reveal">
                    <div class="counter-item">
                        <div class="counter-number" data-count="5000">0</div>
                        <div class="counter-label">Aktif Öğrenci</div>
                    </div>
                    <div class="counter-item">
                        <div class="counter-number" data-count="120">0</div>
                        <div class="counter-label">Profesyonel Koç</div>
                    </div>
                    <div class="counter-item">
                        <div class="counter-number" data-count="85000">0</div>
                        <div class="counter-label">Tamamlanan Görev</div>
                    </div>
                    <div class="counter-item">
                        <div class="counter-number" data-count="92">0</div>
                        <div class="counter-label">Başarı Oranı (%)</div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- How It Works Section -->
        <section id="how-it-works" class="how-it-works-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-subtitle">Basit Adımlar</span>
                    <h2 class="section-title">EduCoach Nasıl Çalışır?</h2>
                    <p class="section-description">Platform üzerinde başarıya giden yolculuğunuz dört basit adımdan oluşur</p>
                </div>
                
                <div class="timeline">
                    <div class="timeline-container left">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h3 class="timeline-title">Kayıt Olun</h3>
                            <p class="timeline-description">Hızlı kayıt formunu doldurun ve ilgi alanlarınızı, hedeflerinizi belirleyin. Sistemimiz size en uygun koç önerilerini sunacaktır.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-container right">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="timeline-title">Koçunuzu Seçin</h3>
                            <p class="timeline-description">Size önerilen koçların profilleri, uzmanlık alanları ve öğrenci yorumlarını inceleyin. Size en uygun koçu seçerek eğitim yolculuğunuza başlayın.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-container left">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h3 class="timeline-title">Hedeflerinizi Belirleyin</h3>
                            <p class="timeline-description">Koçunuzla birlikte kişiselleştirilmiş akademik hedefler ve çalışma planları oluşturun. Sistem bu hedefleri takip ederek günlük görevler atar.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-container right">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3 class="timeline-title">Gelişiminizi Takip Edin</h3>
                            <p class="timeline-description">İlerleme grafiklerinizi, tamamlanan görevleri ve başarı istatistiklerinizi takip edin. Koçunuzdan düzenli geri bildirimler alarak performansınızı artırın.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-subtitle">Kullanıcı Deneyimleri</span>
                    <h2 class="section-title">Başarı Hikayeleri</h2>
                    <p class="section-description">Öğrencilerimizin EduCoach ile elde ettikleri başarılar ve deneyimler</p>
                </div>
                
                <div class="testimonial-cards">
                    <div class="testimonial-card">
                        <p class="testimonial-text">EduCoach ile çalışma disiplinimi tamamen değiştirdim. Koçumun günlük hedefler belirlemesi ve akıllı bildirimlerle takip etmesi motivasyonumu yükseltti. 3 ayda YKS denemelerinde 150 puan artış sağladım!</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">M</div>
                            <div class="author-info">
                                <h4>Mehmet K.</h4>
                                <p>12. Sınıf Öğrencisi</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <p class="testimonial-text">Koçumla gerçek zamanlı iletişim özelliği akademik hayatımı değiştirdi. Takıldığım konularda anında yardım alabiliyor, performans grafiklerim sayesinde zayıf yönlerimi keşfedip geliştirebiliyorum.</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">Z</div>
                            <div class="author-info">
                                <h4>Zeynep A.</h4>
                                <p>11. Sınıf Öğrencisi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title">Başarı Yolculuğuna Hemen Başla!</h2>
                    <p class="cta-description">Profesyonel koçların rehberliğinde, yapay zeka destekli öğrenme deneyimiyle akademik hedeflerine ulaş.</p>
                    <div class="cta-buttons">
                        <a href="/register" class="btn btn-light">Hemen Kayıt Ol</a>
                        <a href="#" class="btn btn-outline-light">Demo İncele</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-info">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <span class="footer-brand">EduCoach</span>
                    </div>
                    <p class="footer-description">
                        Yenilikçi öğrenci koçluk platformu ile akademik başarınızı artırın. Profesyonel koçlarımız ve yapay zeka destekli sistemimizle her zaman yanınızdayız.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3 class="footer-title">Hızlı Linkler</h3>
                    <ul class="footer-links">
                        <li><a href="/">Ana Sayfa</a></li>
                        <li><a href="#features">Özellikler</a></li>
                        <li><a href="#testimonials">Başarı Hikayeleri</a></li>
                        <li><a href="/login">Giriş Yap</a></li>
                        <li><a href="/register">Kayıt Ol</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3 class="footer-title">İletişim</h3>
                    <div class="contact-info">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <p>Mühendislik Fakültesi Bilgisayar Mühendisliği Bölümü
                        Hitit Üniversitesi Mühendislik Fakültesi Çevre Yolu Bulvarı No: 8 19030 ÇORUM<br>Çorum, Türkiye</p>
                    </div>
                    <div class="contact-info">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <p>+90 (507) 617 3853</p>
                    </div>
                    <div class="contact-info">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <p>info@educoach.com</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="copyright">© 2023 EduCoach. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Particles.js initialization
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#6C4AB6"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#6C4AB6",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.5
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });

            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const navbar = document.getElementById('navbar');
            
            menuToggle.addEventListener('click', function() {
                menuToggle.classList.toggle('active');
                navbar.classList.toggle('active');
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        // Close mobile menu if open
                        menuToggle.classList.remove('active');
                        navbar.classList.remove('active');
                        
                        // Scroll to the target
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Tabs functionality
            const tabs = document.querySelectorAll('.feature-tab');
            const tabPanes = document.querySelectorAll('.tab-pane');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');
                    
                    // Remove active class from all tabs and panes
                    tabs.forEach(t => t.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));
                    
                    // Add active class to current tab and pane
                    tab.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Scroll animations
            function revealOnScroll() {
                const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
                
                reveals.forEach(el => {
                    const windowHeight = window.innerHeight;
                    const revealTop = el.getBoundingClientRect().top;
                    const revealPoint = 150;
                    
                    if (revealTop < windowHeight - revealPoint) {
                        el.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll(); // Initial check on page load
            
            // Counter animation
            function startCounters() {
                const counters = document.querySelectorAll('.counter-number');
                const speed = 200;
                
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-count');
                        const count = +counter.innerText;
                        const increment = Math.ceil(target / speed);
                        
                        if (count < target) {
                            counter.innerText = Math.min(count + increment, target);
                            setTimeout(updateCount, 30);
                        }
                    };
                    
                    updateCount();
                });
            }
            
            // Start counters when they come into view
            const countersSection = document.querySelector('.features-counter');
            
            function checkCounters() {
                if (countersSection) {
                    const windowHeight = window.innerHeight;
                    const counterTop = countersSection.getBoundingClientRect().top;
                    
                    if (counterTop < windowHeight - 100) {
                        startCounters();
                        window.removeEventListener('scroll', checkCounters);
                    }
                }
            }
            
            window.addEventListener('scroll', checkCounters);
            checkCounters(); // Initial check
            
            // Active navigation based on scroll position
            function setActiveNavigation() {
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('.nav-link');
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    const sectionHeight = section.offsetHeight;
                    const scrollPosition = window.scrollY;
                    
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        const targetLink = document.querySelector(`.nav-link[href="#${section.id}"]`);
                        
                        navLinks.forEach(navLink => {
                            navLink.classList.remove('active');
                        });
                        
                        if (targetLink) {
                            targetLink.classList.add('active');
                        }
                    }
                });
            }
            
            window.addEventListener('scroll', setActiveNavigation);
            setActiveNavigation(); // Initial check
        });
    </script>
</body>
</html> 