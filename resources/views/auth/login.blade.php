<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Stok Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af, #1d4ed8);
            border-radius: 20px 20px 0 0;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header i {
            font-size: 3rem;
            color: #3b82f6;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .header h2 {
            color: #1e40af;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .form-control:focus + i {
            color: #3b82f6;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-top: 15px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .error-message i {
            margin-right: 8px;
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
        }

        .footer-links a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #1d4ed8;
        }

        .loading {
            display: none;
            text-align: center;
            color: #3b82f6;
            margin-top: 10px;
        }

        .loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 30px 25px;
                margin: 10px;
            }

            .header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header">
            <i class="fas fa-sign-in-alt"></i>
            <h2>Masuk</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" class="form-control" id="username" required>
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-control" id="password" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                Masuk
            </button>
        </form>

        <div class="loading">
            <i class="fas fa-spinner"></i>
            <span>Memproses...</span>
        </div>

        <div id="loginError" class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span id="errorText"></span>
        </div>

        <div class="footer-links">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            <p><a href="{{ route('home') }}">← Kembali ke beranda</a></p>
        </div>
    </div>

    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            
            const username = $('#username').val().trim();
            const password = $('#password').val().trim();
            
            if (!username || !password) {
                showError('Username dan password harus diisi');
                return;
            }

            $('.loading').show();
            $('.btn-primary').prop('disabled', true);
            hideError();

            $.ajax({
                url: '/api/login',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    username: username,
                    password: password
                }),
                success: function(response) {
                    localStorage.setItem('token', response.token);
                    localStorage.setItem('role', response.user.role);
                    const role = response.user.role;
                    if (role === 'admin') {
                        window.location.href = '/dashboard';
                    } else {
                        window.location.href = '/dashboard';
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Login gagal. Silakan coba lagi.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 401) {
                        errorMessage = 'Username atau password salah';
                    } else if (xhr.status === 422) {
                        errorMessage = 'Data yang dimasukkan tidak valid';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Koneksi terputus. Periksa koneksi internet Anda.';
                    }
                    
                    showError(errorMessage);
                },
                complete: function() {
                    $('.loading').hide();
                    $('.btn-primary').prop('disabled', false);
                }
            });
        });

        function showError(message) {
            $('#errorText').text(message);
            $('#loginError').show();
        }

        function hideError() {
            $('#loginError').hide();
        }

        $(document).on('click', function() {
            hideError();
        });
    </script>
</body>
</html>