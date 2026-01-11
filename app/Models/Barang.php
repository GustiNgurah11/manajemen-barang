<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'stok',
        'harga',
];

    /**
     * Relasi ke kategori barang
     * 1 Barang -> 1 Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    /**
     * Relasi ke transaksi barang
     * 1 Barang -> Banyak Transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(TransaksiBarang::class, 'barang_id');
    }
}
