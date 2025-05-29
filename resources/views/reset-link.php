<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama Bağlantısı - EduCoach</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .cap-icon {
            margin-right: 10px;
        }
        
        .brand-name {
            font-size: 36px;
            color: #6C4AB6;
            font-weight: 600;
        }
        
        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }
        
        .title {
            font-size: 24px;
            color: #6C4AB6;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success-box {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .success-message {
            color: #155724;
            margin-bottom: 15px;
        }
        
        .reset-link-container {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            word-break: break-all;
        }
        
        .reset-link {
            color: #6C4AB6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .btn {
            display: inline-block;
            background-color: #6C4AB6;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            margin-top: 10px;
        }
        
        .btn:hover {
            background-color: #553692;
        }
        
        .info-box {
            background-color: #e2f3f5;
            border: 1px solid #b6d7dc;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .info-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #0c5460;
        }
        
        .info-text {
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <div class="logo">
            <svg class="cap-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                <path fill="#6C4AB6" d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                <path fill="#6C4AB6" d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
            </svg>
            <h1 class="brand-name">EduCoach</h1>
        </div>
    </div>
    
    <div class="container">
        <h2 class="title">Şifre Sıfırlama Bağlantısı</h2>
        
        <div class="success-box">
            <p class="success-message">
                <strong><?php echo htmlspecialchars($email); ?></strong> adresine bir şifre sıfırlama bağlantısı gönderildi.
            </p>
            <p>Bu bağlantı 1 saat boyunca geçerli olacaktır.</p>
        </div>
        
        <div class="reset-link-container">
            <p>Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın:</p>
            <a href="<?php echo htmlspecialchars($resetLink); ?>" class="reset-link"><?php echo htmlspecialchars($resetLink); ?></a>
        </div>
        
        <div style="text-align: center;">
            <a href="/login" class="btn">Giriş Sayfasına Dön</a>
        </div>
        
        <div class="info-box">
            <h3 class="info-title">Not:</h3>
            <p class="info-text">
                Gerçek bir uygulamada, bu bağlantı size e-posta ile gönderilir.
                Bu gösterim sadece geliştirme amaçlıdır.
            </p>
        </div>
    </div>
</body>
</html> 