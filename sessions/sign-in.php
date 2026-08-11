<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login - Qieos</title>
        
        <?php include '../script/headscript.php'; ?>
        
        <link rel="stylesheet" href="../assets/css/auth-premium.css">
    </head>

    <body class="auth-container">
        <!-- Ambient floating shapes -->
        <div class="auth-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <main class="auth-card-wrapper">
            <div class="auth-card">
                <!-- Logo -->
                <a href="../index.php">
                    <img src="../assets/img/brand/qieos.png" 
                         alt="Qieos Logo" 
                         class="auth-logo">
                </a>
                
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
                            echo '<div class="auth-alert auth-alert-success"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil membuat akun, silakan login.</div>';
                        } elseif($success == 'reset'){
                            echo '<div class="auth-alert auth-alert-success"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil mereset password, silakan login.</div>';
                        } elseif($success == 'logout'){
                            echo '<div class="auth-alert auth-alert-success"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berhasil logout, login kembali untuk masuk.</div>';
                        }
                    } elseif(isset($_GET['error'])){
                        $error = $_GET['error'];
                        if($error == 'empty'){
                            echo '<div class="auth-alert auth-alert-danger"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Semua field harus diisi.</div>';
                        } elseif($error == 'username'){
                            echo '<div class="auth-alert auth-alert-danger"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Username tidak ditemukan.</div>';
                        } elseif($error == 'password'){
                            echo '<div class="auth-alert auth-alert-danger"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Password salah.</div>';
                        }
                    }
                ?>

                <form action="sign-in-action.php" method="POST" class="auth-form" id="signInForm">
                    <!-- Username Field -->
                    <div class="auth-form-group">
                        <label for="username" class="auth-label">Username</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   placeholder="Masukkan username Anda" 
                                   class="auth-input" 
                                   id="username" 
                                   name="username" 
                                   required
                                   autocomplete="username"
                                   value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-input-group">
                            <div class="auth-input-icon">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   placeholder="Masukkan password Anda" 
                                   class="auth-input" 
                                   id="password" 
                                   name="password" 
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="auth-password-toggle" id="togglePassword" aria-label="Toggle Password Visibility">
                                <svg class="eye-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="auth-form-group" style="margin-bottom: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="auth-checkbox-wrapper" for="remember">
                                <input class="auth-checkbox" type="checkbox" name="remember" id="remember" <?php echo (isset($_COOKIE['username'])) ? 'checked' : ''; ?>>
                                <span>Ingat saya</span>
                            </label>
                            <a href="forgot-password.php" class="auth-link">Lupa password?</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary" id="submitBtn">
                        <span>Login Sekarang</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    <p class="auth-footer-text">
                        Belum punya akun? 
                        <a href="sign-up.php" class="auth-link">Daftar Akun Baru</a>
                    </p>
                </div>
            </div>
        </main>

        <?php include '../script/footscript.php'; ?>

        <!-- Login Success Overlay -->
        <div class="login-success-overlay" id="loginSuccessOverlay">
            <div class="login-success-ripple"></div>
            <div class="login-success-ripple"></div>
            <div class="login-success-ripple"></div>

            <div class="login-success-circle">
                <svg width="44" height="44" viewBox="0 0 48 48">
                    <polyline class="login-success-check" points="14 24 22 32 36 16"></polyline>
                </svg>
            </div>

            <div class="login-welcome-name" id="loginWelcomeName">Selamat Datang!</div>
            <div class="login-welcome-sub" id="loginWelcomeSub">Anda berhasil masuk ke sistem</div>

            <div class="login-loading-dots">
                <span></span><span></span><span></span>
            </div>

            <div class="login-progress-bar"></div>
        </div>

        <!-- Login Failed Overlay -->
        <div class="login-fail-overlay" id="loginFailOverlay">
            <div class="login-fail-ripple"></div>
            <div class="login-fail-ripple"></div>
            <div class="login-fail-ripple"></div>

            <div class="login-fail-circle" id="failCircle">
                <svg width="44" height="44" viewBox="0 0 48 48">
                    <line class="login-fail-x" x1="16" y1="16" x2="32" y2="32"></line>
                    <line class="login-fail-x x2" x1="32" y1="16" x2="16" y2="32"></line>
                </svg>
            </div>

            <div class="login-fail-name" id="failName">Login Gagal!</div>
            <div class="login-fail-sub" id="failSub">Username atau password salah</div>

            <div class="login-fail-dismiss" id="failDismiss">Menutup dalam 3 detik...</div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Background floating particles
                const container = document.querySelector('.auth-container');
                for(let i = 0; i < 15; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDelay = (Math.random() * 8) + 's';
                    particle.style.animationDuration = (6 + Math.random() * 6) + 's';
                    container.appendChild(particle);
                }

                // Toggle Password
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('password');
                
                if (togglePassword && passwordInput) {
                    togglePassword.addEventListener('click', function() {
                        const isPassword = passwordInput.getAttribute('type') === 'password';
                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                        
                        this.innerHTML = isPassword 
                            ? `<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 013.682-.763c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.092-4.092a3 3 0 11-4.243-4.243m4.242 4.242L3 3l18 18"></path></svg>`
                            : `<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
                    });
                }

                // ===== LOGIN SUBMIT VIA AJAX =====
                var form = document.getElementById('signInForm');
                var submitBtn = document.getElementById('submitBtn');
                var overlay = document.getElementById('loginSuccessOverlay');
                var failOverlay = document.getElementById('loginFailOverlay');
                var cardWrapper = document.querySelector('.auth-card-wrapper');
                var welcomeName = document.getElementById('loginWelcomeName');
                var welcomeSub = document.getElementById('loginWelcomeSub');
                var failName = document.getElementById('failName');
                var failSub = document.getElementById('failSub');
                var failDismiss = document.getElementById('failDismiss');
                
                if (form && submitBtn) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        var username = document.getElementById('username').value || '';
                        var password = document.getElementById('password').value || '';

                        // Button loading
                        submitBtn.classList.add('auth-btn-loading');
                        submitBtn.innerHTML = '<div class="auth-loading-spinner"></div><span>Memproses...</span>';
                        submitBtn.disabled = true;

                        // AJAX check credentials
                        var fd = new FormData();
                        fd.append('username', username);
                        fd.append('password', password);
                        fd.append('remember', document.getElementById('remember').checked ? '1' : '');

                        fetch('sign-in-action.php', {
                            method: 'POST',
                            body: fd,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(function(r) { return r.json(); })
                        .then(function(res) {
                            if (res.status === 'success') {
                                // SUCCESS — tampilkan animasi sukses lalu redirect
                                var displayName = res.fullname || username;
                                if (welcomeName) welcomeName.textContent = 'Selamat Datang, ' + displayName + '!';
                                if (welcomeSub) welcomeSub.textContent = 'Anda berhasil masuk ke sistem';
                                if (cardWrapper) cardWrapper.classList.add('login-exit');
                                setTimeout(function() { overlay.classList.add('active'); }, 200);
                                setTimeout(function() { window.location.href = res.redirect; }, 3200);
                            } else {
                                // FAIL — tampilkan animasi gagal langsung
                                resetBtn();
                                if (failName) failName.textContent = res.message || 'Login Gagal!';
                                if (failSub) {
                                    if (res.error === 'username') failSub.textContent = 'Akun dengan username tersebut tidak terdaftar';
                                    else if (res.error === 'password') failSub.textContent = 'Password yang dimasukkan tidak sesuai';
                                    else if (res.error === 'empty') failSub.textContent = 'Username dan password harus diisi';
                                    else failSub.textContent = 'Terjadi kesalahan, coba lagi';
                                }

                                // Shake card + show fail overlay
                                if (cardWrapper) cardWrapper.style.animation = 'failShake .6s ease';
                                setTimeout(function() { failOverlay.classList.add('active'); }, 400);

                                // Auto dismiss 3 detik
                                var cd = 3;
                                var ci = setInterval(function() {
                                    cd--;
                                    if (failDismiss) failDismiss.textContent = 'Menutup dalam ' + cd + ' detik...';
                                    if (cd <= 0) {
                                        clearInterval(ci);
                                        failOverlay.classList.remove('active');
                                        if (cardWrapper) cardWrapper.style.animation = '';
                                    }
                                }, 1000);
                            }
                        })
                        .catch(function() {
                            resetBtn();
                            // Fallback: submit form normally
                            form.submit();
                        });
                    });
                }

                function resetBtn() {
                    submitBtn.classList.remove('auth-btn-loading');
                    submitBtn.innerHTML = '<span>Login Sekarang</span><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
                    submitBtn.disabled = false;
                }
            });
        </script>
    </body>
</html>
