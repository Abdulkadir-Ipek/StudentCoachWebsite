<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama - EduCoach</title>
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
        
        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .form-title {
            font-size: 24px;
            color: #6C4AB6;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-description {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #6C4AB6;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #6C4AB6;
        }
        
        .btn-submit {
            width: 100%;
            background-color: #6C4AB6;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            background-color: #553692;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: #6C4AB6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
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
    
    <div class="form-container">
        <h2 class="form-title">Şifre Sıfırlama</h2>
        <p class="form-description">Lütfen yeni şifrenizi belirleyin.</p>
        
        <?php if (isset($errors) && $errors->any()): ?>
            <div class="alert">
                <ul>
                    <?php foreach ($errors->all() as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="/reset-password" method="POST">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            
            <div class="form-group">
                <label for="password" class="form-label">Yeni Şifre</label>
                <input type="password" id="password" name="password" class="form-input" required minlength="8">
                <?php if (isset($errors) && $errors->has('password')): ?>
                    <div class="error-message"><?php echo $errors->first('password'); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Şifreyi Onaylayın</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required minlength="8">
            </div>
            
            <button type="submit" class="btn-submit">Şifreyi Sıfırla</button>
        </form>
        
        <div class="login-link">
            <p>Şifrenizi hatırladınız mı? <a href="/login">Giriş Yap</a></p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const passwordInput = document.getElementById('password');
                const confirmInput = document.getElementById('password_confirmation');
                
                let isValid = true;
                
                if (!passwordInput.value) {
                    showError(passwordInput, 'Lütfen yeni şifrenizi girin');
                    isValid = false;
                } else if (passwordInput.value.length < 8) {
                    showError(passwordInput, 'Şifreniz en az 8 karakter olmalıdır');
                    isValid = false;
                }
                
                if (passwordInput.value !== confirmInput.value) {
                    showError(confirmInput, 'Şifreler eşleşmiyor');
                    isValid = false;
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
            
            function showError(input, message) {
                const formGroup = input.parentElement;
                let errorDiv = formGroup.querySelector('.error-message');
                
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    formGroup.appendChild(errorDiv);
                }
                
                errorDiv.textContent = message;
                input.style.borderColor = '#d9534f';
            }
            
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.style.borderColor = '';
                    const errorDiv = this.parentElement.querySelector('.error-message');
                    if (errorDiv) {
                        errorDiv.textContent = '';
                    }
                });
            });
        });
    </script>
</body>
</html> 