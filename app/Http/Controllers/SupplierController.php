<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus');
    }

    public function trashed()
    {
        $suppliers = Supplier::onlyTrashed()->get();
        return view('suppliers.trashed', compact('suppliers'));
    }


    public function restore($id)
    {
        $supplier = Supplier::onlyTrashed()->where('id', $id)->firstOrFail();
        $supplier->restore();
        return redirect()->route('suppliers.trashed')->with('success', 'Supplier berhasil direstore');
    }

    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->where('id', $id)->firstOrFail();
        $supplier->forceDelete();
        return redirect()->route('suppliers.trashed')->with('success', 'Supplier dihapus permanen');
    }
}
