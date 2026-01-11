<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBarang extends Model
{
    use HasFactory;

    protected $table = 'transaksi_barang'; // SESUAI MIGRATION

    protected $fillable = [
        'barang_id',
        'supplier_id',
        'tanggal_transaksi',
        'jumlah',
        'harga_satuan',
        'total_harga'
    ];

    /**
     * Relasi ke barang
     * 1 Transaksi -> 1 Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Relasi ke supplier
     * 1 Transaksi -> 1 Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke pembayaran
     * 1 Transaksi -> Banyak Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'transaksi_id');
    }
}
