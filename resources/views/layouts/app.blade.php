<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Stok Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #3b82f6, #1e40af, #1d4ed8);
        }

        .sidebar-header {
            padding: 30px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        .sidebar-header i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            animation: bounce 2s infinite;
        }

        .sidebar-header h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin: 5px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #374151;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .logout-section {
            position: absolute;
            bottom: 20px;
            left: 15px;
            right: 15px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #dc2626;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 2px solid rgba(220, 38, 38, 0.2);
            background: rgba(220, 38, 38, 0.05);
        }

        .logout-btn:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .logout-btn i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            min-height: calc(100vh - 60px);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        .content-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af, #1d4ed8);
            border-radius: 20px 20px 0 0;
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: #3b82f6;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: #3b82f6;
            color: white;
            transform: scale(1.1);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal-dialog {
            z-index: 1070 !important;
        }

        .modal input,
        .modal textarea,
        .modal select {
            position: relative !important;
            z-index: 1071 !important;
            pointer-events: auto !important;
            background-color: #fff !important;
        }

        .modal-content {
            position: relative;
            z-index: 1072 !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: none !important;
        }

        .modal-backdrop.show {
            backdrop-filter: blur(3px) !important;
        }

        .modal .form-control {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            position: relative !important;
            z-index: 1073 !important;
        }

        .modal .form-control:focus {
            background-color: #fff !important;
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
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

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .modal {
                z-index: 1070 !important;
            }
            
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-toggle {
                display: block;
            }

            .overlay.active {
                display: block;
            }

            .content-wrapper {
                padding: 25px;
                margin-top: 60px;
            }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding: 20px;
                border-radius: 15px;
            }

            .sidebar {
                width: 260px;
            }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-boxes"></i>
            <h4>Stok Barang</h4>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link" data-page="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('barang') }}" class="nav-link" data-page="barang">
                    <i class="fas fa-box"></i>
                    Barang
                </a>
            </div>

            <div class="nav-item admin-only" style="display: none;">
                <a href="{{ route('admin.users') }}" class="nav-link" data-page="users">
                    <i class="fas fa-users"></i>
                    Users
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('transaksi') }}" class="nav-link" data-page="transaksi">
                    <i class="fas fa-exchange-alt"></i>
                    Transaksi
                </a>
            </div>

            <div class="nav-item admin-only" style="display: none;">
                <a href="{{ route('admin.transaksi.manage') }}" class="nav-link" data-page="manage">
                    <i class="fas fa-gear"></i>
                    Manage Transaksi
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link" data-page="profile">
                    <i class="fas fa-user"></i>
                    Profile
                </a>
            </div>
        </nav>

        <div class="logout-section">
            <a href="/logout" class="logout-btn" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')

    <script>
        $(document).ready(function() {
            const role = localStorage.getItem('role');
            if (role === 'admin') {
                $('.admin-only').show();
            }

            const currentPage = window.location.pathname.split('/').pop() || 'dashboard';
            $(`.nav-link[data-page="${currentPage}"]`).addClass('active');

            $('#mobileToggle').click(function() {
                $('#sidebar').toggleClass('active');
                $('#overlay').toggleClass('active');
            });

            $('#overlay').click(function() {
                $('#sidebar').removeClass('active');
                $('#overlay').removeClass('active');
            });

            $('.nav-link').click(function() {
                if (window.innerWidth <= 768) {
                    $('#sidebar').removeClass('active');
                    $('#overlay').removeClass('active');
                }
            });

            $('#logoutBtn').click(function(e) {
                e.preventDefault();
                
                if (confirm('Apakah Anda yakin ingin keluar?')) {
                    $.ajax({
                        url: '/api/logout',
                        method: 'POST',
                        headers: { 
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            localStorage.clear();
                            window.location.href = '/login';
                        },
                        error: function() {
                            localStorage.clear();
                            window.location.href = '/login';
                        }
                    });
                }
            });

            $(window).resize(function() {
                if (window.innerWidth > 768) {
                    $('#sidebar').removeClass('active');
                    $('#overlay').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>