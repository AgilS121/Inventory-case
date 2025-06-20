@extends('layouts.app')

@section('content')
<h2>Ubah Password</h2>

<form id="ubahPasswordForm">
    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" id="newPassword" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection

@section('scripts')
<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = '/login';

$('#ubahPasswordForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: '/api/ubah-password',
        method: 'POST',
        headers: { Authorization: 'Bearer ' + token },
        data: { password: $('#newPassword').val() },
        success: function() {
            alert('Password berhasil diubah');
            $('#newPassword').val('');
        }
    });
});
</script>
@endsection
