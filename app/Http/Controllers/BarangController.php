<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with(['kategori', 'suppliers'])->get();
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('barangs.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|array|min:1',
            'supplier_id.*' => 'exists:suppliers,id',
            'harga_beli' => 'required|array',
        ]);

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        foreach ($request->supplier_id as $index => $supplierId) {
            $barang->suppliers()->attach($supplierId, [
                'harga_beli' => $request->harga_beli[$index] ?? 0
            ]);
        }

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::where('id', $id)->with('suppliers')->firstOrFail();
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('barangs.edit', compact('barang', 'kategoris', 'suppliers'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|array|min:1',
            'supplier_id.*' => 'exists:suppliers,id',
            'harga_beli' => 'required|array',
        ]);

        $barang = Barang::where('id', $id)->firstOrFail();

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        $syncData = [];
        foreach ($request->supplier_id as $index => $supplierId) {
            $syncData[$supplierId] = ['harga_beli' => $request->harga_beli[$index] ?? 0];
        }

        $barang->suppliers()->sync($syncData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui');
    }


    public function destroy($id)
    {
        $barang = Barang::where('id', $id)->firstOrFail();
        $barang->delete();
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus');
    }

    public function trashed()
    {
        $barangs = Barang::onlyTrashed()->with(['kategori', 'suppliers'])->get();
        return view('barangs.trashed', compact('barangs'));
    }

    public function restore($id)
    {
        $barang = Barang::onlyTrashed()->where('id', $id)->firstOrFail();
        $barang->restore();
        return redirect()->route('barangs.trashed')->with('success', 'Barang berhasil direstore');
    }

    public function forceDelete($id)
    {
        $barang = Barang::onlyTrashed()->where('id', $id)->firstOrFail();
        $barang->forceDelete();
        return redirect()->route('barangs.trashed')->with('success', 'Barang dihapus permanen');
    }
}
