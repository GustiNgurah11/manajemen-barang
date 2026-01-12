<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pembayaran
 *
 * Model ini merepresentasikan tabel pembayaran
 * yang menyimpan data transaksi pembayaran.
 */
class Pembayaran extends Model
{
    // Trait untuk factory
    use HasFactory;

    /**
     * Nama tabel pada database
     */
    protected $table = 'pembayaran';

    /**
     * Field yang dapat diisi secara mass assignment
     */
    protected $fillable = [
        'transaksi_id',        // ID transaksi terkait
        'tanggal_pembayaran',  // Tanggal pembayaran
        'jumlah_bayar',        // Nominal pembayaran
        'metode_pembayaran',   // Metode pembayaran (cash, transfer, dll)
        'status_pembayaran'    // Status pembayaran (lunas, pending, gagal)
    ];

    /**
     * Relasi ke transaksi barang
     * 1 Pembayaran -> 1 Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(TransaksiBarang::class, 'transaksi_id');
    }
}
