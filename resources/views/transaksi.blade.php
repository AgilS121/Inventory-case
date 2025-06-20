@extends('layouts.app')

@section('content')
<h2>Data Transaksi</h2>

<div class="mb-3">
    <input type="text" id="searchTransaksi" class="form-control" placeholder="Cari Barang atau User...">
</div>

<form id="transaksiForm">
    <div class="mb-3">
        <label>Barang</label>
        <select id="id_barang" class="form-control" required></select>
    </div>
    <div class="mb-3">
        <label>Jenis Transaksi</label>
        <select id="tipe_transaksi" class="form-control" required>
            <option value="masuk">Masuk</option>
            <option value="keluar">Keluar</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" id="qty" class="form-control" required min="1">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>

<hr>
<h3>Riwayat Transaksi</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody id="transaksiTable"></tbody>
</table>
@endsection

@section('scripts')
<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = '/login';

function loadBarangOptions() {
    $.ajax({
        url: '/api/barangs',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(barangs) {
            $('#id_barang').empty();
            barangs.forEach(b => {
                $('#id_barang').append(`<option value="${b.id}">${b.nama} (${b.kode})</option>`);
            });
        }
    });
}

function loadTransaksi() {
    $.ajax({
        url: '/api/transaksi',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(data) {
            $('#transaksiTable').empty();
            data.forEach(t => {
                $('#transaksiTable').append(`<tr>
                    <td>${t.tanggal}</td>
                    <td>${t.barang.nama}</td>
                    <td>${t.tipe_transaksi}</td>
                    <td>${t.qty}</td>
                </tr>`);
            });
        }
    });
}

$(document).ready(function() {
    loadBarangOptions();
    loadTransaksi();

    $('#searchTransaksi').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#transaksiTable tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#transaksiForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/api/transaksi',
            method: 'POST',
            headers: { 
                
                Authorization: 'Bearer ' + token
            },
            data: {
                id_barang: $('#id_barang').val(),
                tanggal: new Date().toISOString().slice(0, 19).replace('T', ' '),
                tipe_transaksi: $('#tipe_transaksi').val(),
                qty: $('#qty').val()
            },
            success: function() {
                loadTransaksi();
            },
            error: function(err) {
                alert(err.responseJSON?.message || 'Gagal transaksi');
            }
        });
    });
});
</script>
@endsection
