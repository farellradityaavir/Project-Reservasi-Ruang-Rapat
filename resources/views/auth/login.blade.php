<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RuangRapat</title>

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

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
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

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .login-logo-icon {
            width: 48px;
            height: 48px;
            color: white;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--neutral-500);
            font-size: 0.875rem;
        }

        .login-form {
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

        .login-demo {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--neutral-200);
            text-align: center;
        }

        .login-demo-text {
            color: var(--neutral-500);
            font-size: 0.75rem;
            line-height: 1.4;
        }

        .login-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--neutral-200);
            text-align: center;
        }

        .login-footer p {
            color: var(--neutral-500);
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="h-full">
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <div class="login-logo-icon">
                        <img src="/assets/img/kazeee.jpg" alt="Logo RuangRapat" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover;">
                    </div>
                    <div>
                        <h1 class="login-title">RuangRapat</h1>
                        <p class="login-subtitle">Sistem Reservasi Ruang Rapat</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope mr-2" style="margin-right: 10px;"></i>Alamat Email
                    </label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="masukkan email anda"
                           required 
                           autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock mr-2" style="margin-right: 10px;"></i>Password
                    </label>
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           placeholder="masukkan password anda"
                           required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Demo Info 
            <div class="login-demo">
                <p class="login-demo-text">
                    <strong>Demo Access:</strong><br>
                    Admin: admin@office.com / password123<br>
                    User: user@office.com / password123
            </p>
          </div> -->


          {{-- Tambahkan bagian ini sebelum login-footer --}}
        <div class="login-register" style="margin-top: 1.5rem; text-align: center;">
            <p style="color: var(--neutral-500); font-size: 0.875rem;">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="color: var(--primary-red); text-decoration: none; font-weight: 500;">
                    Daftar di sini
                </a>
            </p>
        </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>
                    &copy; {{ date('Y') }} RuangRapat. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>