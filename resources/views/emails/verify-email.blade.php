<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-posta Adresinizi Doğrulayın - EduCoach</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f8ff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eaeaea;
        }
        .header h1 {
            color: #6C4AB6;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 30px 20px;
            color: #333333;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #6C4AB6;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            margin: 20px 0;
            border-radius: 6px;
            font-weight: 600;
        }
        .button:hover {
            background-color: #553692;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777777;
            font-size: 14px;
            border-top: 1px solid #eaeaea;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .logo svg {
            width: 40px;
            height: 40px;
        }
        .logo-text {
            color: #6C4AB6;
            font-size: 24px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                    <path fill="#6C4AB6" d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                    <path fill="#6C4AB6" d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                </svg>
                <span class="logo-text">EduCoach</span>
            </div>
            <h1>E-posta Adresinizi Doğrulayın</h1>
        </div>
        <div class="content">
            <p>Merhaba {{ $user->name }},</p>
            <p>EduCoach'a kayıt olduğunuz için teşekkür ederiz. Hesabınızı etkinleştirmek için lütfen aşağıdaki butona tıklayın:</p>
            <p style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">E-posta Adresimi Doğrula</a>
            </p>
            <p>Veya aşağıdaki bağlantıyı tarayıcınıza kopyalayabilirsiniz:</p>
            <p>{{ $verificationUrl }}</p>
            <p>Bu bağlantı 60 dakika boyunca geçerlidir.</p>
            <p>Eğer bu hesabı siz oluşturmadıysanız, bu e-postayı görmezden gelebilirsiniz.</p>
        </div>
        <div class="footer">
            <p>Saygılarımızla,<br>EduCoach Ekibi</p>
        </div>
    </div>
</body>
</html> 