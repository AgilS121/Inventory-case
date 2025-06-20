@extends('layouts.app')

@section('content')
<style>
    
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
</style>
<h2>Manajemen Users</h2>

<div class="mb-3">
    <input type="text" id="searchUser" class="form-control" placeholder="Cari Nama atau Username...">
</div>

<button id="btnAdd" class="btn btn-success mb-3">Tambah Operator</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="userTable"></tbody>
</table>

<div id="userModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user"></i> Form User Operator</h3>
            <button class="modal-close" onclick="closeUserModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="userForm">
            <div class="modal-body">
                <input type="hidden" id="userId">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="name" required>
                        <i class="fas fa-user-tag"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="username" required>
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password (kosongkan jika tidak diubah)</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="password">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = '/login';

function loadUsers() {
    $.ajax({
        url: '/api/users',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(users) {
            $('#userTable').empty();
            users.forEach(user => {
                if(user.role === 'operator') {
                    let row = `<tr>
                        <td>${user.name}</td>
                        <td>${user.username}</td>
                        <td>${user.is_active ? 'Aktif' : 'Nonaktif'}</td>
                        <td>
                            <button class="btn btn-warning btnEdit" data-id="${user.id}">Edit</button>
                            ${user.is_active 
                                ? `<button class="btn btn-secondary btnNonAktif" data-id="${user.id}">Nonaktifkan</button>` 
                                : `<button class="btn btn-success btnAktifkan" data-id="${user.id}">Aktifkan</button>
                                   <button class="btn btn-danger btnDelete" data-id="${user.id}">Hapus</button>`}
                        </td>
                    </tr>`;
                    $('#userTable').append(row);
                }
            });
        }
    });
}

function openUserModal() {
    $('#userModal').fadeIn(300);
}

function closeUserModal() {
    $('#userModal').fadeOut(300);
    $('#userForm')[0].reset();
}


$(document).ready(function() {
    loadUsers();

    $('#searchUser').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#userTable tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#btnAdd').click(function() {
        $('#userId').val('');
        $('#userForm')[0].reset();
        openUserModal();
    });

    $('#userForm').submit(function(e) {
        e.preventDefault();
        const id = $('#userId').val();
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/users/${id}` : '/api/users';
        const data = {
            name: $('#name').val(),
            username: $('#username').val(),
            password: $('#password').val()
        };
        $.ajax({
            url: url,
            method: method,
            headers: { Authorization: 'Bearer ' + token },
            data: data,
            success: function() {
                closeUserModal();
                loadUsers();
            },
            error: function(err) {
                alert(err.responseJSON?.message || 'Terjadi kesalahan');
            }
        });
    });

    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/api/users/${id}`,
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token },
            success: function(user) {
                $('#userId').val(user.id);
                $('#name').val(user.name);
                $('#username').val(user.username);
                $('#password').val('');
                openUserModal();
            }
        });
    });

    $(document).on('click', '.btnNonAktif', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/api/users/${id}/deactivate`,
            method: 'POST',
            headers: { Authorization: 'Bearer ' + token },
            success: loadUsers
        });
    });

    $(document).on('click', '.btnAktifkan', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/api/users/${id}/activate`,
            method: 'POST',
            headers: { Authorization: 'Bearer ' + token },
            success: loadUsers
        });
    });

    $(document).on('click', '.btnDelete', function() {
        const id = $(this).data('id');
        if(confirm('Yakin ingin menghapus user?')) {
            $.ajax({
                url: `/api/users/${id}`,
                method: 'DELETE',
                headers: { Authorization: 'Bearer ' + token },
                success: loadUsers
            });
        }
    });
});
</script>
@endsection
