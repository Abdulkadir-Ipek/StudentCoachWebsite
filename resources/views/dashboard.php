<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduCoach</title>
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
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .cap-icon {
            margin-right: 10px;
        }
        
        .brand-name {
            font-size: 24px;
            color: #6C4AB6;
            font-weight: 600;
        }
        
        .welcome-message {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .welcome-message h2 {
            color: #6C4AB6;
            margin-bottom: 10px;
        }
        
        .content-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .content-card h3 {
            color: #6C4AB6;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            background-color: #6C4AB6;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #553692;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <svg class="cap-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#6C4AB6" d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                    <path fill="#6C4AB6" d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                </svg>
                <h1 class="brand-name">EduCoach</h1>
            </div>
            <a href="#" class="btn">Çıkış Yap</a>
        </header>
        
        <div class="welcome-message">
            <h2>Hoş Geldin, <?php echo $user->name; ?>!</h2>
            <p>Öğrenci koçluk sistemine başarıyla giriş yaptın.</p>
        </div>
        
        <div class="content-card">
            <h3>Görevlerin</h3>
            <p>Şu anda aktif görevin bulunmuyor.</p>
        </div>
        
        <div class="content-card">
            <h3>İlerleme Durumun</h3>
            <p>Henüz ilerleme verisi bulunmuyor.</p>
        </div>
    </div>
</body>
</html> 