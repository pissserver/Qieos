<?php 
    include '../script/connection.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lupa Password - Qieos</title>
        
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
                    <h1 class="auth-title">Lupa Password?</h1>
                    <p class="auth-subtitle">Jangan khawatir, kami akan bantu Anda</p>
                    <div class="auth-title-underline"></div>
                </div>

                <!-- Info Card -->
                <div style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; border-left: 4px solid #0284c7; animation: alertSlideIn 0.5s ease-out;">
                    <div style="display: flex; gap: 0.75rem; align-items: start;">
                        <svg style="width: 1.5rem; height: 1.5rem; color: #0284c7; flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p style="margin: 0; color: #075985; font-size: 0.9rem; line-height: 1.5;">
                                Masukkan username Anda dan kami akan mengarahkan Anda ke halaman untuk membuat password baru.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                <?php
                    if(isset($_GET['error'])){
                        $error = $_GET['error'];
                        if($error == 'invalid'){
                            echo '<div class="auth-alert auth-alert-danger">Username tidak ditemukan di sistem kami.</div>';
                        }
                    }
                ?>

                <form action="forgot-password-action.php" method="POST" class="auth-form">
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
                                   placeholder="Masukkan username Anda" 
                                   class="auth-input auth-input-with-icon" 
                                   id="username" 
                                   name="username" 
                                   required
                                   autofocus>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary">
                        <svg style="width: 1.25rem; height: 1.25rem; display: inline-block; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Reset Password
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    <p class="auth-footer-text">
                        Ingat password Anda? 
                        <a href="sign-in.php" class="auth-link">Login sekarang</a>
                    </p>
                </div>
            </div>
        </main>

        <?php include '../script/footscript.php'; ?>

        <script>
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
            
            // Input focus animation
            const usernameInput = document.getElementById('username');
            if(usernameInput) {
                usernameInput.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                usernameInput.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
                
                // Shake animation on empty submit
                document.querySelector('.auth-form').addEventListener('submit', function(e) {
                    if(usernameInput.value.trim() === '') {
                        e.preventDefault();
                        usernameInput.parentElement.style.animation = 'shake 0.5s';
                        setTimeout(() => {
                            usernameInput.parentElement.style.animation = '';
                        }, 500);
                    }
                });
            }
            
            // Add shake animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
                    20%, 40%, 60%, 80% { transform: translateX(10px); }
                }
                
                .auth-input-group {
                    transition: transform 0.3s ease;
                }
            `;
            document.head.appendChild(style);
        </script>
    </body>
</html>
