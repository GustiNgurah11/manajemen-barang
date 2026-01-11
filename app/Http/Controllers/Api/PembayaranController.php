<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\TransaksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PembayaranController extends Controller
{
    /**
     * Menampilkan semua data pembayaran
     */
    public function index()
    {
        $data = Pembayaran::with('transaksi')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data pembayaran',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan data pembayaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id'       => 'required|exists:transaksi_barang,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar'       => 'required|numeric|min:0',
            'metode_pembayaran'  => 'required|string|max:50',
            'status_pembayaran'  => 'nullable|string|max:20',
        ]);

        $pembayaran = Pembayaran::create([
            'transaksi_id'       => $request->transaksi_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar'       => $request->jumlah_bayar,
            'metode_pembayaran'  => $request->metode_pembayaran,
            'status_pembayaran'  => $request->status_pembayaran ?? 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil ditambahkan',
            'data' => $pembayaran
        ], Response::HTTP_CREATED);
    }

    /**
     * Menampilkan detail pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with('transaksi')->find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'data' => $pembayaran
        ], Response::HTTP_OK);
    }

    /**
     * Mengupdate data pembayaran
     */
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'transaksi_id'       => 'required|exists:transaksi_barang,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar'       => 'required|numeric|min:0',
            'metode_pembayaran'  => 'required|string|max:50',
            'status_pembayaran'  => 'nullable|string|max:20',
        ]);

        $pembayaran->update([
            'transaksi_id'       => $request->transaksi_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar'       => $request->jumlah_bayar,
            'metode_pembayaran'  => $request->metode_pembayaran,
            'status_pembayaran'  => $request->status_pembayaran ?? $pembayaran->status_pembayaran,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil diperbarui',
            'data' => $pembayaran
        ], Response::HTTP_OK);
    }

    /**
     * Menghapus data pembayaran
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $pembayaran->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil dihapus'
        ], Response::HTTP_OK);
    }
    /**
 * Menampilkan pembayaran berdasarkan transaksi
 */
public function getByTransaksi($transaksi_id)
{
    $data = Pembayaran::where('transaksi_id', $transaksi_id)->get();

    if ($data->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Pembayaran untuk transaksi ini tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Data pembayaran berdasarkan transaksi',
        'data' => $data
    ], 200);
}
}
