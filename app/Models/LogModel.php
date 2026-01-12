<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LogModel
 *
 * Model ini digunakan untuk menyimpan aktivitas log aplikasi,
 * seperti request, response, method, URL, dan IP user.
 *
 * Menggunakan Soft Delete sehingga data tidak langsung terhapus
 * dari database.
 */
class LogModel extends Model
{
    // Trait untuk factory dan soft delete
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang digunakan oleh model ini
     */
    protected $table = 'log';

    /**
     * Primary key tabel log
     */
    protected $primaryKey = 'log_id';

    /**
     * Field yang boleh diisi secara mass assignment
     */
    protected $fillable = [
        'user_id',        // ID user yang melakukan aksi
        'log_method',     // HTTP method (GET, POST, PUT, DELETE)
        'log_url',        // URL endpoint yang diakses
        'log_ip',         // IP address user
        'log_request',    // Data request
        'log_response'    // Data response
    ];

    /**
     * Field yang disembunyikan saat model dikonversi ke JSON
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
