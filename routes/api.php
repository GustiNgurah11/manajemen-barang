<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriBarangController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TransaksiBarangController;
use App\Http\Controllers\Api\PembayaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* -------------------- AUTH -------------------- */
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function () {

    Route::get('me', [AuthController::class, 'me']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('logout', [AuthController::class, 'logout']);

    /* -------------------- KATEGORI BARANG -------------------- */
    Route::prefix('/kategori-barang')->group(function () {
        Route::get('',        [KategoriBarangController::class, 'index']);
        Route::post('',       [KategoriBarangController::class, 'store']);
        Route::get('/{id}',   [KategoriBarangController::class, 'show']);
        Route::put('/{id}',   [KategoriBarangController::class, 'update']);
        // Route::patch('/{id}', [KategoriBarangController::class, 'patch']);
        Route::delete('/{id}',[KategoriBarangController::class, 'destroy']);
    });

    /* -------------------- BARANG -------------------- */
    Route::prefix('/barang')->group(function () {
        Route::get('',        [BarangController::class, 'index']);
        Route::post('',       [BarangController::class, 'store']);
        Route::get('/{id}',   [BarangController::class, 'show']);
        Route::put('/{id}',   [BarangController::class, 'update']);
        // Route::patch('/{id}', [BarangController::class, 'patch']);
        Route::delete('/{id}',[BarangController::class, 'destroy']);
        Route::get('/by-kategori/{kategori_id}', [BarangController::class, 'getByKategori']);
    });

    /* -------------------- SUPPLIER -------------------- */
    Route::prefix('/supplier')->group(function () {
        Route::get('',        [SupplierController::class, 'index']);
        Route::post('',       [SupplierController::class, 'store']);
        Route::get('/{id}',   [SupplierController::class, 'show']);
        Route::put('/{id}',   [SupplierController::class, 'update']);
        // Route::patch('/{id}', [SupplierController::class, 'patch']);
        Route::delete('/{id}',[SupplierController::class, 'destroy']);
    });

    /* -------------------- TRANSAKSI BARANG -------------------- */
   Route::prefix('/transaksi-barang')->group(function () {
        Route::get('',        [TransaksiBarangController::class, 'index']);
        Route::post('',       [TransaksiBarangController::class, 'store']);
        Route::get('/{id}',   [TransaksiBarangController::class, 'show']);
        Route::put('/{id}',   [TransaksiBarangController::class, 'update']);
        Route::delete('/{id}',[TransaksiBarangController::class, 'destroy']);
    });

    /* -------------------- PEMBAYARAN -------------------- */
    Route::prefix('/pembayaran')->group(function () {
        Route::get('',        [PembayaranController::class, 'index']);
        Route::post('',       [PembayaranController::class, 'store']);
        Route::get('/{id}',   [PembayaranController::class, 'show']);
        Route::put('/{id}',   [PembayaranController::class, 'update']);
        // Route::patch('/{id}', [PembayaranController::class, 'patch']);
        Route::delete('/{id}',[PembayaranController::class, 'destroy']);
        Route::get('/by-transaksi/{transaksi_id}', [PembayaranController::class, 'getByTransaksi']);
    });

});
