<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barang';

    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    /**
     * Relasi ke barang
     * 1 Kategori -> Banyak Barang
     */
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
