<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KategoriBarangController extends Controller
{
    /**
     * Menampilkan semua kategori barang
     */
    public function index()
    {
        $data = KategoriBarang::all();

        return response()->json([
            'status' => true,
            'message' => 'Data kategori barang',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan data kategori barang baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string'
        ]);

        $kategori = KategoriBarang::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kategori barang berhasil ditambahkan',
            'data' => $kategori
        ], Response::HTTP_CREATED);
    }

    /**
     * Menampilkan detail kategori barang
     */
    public function show($id)
    {
        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'data' => $kategori
        ], Response::HTTP_OK);
    }

    /**
     * Mengupdate kategori barang
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kategori barang berhasil diperbarui',
            'data' => $kategori
        ], Response::HTTP_OK);
    }

    /**
     * Menghapus kategori barang
     */
    public function destroy($id)
    {
        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $kategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kategori barang berhasil dihapus'
        ], Response::HTTP_OK);
    }
}
