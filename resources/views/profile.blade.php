@extends('layouts.app')

@section('content')
<div id="profile-content">
    <div class="profile-header">
        <div class="profile-header-content">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1 class="profile-title">Profile User</h1>
                <p class="profile-subtitle">Kelola informasi akun Anda</p>
            </div>
        </div>
    </div>

    <div class="profile-sections">
        <div class="profile-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Informasi Akun
                </h3>
            </div>
            <div class="card-content">
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Username</label>
                        <div class="info-value" id="username-display">-</div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Role</label>
                        <div class="info-value" id="role-display">-</div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Status</label>
                        <div class="info-value">
                            <span class="status-badge active">
                                <i class="fas fa-check-circle"></i>
                                Aktif
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Bergabung Sejak</label>
                        <div class="info-value" id="joined-date">-</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="profile-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-key"></i>
                    Keamanan
                </h3>
            </div>
            <div class="card-content">
                <div class="security-options">
                    <div class="security-item">
                        <div class="security-info">
                            <h4>Ubah Password</h4>
                            <p>Perbarui password untuk keamanan akun yang lebih baik</p>
                        </div>
                        <button class="btn btn-outline" onclick="openChangePasswordModal()">
                            <i class="fas fa-edit"></i>
                            Ubah
                        </button>
                    </div>
                    
                </div>
            </div>
        </div> --}}

        <div class="profile-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    Statistik Aktivitas
                </h3>
            </div>
            <div class="card-content">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="totalProduk">0</div>
                            <div class="stat-label">Total Produk</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="produkDitambah">0</div>
                            <div class="stat-label">Produk Ditambah</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="produkDiubah">0</div>
                            <div class="stat-label">Produk Diupdate</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number" id="loginTerakhir">-</div>
                            <div class="stat-label">Login Terakhir</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fas fa-key"></i>
                Ubah Password
            </h3>
            <button class="modal-close" onclick="closeChangePasswordModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="changePasswordForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="current-password">Password Saat Ini</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="current-password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new-password">Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="new-password" required>
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="confirm-password" required>
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeChangePasswordModal()">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Aktivitas Login -->
<div id="loginActivityModal" class="modal">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>
                <i class="fas fa-history"></i>
                Aktivitas Login
            </h3>
            <button class="modal-close" onclick="closeLoginActivityModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="activity-list" id="loginActivityList">
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-title">Login Berhasil</div>
                        <div class="activity-meta">Hari ini, 14:30 | IP: 192.168.1.1</div>
                    </div>
                    <div class="activity-status success">Berhasil</div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-title">Login Berhasil</div>
                        <div class="activity-meta">Kemarin, 09:15 | IP: 192.168.1.1</div>
                    </div>
                    <div class="activity-status success">Berhasil</div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-title">Login Gagal</div>
                        <div class="activity-meta">2 hari lalu, 16:45 | IP: 192.168.1.2</div>
                    </div>
                    <div class="activity-status failed">Gagal</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#profile-content {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.profile-header-content {
    display: flex;
    align-items: center;
    gap: 30px;
    position: relative;
    z-index: 1;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.profile-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 5px 0 0 0;
}

.profile-sections {
    display: grid;
    gap: 30px;
}

.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-header {
    padding: 25px 30px 20px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.card-title {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-content {
    padding: 30px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1.1rem;
    color: #1e293b;
    font-weight: 500;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.security-options {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.security-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.security-info h4 {
    margin: 0 0 5px 0;
    color: #1e293b;
    font-weight: 600;
}

.security-info p {
    margin: 0;
    color: #64748b;
    font-size: 0.95rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
}

.stat-label {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 500;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-outline {
    background: white;
    border: 2px solid #3b82f6;
    color: #3b82f6;
}

.btn-outline:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: #64748b;
    color: white;
}

.btn-secondary:hover {
    background: #475569;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1000;
    animation: fadeIn 0.3s ease;
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-content.large {
    max-width: 700px;
}

.modal-header {
    padding: 20px 25px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #64748b;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
}

.modal-close:hover {
    background: #f1f5f9;
    color: #1e293b;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
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
    padding: 12px 15px 12px 45px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.activity-icon.success {
    background: #22c55e;
}

.activity-icon.warning {
    background: #f59e0b;
}

.activity-info {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 3px;
}

.activity-meta {
    font-size: 0.85rem;
    color: #64748b;
}

.activity-status {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
}

.activity-status.success {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.activity-status.failed {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@media (max-width: 768px) {
    #profile-content {
        padding: 15px;
    }
    
    .profile-header {
        padding: 25px 20px;
    }
    
    .profile-header-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .profile-title {
        font-size: 2rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .security-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
$(document).ready(function() {
    loadUserProfile();
    loadUserStats();
    getStockData();
});


function getStockData() {
    const token = localStorage.getItem('token');
    $.ajax({
        url: '/api/dashboard-stats',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(data) {
            $('#totalProduk').text(data.total_produk);
            $('#produkDitambah').text(data.produk_ditambah);
            $('#produkDiubah').text(data.produk_diubah);
            $('#loginTerakhir').text(data.login_terakhir ? 
                `${data.login_terakhir.login_at}` : '-'
            );
        }
    });

}

function loadUserProfile() {
    const token = localStorage.getItem('token');
    
    if (!token) {
        window.location.href = '/login';
        return;
    }
    
    $.ajax({
        url: '/api/user/profile',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            $('#username-display').text(response.user.username);
            $('#role-display').text(response.user.role.charAt(0).toUpperCase() + response.user.role.slice(1));
            
            if (response.user.created_at) {
                const joinDate = new Date(response.user.created_at).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                $('#joined-date').text(joinDate);
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('token');
                localStorage.removeItem('role');
                window.location.href = '/login';
            }
        }
    });
}

function loadUserStats() {
    const token = localStorage.getItem('token');
    
    $.ajax({
        url: '/api/user/stats',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            $('#total-products').text(response.stats.total_products || 0);
            $('#products-added').text(response.stats.products_added || 0);
            $('#products-updated').text(response.stats.products_updated || 0);
            
            if (response.stats.last_login) {
                const lastLogin = new Date(response.stats.last_login).toLocaleDateString('id-ID');
                $('#last-login').text(lastLogin);
            }
        },
        error: function(xhr) {
            console.log('Stats tidak dapat dimuat:', xhr.responseText);
        }
    });
}

function openChangePasswordModal() {
    $('#changePasswordModal').fadeIn(300);
}

function closeChangePasswordModal() {
    $('#changePasswordModal').fadeOut(300);
    $('#changePasswordForm')[0].reset();
}

function closeLoginActivityModal() {
    $('#loginActivityModal').fadeOut(300);
}

function loadLoginActivity() {
    const token = localStorage.getItem('token');
    
    $.ajax({
        url: '/api/user/login-activity',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            let activityHtml = '';
            
            if (response.activities && response.activities.length > 0) {
                response.activities.forEach(function(activity) {
                    const date = new Date(activity.created_at).toLocaleDateString('id-ID');
                    const time = new Date(activity.created_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    const iconClass = activity.status === 'success' ? 'success' : 'warning';
                    const icon = activity.status === 'success' ? 'fas fa-check' : 'fas fa-exclamation';
                    const statusClass = activity.status === 'success' ? 'success' : 'failed';
                    const statusText = activity.status === 'success' ? 'Berhasil' : 'Gagal';
                    
                    activityHtml += `
                        <div class="activity-item">
                            <div class="activity-icon ${iconClass}">
                                <i class="${icon}"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">Login ${statusText}</div>
                                <div class="activity-meta">${date}, ${time} | IP: ${activity.ip_address || '-'}</div>
                            </div>
                            <div class="activity-status ${statusClass}">${statusText}</div>
                        </div>
                    `;
                });
            } else {
                activityHtml = '<p style="text-align: center; color: #64748b;">Tidak ada aktivitas login yang tercatat.</p>';
            }
            
            $('#loginActivityList').html(activityHtml);
        },
        error: function(xhr) {
            $('#loginActivityList').html('<p style="text-align: center; color: #dc2626;">Gagal memuat aktivitas login.</p>');
        }
    });
}


$(document).click(function(e) {
    if ($(e.target).hasClass('modal')) {
        $(e.target).fadeOut(300);
    }
});
</script>
@endsection