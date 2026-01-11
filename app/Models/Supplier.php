<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

   protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier',
        'alamat',
        'no_telepon',
        'email'
    ];

    /**
     * Relasi ke transaksi barang
     * 1 Supplier -> Banyak Transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(TransaksiBarang::class, 'supplier_id');
    }
}
