@extends('layouts.app')

@section('content')
<div id="dashboard-content">
    <div class="welcome-section">
        <div class="welcome-header">
            <i class="fas fa-home welcome-icon"></i>
            <div class="welcome-text">
                <h1 class="welcome-title">Selamat Datang di Dashboard</h1>
                <p class="welcome-subtitle">Kelola sistem stok barang Anda dengan mudah</p>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="total-barang">0</h3>
                <p class="stat-label">Total Barang</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="transaksi-hari-ini">0</h3>
                <p class="stat-label">Transaksi Hari Ini</p>
            </div>
        </div>

        <div class="stat-card admin-only" style="display: none;">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="total-users">0</h3>
                <p class="stat-label">Total Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="stok-menipis">0</h3>
                <p class="stat-label">Stok Menipis</p>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h2 class="section-title">
            <i class="fas fa-bolt"></i>
            Aksi Cepat
        </h2>
        
        <div class="action-grid">
            <a href="{{ route('barang') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="action-content">
                    <h4>Tambah Barang</h4>
                    <p>Tambahkan barang baru ke inventori</p>
                </div>
            </a>

            <a href="{{ route('transaksi') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="action-content">
                    <h4>Catat Transaksi</h4>
                    <p>Kelola transaksi masuk dan keluar</p>
                </div>
            </a>

            {{-- <a href="{{ route('barang') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="action-content">
                    <h4>Cari Barang</h4>
                    <p>Temukan barang dengan cepat</p>
                </div>
            </a> --}}

            <a href="{{ route('admin.users') }}" class="action-card admin-only" style="display: none;">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-content">
                    <h4>Kelola User</h4>
                    <p>Tambah atau edit pengguna sistem</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .welcome-section {
        margin-bottom: 40px;
    }

    .welcome-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 30px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }

    .welcome-icon {
        font-size: 3rem;
        animation: bounce 2s infinite;
        z-index: 1;
    }

    .welcome-text {
        z-index: 1;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 10px 0;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .stat-card:hover::before {
        left: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .stat-content h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: #1e40af;
    }

    .stat-content p {
        margin: 0;
        color: #64748b;
        font-weight: 500;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 25px;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .action-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none;
        color: inherit;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .action-card:hover::before {
        left: 100%;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        color: inherit;
        text-decoration: none;
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .action-content h4 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 8px 0;
        color: #1e40af;
    }

    .action-content p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    @keyframes shimmer {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

    @media (max-width: 768px) {
        .welcome-header {
            flex-direction: column;
            text-align: center;
            padding: 25px 20px;
        }

        .welcome-title {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }

        .stat-card, .action-card {
            padding: 20px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const role = localStorage.getItem('role');
        
        if (role === 'admin') {
            $('.admin-only').show();
        }

        const welcomeTitle = document.querySelector('.welcome-title');
        if (role === 'admin') {
            welcomeTitle.textContent = 'Selamat Datang Admin di Dashboard';
        } else if (role === 'operator') {
            welcomeTitle.textContent = 'Selamat Datang Operator di Dashboard';
        }

        loadDashboardStats();
    });

    function loadDashboardStats() {
       
        console.log('Loading dashboard statistics...');
        
        const token = localStorage.getItem('token');
        console.log('Token:', token);
        if (!token) window.location.href = '/login';

        $.ajax({
            url: '/api/dashboard/summary',
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + token },
            success: function(res) {
                $('#total-barang').text(res.total_barang);
                $('#transaksi-hari-ini').text(res.transaksi_hari_ini);
                $('#total-users').text(res.total_users);
                $('#stok-menipis').text(res.stok_menipis);
            }
        });

    }
</script>
@endsection