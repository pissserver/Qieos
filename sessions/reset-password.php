<?php
    session_start();
    include '../script/connection.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset Password - Qieos</title>
        
        <?php include '../script/headscript.php'; ?>
        
        <link rel="stylesheet" href="../assets/css/auth-premium.css">
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
                <!-- Back Link -->
                <a href="sign-in.php" class="auth-back-link">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Kembali ke login
                </a>

                <!-- Logo -->
                <img src="../assets/img/brand/qieos.png" 
                     alt="Qieos Logo" 
                     width="240" 
                     class="auth-logo">
                
                <!-- Title -->
                <div class="auth-title-wrap">
                    <h1 class="auth-title">Reset Password</h1>
                    <p class="auth-subtitle">Buat password baru untuk akun Anda</p>
                    <div class="auth-title-underline"></div>
                </div>

                <!-- Error Messages -->
                <?php
                    if(isset($_GET['error'])){
                        if($_GET['error'] == "empty"){
                            echo '<div class="auth-alert auth-alert-danger">Semua field harus diisi.</div>';
                        }
                        if($_GET['error'] == "password"){
                            echo '<div class="auth-alert auth-alert-danger">Password dan konfirmasi tidak sama.</div>';
                        }
                    }
                ?>

                <form action="reset-password-action.php" method="POST" class="auth-form">
                    <!-- Username Field (Read-only) -->
                    <div class="auth-form-group">
                        <label for="username" class="auth-label">Username</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   class="auth-input auth-input-with-icon" 
                                   id="username" 
                                   value="<?php echo isset($_SESSION['reset_username']) ? $_SESSION['reset_username'] : ''; ?>" 
                                   disabled
                                   style="opacity: 0.7; cursor: not-allowed;">
                            <input type="hidden" name="username" value="<?php echo isset($_SESSION['reset_username']) ? $_SESSION['reset_username'] : ''; ?>">
                        </div>
                    </div>

                    <!-- New Password Field -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Password Baru</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   placeholder="Masukkan password baru" 
                                   class="auth-input auth-input-with-icon" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <button type="button" class="auth-password-toggle" id="togglePassword1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <!-- Password strength indicator -->
                        <div class="password-strength">
                            <div class="password-strength-fill" id="strengthFill"></div>
                        </div>
                        <p class="small text-muted mt-1">Minimal 8 karakter dengan huruf, angka, dan simbol</p>
                    </div>

                    <!-- Confirm New Password Field -->
                    <div class="auth-form-group">
                        <label for="confirm_password" class="auth-label">Konfirmasi Password Baru</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   placeholder="Ulangi password baru" 
                                   class="auth-input auth-input-with-icon" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   required>
                            <button type="button" class="auth-password-toggle" id="togglePassword2">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary">
                        Reset Password
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    <p class="auth-footer-text">
                        Password berhasil diingat? 
                        <a href="sign-in.php" class="auth-link">Login</a>
                    </p>
                </div>
            </div>
        </main>

        <?php include '../script/footscript.php'; ?>

        <script>
            // Password toggle functionality
            const togglePassword1 = document.getElementById('togglePassword1');
            const togglePassword2 = document.getElementById('togglePassword2');
            const password1 = document.getElementById('password');
            const password2 = document.getElementById('confirm_password');
            
            if(togglePassword1 && password1) {
                togglePassword1.addEventListener('click', function() {
                    const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
                    password1.setAttribute('type', type);
                    toggleIcon(this, type);
                });
            }
            
            if(togglePassword2 && password2) {
                togglePassword2.addEventListener('click', function() {
                    const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
                    password2.setAttribute('type', type);
                    toggleIcon(this, type);
                });
            }
            
            function toggleIcon(element, type) {
                const icon = element.querySelector('i');
                if(type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
                element.style.transform = 'translateY(-50%) scale(1.3)';
                setTimeout(() => {
                    element.style.transform = 'translateY(-50%) scale(1)';
                }, 200);
            }
            
            // Password strength indicator
            if(password1) {
                password1.addEventListener('input', function() {
                    const value = this.value;
                    const strengthFill = document.getElementById('strengthFill');
                    
                    let strength = 0;
                    if(value.length >= 8) strength++;
                    if(/[A-Z]/.test(value)) strength++;
                    if(/[a-z]/.test(value)) strength++;
                    if(/[0-9]/.test(value)) strength++;
                    if(/[^A-Za-z0-9]/.test(value)) strength++;
                    
                    let width = '0%';
                    let color = '#ef4444';
                    
                    switch(strength) {
                        case 0: width = '0%'; color = '#ef4444'; break;
                        case 1: width = '25%'; color = '#ef4444'; break;
                        case 2: width = '50%'; color = '#f59e0b'; break;
                        case 3: width = '75%'; color = '#fbbf24'; break;
                        case 4: width = '85%'; color = '#fbbf24'; break;
                        case 5: width = '100%'; color = '#10b981'; break;
                    }
                    
                    strengthFill.style.width = width;
                    strengthFill.style.background = color;
                });
            }
            
            // Password match validation
            if(password2) {
                password2.addEventListener('input', function() {
                    if(this.value !== '' && this.value !== password1.value) {
                        this.style.borderColor = '#ef4444';
                    } else if(this.value === password1.value && this.value !== '') {
                        this.style.borderColor = '#10b981';
                    } else {
                        this.style.borderColor = '#e5e7eb';
                    }
                });
            }
            
            // Form submit animation
            document.querySelector('.auth-form').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.auth-btn');
                submitBtn.classList.add('auth-btn-loading');
                submitBtn.innerHTML = '<span class="auth-loading-dots"><span></span><span></span><span></span></span>';
            });
            
            // Card hover effects
            document.querySelector('.auth-card').addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            document.querySelector('.auth-card').addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        </script>
    </body>
</html>
