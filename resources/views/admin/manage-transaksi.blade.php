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

/* Pagination Styles */
.pagination-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
    flex-wrap: wrap;
    gap: 15px;
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    color: #6b7280;
}

.pagination-info select {
    padding: 5px 10px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.9rem;
}

.pagination-nav {
    display: flex;
    align-items: center;
    gap: 5px;
}

.pagination-nav button {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    min-width: 40px;
}

.pagination-nav button:hover:not(:disabled) {
    background: #f3f4f6;
}

.pagination-nav button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-nav button.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.data-summary {
    background: #f8fafc;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: #475569;
}
</style>

<h2 class="text-danger">Manajemen Transaksi (Danger Zone)</h2>

<div class="data-summary" id="dataSummary">
    Memuat data...
</div>

<div class="pagination-controls">
    <div class="pagination-info">
        <span>Tampilkan</span>
        <select id="perPageSelect">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span>data per halaman</span>
    </div>
    
    <div class="pagination-nav" id="paginationNav">
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>User</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="transaksiTable"></tbody>
</table>

<div class="pagination-controls">
    <div class="pagination-info" id="paginationInfo">
    </div>
    
    <div class="pagination-nav" id="paginationNavBottom">
    </div>
</div>

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

let currentPage = 1;
let perPage = 10;
let totalData = 0;
let totalPages = 0;

function loadTransaksi(page = 1, limit = perPage) {
    currentPage = page;
    perPage = limit;
    
    $('#transaksiTable').html('<tr><td colspan="6" class="text-center">Memuat data...</td></tr>');
    
    $.ajax({
        url: '/api/transaksi',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        data: {
            page: page,
            per_page: limit
        },
        success: function(response) {
            if (Array.isArray(response)) {
                handleArrayResponse(response, page, limit);
            } 
            else if (response.data) {
                handlePaginatedResponse(response);
            }
            else {
                handleArrayResponse(response, page, limit);
            }
        },
        error: function(xhr) {
            $('#transaksiTable').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>');
            console.error('Error loading data:', xhr);
        }
    });
}

function handleArrayResponse(data, page, limit) {
    totalData = data.length;
    totalPages = Math.ceil(totalData / limit);
    
    const startIndex = (page - 1) * limit;
    const endIndex = Math.min(startIndex + limit, totalData);
    const paginatedData = data.slice(startIndex, endIndex);
    
    renderTable(paginatedData);
    updatePaginationInfo(startIndex + 1, endIndex, totalData);
    renderPagination();
}

function handlePaginatedResponse(response) {
    totalData = response.total || response.data.length;
    totalPages = response.last_page || Math.ceil(totalData / perPage);
    currentPage = response.current_page || currentPage;
    
    renderTable(response.data);
    
    const from = response.from || ((currentPage - 1) * perPage) + 1;
    const to = response.to || Math.min(currentPage * perPage, totalData);
    
    updatePaginationInfo(from, to, totalData);
    renderPagination();
}

function renderTable(data) {
    $('#transaksiTable').empty();
    
    if (data.length === 0) {
        $('#transaksiTable').html('<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>');
        return;
    }
    
    data.forEach(trx => {
        let row = `<tr>
            <td>${trx.id}</td>
            <td>${trx.barang ? trx.barang.nama + ' (' + trx.barang.kode + ')' : 'N/A'}</td>
            <td>${trx.tanggal}</td>
            <td>${trx.tipe_transaksi}</td>
            <td>${trx.user ? trx.user.name : 'N/A'}</td>
            <td>
                <button class="btn btn-warning btn-sm btnEdit" data-id="${trx.id}">Edit</button>
                <button class="btn btn-danger btn-sm btnDelete" data-id="${trx.id}">Hapus</button>
            </td>
        </tr>`;
        $('#transaksiTable').append(row);
    });
}

function updatePaginationInfo(from, to, total) {
    const infoText = `Menampilkan ${from}-${to} dari ${total} data`;
    $('#paginationInfo').text(infoText);
    $('#dataSummary').text(`Total ${total} transaksi ditemukan`);
}

function renderPagination() {
    const nav = generatePaginationHTML();
    $('#paginationNav').html(nav);
    $('#paginationNavBottom').html(nav);
}

function generatePaginationHTML() {
    if (totalPages <= 1) return '';
    
    let html = '';
    
    html += `<button onclick="changePage(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>
        <i class="fas fa-chevron-left"></i>
    </button>`;
    
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        html += `<button onclick="changePage(1)">1</button>`;
        if (startPage > 2) {
            html += `<span style="padding: 8px;">...</span>`;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `<button onclick="changePage(${i})" class="${i === currentPage ? 'active' : ''}">${i}</button>`;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span style="padding: 8px;">...</span>`;
        }
        html += `<button onclick="changePage(${totalPages})">${totalPages}</button>`;
    }
    
    html += `<button onclick="changePage(${currentPage + 1})" ${currentPage >= totalPages ? 'disabled' : ''}>
        <i class="fas fa-chevron-right"></i>
    </button>`;
    
    return html;
}

function changePage(page) {
    if (page < 1 || page > totalPages || page === currentPage) return;
    loadTransaksi(page, perPage);
}

function changePerPage(newPerPage) {
    perPage = parseInt(newPerPage);
    currentPage = 1;
    loadTransaksi(currentPage, perPage);
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
    
    $('#perPageSelect').change(function() {
        changePerPage($(this).val());
    });
    
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
            },
            error: function(xhr) {
                alert('Gagal memuat data transaksi!');
                console.error(xhr.responseText);
            }
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: `/api/transaksi/${id}`,
            method: 'PUT',
            headers: { 
                Authorization: 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                tanggal: $('#editTanggal').val(),
                tipe_transaksi: $('#editTipe').val(),
                qty: $('#editQty').val()
            }),
            success: function() {
                closeEditModal();
                loadTransaksi(currentPage, perPage);
                alert('Transaksi berhasil diupdate!');
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
                success: function() {
                    const remainingData = totalData - 1;
                    const maxPageAfterDelete = Math.ceil(remainingData / perPage);
                    const newPage = currentPage > maxPageAfterDelete ? Math.max(1, maxPageAfterDelete) : currentPage;
                    
                    loadTransaksi(newPage, perPage);
                    alert('Transaksi berhasil dihapus!');
                },
                error: function(xhr) {
                    alert('Gagal menghapus transaksi!');
                    console.error(xhr.responseText);
                }
            });
        }
    });
});

</script>
@endsection