<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - EduCoach</title>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
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
            background-color: #f2f3fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
            overflow-x: hidden;
        }
        
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
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
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(108, 74, 182, 0.1);
            backdrop-filter: blur(5px);
            position: relative;
            z-index: 2;
        }
        
        .form-title {
            font-size: 24px;
            color: #6C4AB6;
            margin-bottom: 20px;
            text-align: center;
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
        
        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 5px;
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
    </style>
</head>
<body>
    <div id="particles-js"></div>
    
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
        <h2 class="form-title">Kayıt Ol</h2>
        
        <form action="/register" method="POST">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            
            <div class="form-group">
                <label for="name" class="form-label">Ad</label>
                <input type="text" id="name" name="name" class="form-input" required>
                <?php if (isset($errors) && $errors->has('name')): ?>
                    <div class="error-message"><?php echo $errors->first('name'); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" id="email" name="email" class="form-input" required>
                <?php if (isset($errors) && $errors->has('email')): ?>
                    <div class="error-message"><?php echo $errors->first('email'); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" id="password" name="password" class="form-input" required>
                <?php if (isset($errors) && $errors->has('password')): ?>
                    <div class="error-message"><?php echo $errors->first('password'); ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn-submit">Kayıt Ol</button>
        </form>
        
        <div class="login-link">
            <p>Zaten hesabın var mı? <a href="/login">Giriş Yap</a></p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const nameInput = document.getElementById('name');
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                
                let isValid = true;
                
                if (!nameInput.value.trim()) {
                    showError(nameInput, 'Lütfen adınızı girin');
                    isValid = false;
                }
                
                if (!emailInput.value.trim()) {
                    showError(emailInput, 'Lütfen e-posta adresinizi girin');
                    isValid = false;
                } else if (!isValidEmail(emailInput.value)) {
                    showError(emailInput, 'Geçerli bir e-posta adresi girin');
                    isValid = false;
                }
                
                if (!passwordInput.value) {
                    showError(passwordInput, 'Lütfen şifrenizi girin');
                    isValid = false;
                } else if (passwordInput.value.length < 8) {
                    showError(passwordInput, 'Şifre en az 8 karakter olmalıdır');
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
            
            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
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
                        }
                    },
                    "opacity": {
                        "value": 0.3,
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
                        "random": true,
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
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });
        });
    </script>
</body>
</html> 