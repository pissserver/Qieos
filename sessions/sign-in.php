<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login - Qieos</title>
        
        <?php include '../script/headscript.php'; ?>
        
        <link rel="stylesheet" href="../assets/css/auth-premium.css">
        
        <style>
            /* Additional custom styles */
            .password-strength {
                margin-top: 0.5rem;
                height: 4px;
                border-radius: 2px;
                background: #e5e7eb;
                overflow: hidden;
                position: relative;
            }
            
            .password-strength-fill {
                height: 100%;
                width: 0%;
                transition: width 0.3s ease;
                background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981);
            }
        </style>
    </head>

    <body class="auth-container">
        <!-- Animated background shapes -->
        <div class="auth-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <!-- Add some floating particles -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                for(let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 4 + 's';
                    document.querySelector('.auth-container').appendChild(particle);
                }
            });
        </script>

        <main class="auth-card-wrapper">
            <div class="auth-card">
                <!-- Logo -->
                <img src="../assets/img/brand/qieos.png" 
                     alt="Qieos Logo" 
                     width="240" 
                     class="auth-logo">
                
                <!-- Title -->
                <div class="auth-title-wrap">
                    <h1 class="auth-title">Selamat Datang</h1>
                    <p class="auth-subtitle">Login ke akun Qieos Anda</p>
                    <div class="auth-title-underline"></div>
                </div>

                <?php
                    // Display success/error messages
                    if(isset($_GET['success'])){
                        $success = $_GET['success'];
                        if($success == 'register'){
                            echo '<div class="auth-alert auth-alert-success">Berhasil membuat akun, silakan login.</div>';
                        } elseif($success == 'reset'){
                            echo '<div class="auth-alert auth-alert-success">Berhasil mereset password, silakan login.</div>';
                        } elseif($success == 'logout'){
                            echo '<div class="auth-alert auth-alert-success">Berhasil logout, login kembali untuk masuk.</div>';
                        }
                    } elseif(isset($_GET['error'])){
                        $error = $_GET['error'];
                        if($error == 'empty'){
                            echo '<div class="auth-alert auth-alert-danger">Semua field harus diisi.</div>';
                        } elseif($error == 'username'){
                            echo '<div class="auth-alert auth-alert-danger">Username tidak ditemukan.</div>';
                        } elseif($error == 'password'){
                            echo '<div class="auth-alert auth-alert-danger">Password salah.</div>';
                        }
                    }
                ?>

                <form action="sign-in-action.php" method="POST" class="auth-form">
                    <!-- Username Field -->
                    <div class="auth-form-group">
                        <label for="username" class="auth-label">Username</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   placeholder="Masukkan username" 
                                   class="auth-input auth-input-with-icon" 
                                   id="username" 
                                   name="username" 
                                   required
                                   value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   placeholder="Masukkan password" 
                                   class="auth-input auth-input-with-icon" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <button type="button" class="auth-password-toggle" id="togglePassword">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="auth-form-group" style="margin-bottom: 2rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="auth-checkbox-wrapper" for="remember">
                                <input class="auth-checkbox" type="checkbox" name="remember" id="remember" <?php echo (isset($_COOKIE['username'])) ? 'checked' : ''; ?>>
                                <span>Ingat saya</span>
                            </label>
                            <a href="forgot-password.php" class="auth-link">Lupa password?</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary">
                        Login
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    <p class="auth-footer-text">
                        Belum terdaftar? 
                        <a href="sign-up.php" class="auth-link">Buat akun</a>
                    </p>
                </div>
            </div>
        </main>

        <?php include '../script/footscript.php'; ?>

        <script>
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            if(togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    // Toggle eye icon
                    const icon = this.querySelector('i');
                    if(type === 'password') {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                    
                    // Add animation effect
                    this.style.transform = 'translateY(-50%) scale(1.3)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-50%) scale(1)';
                    }, 200);
                });
            }
            
            // Input focus effects
            document.querySelectorAll('.auth-input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.classList.remove('focused');
                });
            });
            
            // Form submit animation
            document.querySelector('.auth-form').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.auth-btn');
                submitBtn.classList.add('auth-btn-loading');
                submitBtn.innerHTML = '<span class="auth-loading-dots"><span></span><span></span><span></span></span>';
                
                // Prevent form submission for demo (remove in production)
                // e.preventDefault();
                // setTimeout(() => {
                //     submitBtn.classList.remove('auth-btn-loading');
                //     submitBtn.innerHTML = 'Login';
                //     alert('Login successful! (Demo)');
                // }, 1500);
            });
            
            // Add floating particles on hover
            document.querySelector('.auth-card').addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            document.querySelector('.auth-card').addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        </script>
    </body>
</html>
