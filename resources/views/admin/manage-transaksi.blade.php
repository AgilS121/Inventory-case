@extends('layouts.app')

@section('content')
<h2 class="text-danger">Manajemen Transaksi (Danger Zone)</h2>

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

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editId">
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" class="form-control" id="editTanggal" required>
            </div>
            <div class="mb-3">
                <label>Tipe</label>
                <select id="editTipe" class="form-control">
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
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
            $('#transaksiTable').empty();
            data.forEach(trx => {
                let row = `<tr>
                    <td>${trx.id}</td>
                    <td>${trx.barang.nama} (${trx.barang.kode})</td>
                    <td>${trx.tanggal}</td>
                    <td>${trx.tipe_transaksi}</td>
                    <td>${trx.user.name}</td>
                    <td>
                        <button class="btn btn-warning btnEdit" data-id="${trx.id}">Edit</button>
                        <button class="btn btn-danger btnDelete" data-id="${trx.id}">Hapus</button>
                    </td>
                </tr>`;
                $('#transaksiTable').append(row);
            });
        }
    });
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
                new bootstrap.Modal(document.getElementById('editModal')).show();
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
                tipe_transaksi: $('#editTipe').val()
            },
            success: function() {
                new bootstrap.Modal(document.getElementById('editModal')).hide();
                loadTransaksi();
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
