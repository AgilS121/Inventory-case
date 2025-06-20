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
<h2>Data Barang</h2>

<div class="mb-3">
    <input type="text" id="searchBarang" class="form-control" placeholder="Cari Nama atau Kode Barang...">
</div>

<div class="alert alert-danger" id="stokMenipisAlert" style="display: none;">
    Ada <span id="totalMenipis"></span> barang dengan stok kurang dari 10!
</div>

<button id="btnAdd" class="btn btn-success mb-3" onclick="openModal()">Tambah Barang</button>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kode</th>
            <th>Stok</th>
            <th>Lokasi Rak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="barangTable"></tbody>
</table>


<div id="barangModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fas fa-key"></i>
                Form Barang
            </h3>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="barangForm">
            <div class="modal-body">
                <input type="hidden" id="barangId">

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="nama" required>
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="kode" required>
                        <i class="fas fa-barcode"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <div class="input-wrapper">
                        <input type="number" class="form-control" id="stok" required>
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lokasi_rak">Lokasi Rak</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="lokasi_rak" required>
                        <i class="fas fa-warehouse"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">
                    Batal
                </button>
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

function loadBarang() {
    $.ajax({
        url: '/api/barangs',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(barangs) {
            $('#barangTable').empty();
            let totalMenipis = 0;

            barangs.forEach(barang => {
                let row = `<tr${barang.stok < 10 ? ' class="table-danger"' : ''}>
                    <td>${barang.nama}</td>
                    <td>${barang.kode}</td>
                    <td>${barang.stok}</td>
                    <td>${barang.lokasi_rak}</td>
                    <td>
                        <button class="btn btn-warning btnEdit" data-id="${barang.id}">Edit</button>
                        <button class="btn btn-danger btnDelete" data-id="${barang.id}">Hapus</button>
                    </td>
                </tr>`;
                $('#barangTable').append(row);

                if (barang.stok < 10) totalMenipis++;
            });

            if (totalMenipis > 0) {
                $('#stokMenipisAlert').show();
                $('#totalMenipis').text(totalMenipis);
            } else {
                $('#stokMenipisAlert').hide();
            }
        }
    });
}

function openModal() {
    $('#barangModal').fadeIn(300);
}

function closeModal() {
    $('#barangModal').fadeOut(300);
    $('#barangForm')[0].reset();
}


$(document).ready(function() {

    loadBarang();

    $('#searchBarang').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#barangTable tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#btnAdd').click(function() {
        $('#barangId').val('');
        $('#barangForm')[0].reset();
    });

    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/api/barangs/${id}`,
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token },
            success: function(barang) {
                $('#barangId').val(barang.id);
                $('#nama').val(barang.nama);
                $('#kode').val(barang.kode);
                $('#stok').val(barang.stok);
                $('#lokasi_rak').val(barang.lokasi_rak);
                openModal();
            }
        });
    });

    $(document).on('click', '.btnDelete', function() {
        if (!confirm('Yakin hapus?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: `/api/barangs/${id}`,
            method: 'DELETE',
            headers: { Authorization: 'Bearer ' + token },
            success: function() {
                loadBarang();
            }
        });
    });

    $('#barangForm').submit(function(e) {
        e.preventDefault();

        const id = $('#barangId').val().trim();
        const isEdit = id !== '';
        const method = isEdit ? 'PUT' : 'POST';
        const url = isEdit ? `/api/barangs/${id}` : '/api/barangs';

        const formData = {
            nama: $('#nama').val(),
            kode: $('#kode').val(),
            stok: $('#stok').val(),
            lokasi_rak: $('#lokasi_rak').val()
        };

        $.ajax({
            url: url,
            method: method,
            headers: { Authorization: 'Bearer ' + token },
            data: formData,
            success: function() {
                closeModal();
                loadBarang();
            },
            error: function(xhr) {
                alert('Gagal menyimpan data!');
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
@endsection
