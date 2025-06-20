@extends('layouts.app')

@section('content')
<h2>Histori Perubahan Stok</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Barang</th>
            <th>Qty Sebelum</th>
            <th>Qty Sesudah</th>
            <th>User</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody id="stokLogTable"></tbody>
</table>
@endsection

@section('scripts')
<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = '/login';

function loadStokLog() {
    $.ajax({
        url: '/api/stok-logs',
        method: 'GET',
        headers: { Authorization: 'Bearer ' + token },
        success: function(logs) {
            $('#stokLogTable').empty();
            logs.forEach(log => {
                let row = `<tr>
                    <td>${log.barang.nama} (${log.barang.kode})</td>
                    <td>${log.qty_before}</td>
                    <td>${log.qty_after}</td>
                    <td>${log.user.name}</td>
                    <td>${log.created_at}</td>
                </tr>`;
                $('#stokLogTable').append(row);
            });
        }
    });
}

$(document).ready(function() {
    loadStokLog();
});
</script>
@endsection
