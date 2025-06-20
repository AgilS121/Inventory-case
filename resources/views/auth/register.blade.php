<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dashboard Stok Barang</title>
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

        .register-container {
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

        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 20px 20px 0 0;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header i {
            font-size: 3rem;
            color: #10b981;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .header h2 {
            color: #059669;
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
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            transform: translateY(-2px);
        }

        .form-control:focus + i {
            color: #10b981;
        }

        .form-control:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        .role-info {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #059669;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .role-info i {
            margin-right: 8px;
            color: #10b981;
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

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        .error-message, .success-message {
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-top: 15px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #059669;
        }

        .error-message i, .success-message i {
            margin-right: 8px;
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
        }

        .footer-links a {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #059669;
        }

        .loading {
            display: none;
            text-align: center;
            color: #10b981;
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
            .register-container {
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
    <div class="register-container">
        <div class="header">
            <i class="fas fa-user-plus"></i>
            <h2>Daftar</h2>
            <p>Buat akun baru untuk mengakses sistem</p>
        </div>

        <form id="registerForm">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrapper">
                    <input type="text" class="form-control" id="name" required>
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" class="form-control" id="username" required>
                    <i class="fas fa-at"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-control" id="password" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <div class="input-wrapper">
                    <input type="text" class="form-control" id="role" value="Operator" disabled>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="role-info">
                    <i class="fas fa-info-circle"></i>
                    Akun baru akan terdaftar sebagai Operator secara otomatis
                </div>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                Daftar
            </button>
        </form>

        <div class="loading">
            <i class="fas fa-spinner"></i>
            <span>Memproses pendaftaran...</span>
        </div>

        <div id="registerError" class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span id="errorText"></span>
        </div>

        <div id="registerSuccess" class="success-message">
            <i class="fas fa-check-circle"></i>
            <span id="successText"></span>
        </div>

        <div class="footer-links">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            <p><a href="{{ route('home') }}">← Kembali ke beranda</a></p>
        </div>
    </div>

    <script>
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            
            const name = $('#name').val().trim();
            const username = $('#username').val().trim();
            const password = $('#password').val().trim();
            const role = 'operator';
            
            if (!name || !username || !password) {
                showError('Semua field harus diisi');
                return;
            }

            if (name.length < 2) {
                showError('Nama harus minimal 2 karakter');
                return;
            }

            if (username.length < 3) {
                showError('Username harus minimal 3 karakter');
                return;
            }

            if (password.length < 6) {
                showError('Password harus minimal 6 karakter');
                return;
            }

            $('.loading').show();
            $('.btn-success').prop('disabled', true);
            hideMessages();

            $.ajax({
                url: '/api/register',
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    name: name,
                    username: username,
                    password: password,
                    role: role
                }),
                success: function(response) {
                    showSuccess('Registrasi berhasil! Anda akan dialihkan ke halaman login...');
                    
                    $('#registerForm')[0].reset();
                    
                    setTimeout(function() {
                        window.location.href = '/login';
                    }, 2000);
                },
                error: function(xhr) {
                    let errorMessage = 'Registrasi gagal. Silakan coba lagi.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const firstError = Object.values(errors)[0];
                        if (Array.isArray(firstError)) {
                            errorMessage = firstError[0];
                        } else {
                            errorMessage = firstError;
                        }
                    } else if (xhr.status === 422) {
                        errorMessage = 'Data yang dimasukkan tidak valid';
                    } else if (xhr.status === 409) {
                        errorMessage = 'Username sudah digunakan';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Koneksi terputus. Periksa koneksi internet Anda.';
                    }
                    
                    showError(errorMessage);
                },
                complete: function() {
                    $('.loading').hide();
                    $('.btn-success').prop('disabled', false);
                }
            });
        });

        function showError(message) {
            $('#errorText').text(message);
            $('#registerError').show();
            $('#registerSuccess').hide();
        }

        function showSuccess(message) {
            $('#successText').text(message);
            $('#registerSuccess').show();
            $('#registerError').hide();
        }

        function hideMessages() {
            $('#registerError').hide();
            $('#registerSuccess').hide();
        }

        $(document).on('click', function() {
            hideMessages();
        });

        $('#username').on('input', function() {
            let value = $(this).val();
            value = value.replace(/[^a-zA-Z0-9_]/g, ''); 
            $(this).val(value);
        });

        $('#name').on('input', function() {
            let value = $(this).val();
            value = value.replace(/[^a-zA-Z\s]/g, '');
            $(this).val(value);
        });
    </script>
</body>
</html>