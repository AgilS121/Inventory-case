<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['web'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/transaksi', function () {
        return view('transaksi');
    })->name('transaksi');

    Route::get('/barang', function () {
        return view('barang');
    })->name('barang');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/ubah-password', function() {
        return view('ubah-password');
    });


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');

        Route::get('/transaksi/manage', function() {
            return view('admin.manage-transaksi');
        })->name('transaksi.manage');

        Route::get('/stok-log', function() {
            return view('admin.stok-log');
        })->name('stok-log');

    });
});