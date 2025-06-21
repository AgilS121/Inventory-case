@extends('layouts.app')

@section('content')
<style>
    
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0; top: 0; width: 100%; height: 100%;
    overflow: auto; background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 500px;
}

.modal-header, .modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
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
<h2 class="text-danger">Manajemen Transaksi (Danger Zone)</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>User</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="transaksiTable"></tbody>
</table>

<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fas fa-edit"></i> Edit Transaksi
            </h3>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="editForm">
            <input type="hidden" id="editId">
            <div class="modal-body">
                <div class="form-group">
                    <label for="editTanggal">Tanggal</label>
                    <div class="input-wrapper">
                        <input type="date" class="form-control" id="editTanggal" required>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editQty">Jumlah</label>
                    <div class="input-wrapper">
                        <input type="number" class="form-control" id="editQty" min="1" required>
                        <i class="fas fa-sort-numeric-up"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editTipe">Tipe Transaksi</label>
                    <div class="input-wrapper">
                        <select id="editTipe" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = '/login';

function loadTransaksi() {
    $.ajax({
        url: '/api/transaksi',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(data) {
            const userId =localStorage.getItem('userId');
            const userRole = localStorage.getItem('role');
            $('#transaksiTable').empty();
            data.forEach(trx => {
                let isEditable = (trx.user.id == userId || userRole == 'admin');
                let row = `<tr>
                    <td>${trx.id}</td>
                    <td>${trx.barang.nama} (${trx.barang.kode})</td>
                    <td>${trx.tanggal}</td>
                    <td>${trx.tipe_transaksi}</td>
                    <td>${trx.qty}</td>
                    <td>${trx.user.name}</td>
                    <td>`;

                if (isEditable) {
                    row += `
                        <button class="btn btn-warning btnEdit" data-id="${trx.id}">Edit</button>
                        <button class="btn btn-danger btnDelete" data-id="${trx.id}">Hapus</button>
                    `;
                } else {
                    row += `<span class="text-muted">No Access</span>`;
                }

                row += `</td></tr>`;

                $('#transaksiTable').append(row);
            });

        }
    });
}

function openEditModal() {
    $('#editModal').fadeIn(300);
}

function closeEditModal() {
    $('#editModal').fadeOut(300);
    $('#editForm')[0].reset();
    $('#editId').val('');
}

$(document).ready(function() {

    loadTransaksi();

    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/api/transaksi/${id}`,
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token },
            success: function(trx) {
                $('#editId').val(trx.id);
                $('#editTanggal').val(trx.tanggal);
                $('#editTipe').val(trx.tipe_transaksi);
                $('#editQty').val(trx.qty);
                openEditModal();
            }
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: `/api/transaksi/${id}`,
            method: 'PUT',
            headers: { Authorization: 'Bearer ' + token },
            data: {
                tanggal: $('#editTanggal').val(),
                tipe_transaksi: $('#editTipe').val(),
                qty: $('#editQty').val()
            },
            success: function() {
                closeEditModal();
                loadTransaksi();
            },
            error: function(xhr) {
                alert('Gagal update transaksi!');
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('click', '.btnDelete', function() {
        const id = $(this).data('id');
        if(confirm('Yakin ingin menghapus transaksi ini?')) {
            $.ajax({
                url: `/api/transaksi/${id}`,
                method: 'DELETE',
                headers: { Authorization: 'Bearer ' + token },
                success: loadTransaksi
            });
        }
    });
});

</script>
@endsection
