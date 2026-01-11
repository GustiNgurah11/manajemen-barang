<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    /**
     * Menampilkan semua supplier
     */
    public function index()
    {
        $data = Supplier::all();

        return response()->json([
            'status' => true,
            'message' => 'Data supplier',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan data supplier baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'alamat'        => 'nullable|string',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'required|email|unique:supplier,email'
        ]);

        $supplier = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'no_telepon'    => $request->no_telepon,
            'email'         => $request->email,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil ditambahkan',
            'data' => $supplier
        ], Response::HTTP_CREATED);
    }

    /**
     * Menampilkan detail supplier
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'data' => $supplier
        ], Response::HTTP_OK);
    }

    /**
     * Mengupdate data supplier
     */
   public function update(Request $request, $id)
    {
    $supplier = Supplier::find($id);

    if (!$supplier) {
        return response()->json([
            'status' => false,
            'message' => 'Supplier tidak ditemukan'
        ], Response::HTTP_NOT_FOUND);
    }

    $request->validate([
        'nama_supplier' => 'required|string|max:100',
        'alamat'        => 'nullable|string',
        'no_telepon'    => 'nullable|string|max:20',
        'email' => 'nullable|email|unique:supplier,email,' . $id
    ]);

    $supplier->update($request->only([
        'nama_supplier',
        'alamat',
        'no_telepon',
        'email'
    ]));

    return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil diperbarui',
            'data' => $supplier
        ], Response::HTTP_OK);
    }


    /**
     * Menghapus supplier
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $supplier->delete();

        return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil dihapus'
        ], Response::HTTP_OK);
    }
}
