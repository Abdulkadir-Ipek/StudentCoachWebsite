<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-posta Doğrulama - EduCoach</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f8ff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            padding: 40px 0 20px;
            position: relative;
            z-index: 1;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .brand-name {
            font-size: 32px;
            color: #6C4AB6;
            font-weight: 700;
        }
        
        .form-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 40px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .form-title {
            font-size: 24px;
            color: #6C4AB6;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .instructions {
            margin-bottom: 25px;
            color: #4a4a4a;
            line-height: 1.6;
        }
        
        .btn-primary {
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
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            background-color: #553692;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #6C4AB6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link a:hover {
            text-decoration: underline;
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
        <h2 class="form-title">E-posta Doğrulama</h2>
        
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
        
        <?php if (session('resent')): ?>
            <div class="alert alert-success">
                Doğrulama bağlantısı e-posta adresinize gönderildi.
            </div>
        <?php endif; ?>
        
        <div class="instructions">
            <p>Hesabınıza devam edebilmek için, lütfen e-posta adresinize gönderilen doğrulama bağlantısına tıklayın.</p>
            <p>E-postayı almadıysanız, aşağıdaki formu kullanarak yeni bir doğrulama bağlantısı isteyebilirsiniz.</p>
        </div>
        
        <form action="<?php echo route('verification.send'); ?>" method="POST">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            
            <div class="form-group">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" id="email" name="email" class="form-input" required>
                <?php if (isset($errors) && $errors->has('email')): ?>
                    <div class="error-message"><?php echo $errors->first('email'); ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn-primary">Doğrulama Bağlantısını Yeniden Gönder</button>
        </form>
        
        <div class="back-link">
            <p><a href="<?php echo route('login'); ?>">Giriş sayfasına dön</a></p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
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
                        },
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
                        "opacity": 0.4,
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
                                "opacity": 1
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
            
            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const emailInput = document.getElementById('email');
                
                let isValid = true;
                
                if (!emailInput.value.trim()) {
                    showError(emailInput, 'Lütfen e-posta adresinizi girin');
                    isValid = false;
                } else if (!isValidEmail(emailInput.value)) {
                    showError(emailInput, 'Geçerli bir e-posta adresi girin');
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
        });
    </script>
</body>
</html> 