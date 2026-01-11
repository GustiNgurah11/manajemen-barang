<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarangController extends Controller
{
    /**
     * Menampilkan semua barang
     */
    public function index()
    {
        $data = Barang::with('kategori')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data barang',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan data barang baru
     */
    public function store(Request $request)
    {
    $request->validate([
        'kategori_id' => 'required|exists:kategori_barang',
        'nama_barang' => 'required|string',
        'stok'        => 'required|integer',
        'harga'       => 'required|numeric',
    ]);

    $barang = Barang::create([
        'kategori_id' => $request->kategori_id,
        'nama_barang' => $request->nama_barang,
        'stok'        => $request->stok,
        'harga'       => $request->harga,
    ]);

    return response()->json($barang, 201);
    }


    /**
     * Menampilkan detail barang
     */
    public function show($id)
    {
        $barang = Barang::with('kategori')->find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'data' => $barang
        ], Response::HTTP_OK);
    }

    /**
     * Mengupdate data barang
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'kategori_id'  => 'required|exists:kategori_barang,kategori_id',
            'nama_barang'  => 'required|string|max:100',
            'stok'        => 'required|integer',
            'harga'       => 'required|numeric',
        ]);

        $barang->update([
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ], Response::HTTP_OK);
    }

    /**
     * Menghapus barang
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil dihapus'
        ], Response::HTTP_OK);
    }

    public function getByKategori($kategori_id)
    {
    $barang = Barang::where('kategori_id', $kategori_id)->get();

    return response()->json([
        'code' => 200,
        'message' => 'Data barang berhasil diambil',
        'data' => $barang
    ]);
    }

}
