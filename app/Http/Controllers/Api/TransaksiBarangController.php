<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiBarang;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransaksiBarangController extends Controller
{
    /**
     * Menampilkan semua transaksi barang
     */
    public function index()
    {
        $data = TransaksiBarang::with(['barang', 'supplier'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data transaksi barang',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan transaksi barang baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'         => 'required|exists:barang,id',
            'supplier_id'       => 'nullable|exists:supplier,id',
            'tanggal_transaksi' => 'required|date',
            'jumlah'            => 'required|integer|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
        ]);

        $total = $request->jumlah * $request->harga_satuan;

        $transaksi = TransaksiBarang::create([
            'barang_id'         => $request->barang_id,
            'supplier_id'       => $request->supplier_id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jumlah'            => $request->jumlah,
            'harga_satuan'      => $request->harga_satuan,
            'total_harga'       => $total,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaksi barang berhasil ditambahkan',
            'data' => $transaksi
        ], Response::HTTP_CREATED);
    }

    /**
     * Menampilkan detail transaksi barang
     */
    public function show($id)
    {
        $transaksi = TransaksiBarang::with(['barang', 'supplier'])->find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'data' => $transaksi
        ], Response::HTTP_OK);
    }

    /**
     * Mengupdate transaksi barang
     */
    public function update(Request $request, $id)
    {
        $transaksi = TransaksiBarang::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'barang_id'         => 'required|exists:barang,id',
            'supplier_id'       => 'nullable|exists:supplier,id',
            'tanggal_transaksi' => 'required|date',
            'jumlah'            => 'required|integer|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
        ]);

        $total = $request->jumlah * $request->harga_satuan;

        $transaksi->update([
            'barang_id'         => $request->barang_id,
            'supplier_id'       => $request->supplier_id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jumlah'            => $request->jumlah,
            'harga_satuan'      => $request->harga_satuan,
            'total_harga'       => $total,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaksi barang berhasil diperbarui',
            'data' => $transaksi
        ], Response::HTTP_OK);
    }

    /**
     * Menghapus transaksi barang
     */
    public function destroy($id)
    {
        $transaksi = TransaksiBarang::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi barang tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $transaksi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Transaksi barang berhasil dihapus'
        ], Response::HTTP_OK);
    }
}
