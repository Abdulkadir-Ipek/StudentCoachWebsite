<!DOCTYPE html>
<html>
<head>
    <title>Şifre Sıfırlama</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .header { 
            background-color: #6C4AB6; 
            color: white; 
            padding: 20px; 
            text-align: center; 
        }
        .content { 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-top: none; 
        }
        .button { 
            display: inline-block; 
            background-color: #6C4AB6; 
            color: white !important; 
            text-decoration: none; 
            padding: 10px 20px; 
            border-radius: 5px; 
            margin: 20px 0; 
        }
        .footer { 
            font-size: 12px; 
            color: #777; 
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>EduCoach Şifre Sıfırlama</h1>
        </div>
        <div class='content'>
            <p>Merhaba {{ $userName }},</p>
            <p>EduCoach hesabınız için şifre sıfırlama talebinde bulundunuz. Şifrenizi sıfırlamak için aşağıdaki butona tıklayabilirsiniz:</p>
            <p style='text-align: center;'>
                <a href='{{ $resetLink }}' class='button'>Şifremi Sıfırla</a>
            </p>
            <p>Veya aşağıdaki bağlantıyı tarayıcınıza kopyalayabilirsiniz:</p>
            <p>{{ $resetLink }}</p>
            <p>Bu bağlantı 1 saat boyunca geçerli olacaktır.</p>
            <p>Eğer şifre sıfırlama talebinde bulunmadıysanız, bu e-postayı görmezden gelebilirsiniz.</p>
        </div>
        <div class='footer'>
            <p>Saygılarımızla,<br>EduCoach Ekibi</p>
        </div>
    </div>
</body>
</html> 