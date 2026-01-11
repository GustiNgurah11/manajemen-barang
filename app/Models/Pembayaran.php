<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'transaksi_id',
        'tanggal_pembayaran',
        'jumlah_bayar',
        'metode_pembayaran',
        'status_pembayaran'
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
