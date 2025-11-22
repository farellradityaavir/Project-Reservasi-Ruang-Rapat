<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - MeetingReserve</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #dc2626;
            --primary-red-dark: #b91c1c;
            --primary-red-light: #fef2f2;
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-red-light) 0%, var(--neutral-50) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
        }

        .register-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            padding: 2rem;
            border: 1px solid var(--neutral-200);
            animation: slideInUp 0.5s ease;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .register-logo-icon {
            width: 48px;
            height: 48px;
            color: white;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .register-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
            color: var(--neutral-500);
            font-size: 0.875rem;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--neutral-700);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--neutral-300);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.875rem;
            color: var(--neutral-800);
            background: white;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: var(--neutral-200);
            border-radius: 2px;
            margin-bottom: 0.25rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 0.75rem;
            color: var(--neutral-500);
        }

        .strength-weak .strength-fill {
            background: #ef4444;
            width: 33%;
        }

        .strength-medium .strength-fill {
            background: #f59e0b;
            width: 66%;
        }

        .strength-strong .strength-fill {
            background: #10b981;
            width: 100%;
        }

        .strength-weak .strength-text {
            color: #ef4444;
        }

        .strength-medium .strength-text {
            color: #f59e0b;
        }

        .strength-strong .strength-text {
            color: #10b981;
        }

        .form-hint {
            color: var(--neutral-500);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            line-height: 1;
        }

        .btn-primary {
            background: var(--primary-red);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-red-dark);
            transform: translateY(-1px);
        }

        .btn-lg {
            padding: 1rem 1.5rem;
            font-size: 1rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .register-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--neutral-200);
            text-align: center;
        }

        .register-login {
            color: var(--neutral-600);
            font-size: 0.875rem;
        }

        .register-login a {
            color: var(--primary-red);
            text-decoration: none;
            font-weight: 500;
        }

        .register-login a:hover {
            text-decoration: underline;
        }

        .terms-text {
            color: var(--neutral-500);
            font-size: 0.75rem;
            margin-top: 1rem;
            line-height: 1.4;
        }

        .terms-text a {
            color: var(--primary-red);
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--neutral-400);
            cursor: pointer;
            padding: 0.25rem;
        }

        .password-input {
            position: relative;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 1.5rem;
            }
            
            .register-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="h-full">
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="register-logo">
                    <div class="register-logo-icon">
                        <img src="/assets/img/kazeee.jpg" alt="Logo RuangRapat" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover;">
                    </div>
                    <div>
                        <h1 class="register-title">RuangRapat</h1>
                        <p class="register-subtitle">Buat akun baru untuk mulai reservasi</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}@if(!$loop->last)<br>@endif
                    @endforeach
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="register-form" id="register-form">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-user mr-2"style="margin-right: 10px;"></i>Nama Lengkap *
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Masukkan nama lengkap Anda"
                           required 
                           autofocus>
                    <div class="form-hint">Minimal 3 karakter</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope mr-2"style="margin-right: 10px;"></i>Alamat Email *
                    </label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="contoh@email.com"
                           required>
                    <div class="form-hint">Gunakan email yang valid</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock mr-2"style="margin-right: 10px;"></i>Password *
                    </label>
                    <div class="password-input">
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Buat password yang kuat"
                               required
                               minlength="8">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength Meter -->
                    <div class="password-strength" id="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill"></div>
                        </div>
                        <div class="strength-text">Kekuatan password</div>
                    </div>
                    <div class="form-hint">Minimal 8 karakter dengan kombinasi huruf dan angka</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        <i class="fas fa-lock mr-2"style="margin-right: 10px;"></i>Konfirmasi Password *
                    </label>
                    <div class="password-input">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Ketik ulang password Anda"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Terms and Login -->
            <div class="register-footer">
                <p class="register-login">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}">Masuk di sini</a>
                </p>
                
                <p class="terms-text">
                    Dengan mendaftar, Anda menyetujui 
                    <a href="#">Syarat & Ketentuan</a> dan 
                    <a href="#">Kebijakan Privasi</a> kami.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');
            const strengthFill = passwordStrength.querySelector('.strength-fill');
            const strengthText = passwordStrength.querySelector('.strength-text');
            
            // Password strength checker
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;
                
                // Character variety checks
                if (/[a-z]/.test(password)) strength += 1;
                if (/[A-Z]/.test(password)) strength += 1;
                if (/[0-9]/.test(password)) strength += 1;
                if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
                
                // Update strength meter
                updateStrengthMeter(strength);
            });
            
            function updateStrengthMeter(strength) {
                // Reset classes
                passwordStrength.className = 'password-strength';
                
                if (strength <= 2) {
                    passwordStrength.classList.add('strength-weak');
                    strengthText.textContent = 'Password lemah';
                } else if (strength <= 4) {
                    passwordStrength.classList.add('strength-medium');
                    strengthText.textContent = 'Password cukup';
                } else {
                    passwordStrength.classList.add('strength-strong');
                    strengthText.textContent = 'Password kuat';
                }
            }
            
            // Form validation
            const form = document.getElementById('register-form');
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;
                
                // Name validation
                if (name.length < 3) {
                    e.preventDefault();
                    alert('Nama harus minimal 3 karakter.');
                    return;
                }
                
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Format email tidak valid.');
                    return;
                }
                
                // Password validation
                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password harus minimal 8 karakter.');
                    return;
                }
                
                // Password confirmation
                if (password !== passwordConfirm) {
                    e.preventDefault();
                    alert('Konfirmasi password tidak sesuai.');
                    return;
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftarkan...';
                submitBtn.disabled = true;
                
                // Re-enable after 5 seconds if still on page (form submission failed)
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 5000);
            });
            
            // Real-time password confirmation check
            const passwordConfirmInput = document.getElementById('password_confirmation');
            passwordConfirmInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirm = this.value;
                
                if (confirm && password !== confirm) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '';
                }
            });
        });
        
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const toggle = field.nextElementSibling;
            const icon = toggle.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
        
        // Add focus styles to form inputs
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>