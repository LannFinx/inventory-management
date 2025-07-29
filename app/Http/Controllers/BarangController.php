<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf; // Pastikan ini ada di atas controller Anda
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\BarangExport;


class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'suppliers']);

        if ($request->filled('keyword')) {
            $query->where('nama_barang', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $barangs = $query->get();
        $kategoris = Kategori::all();

        return view('barangs.index', compact('barangs', 'kategoris'));
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|array|min:1',
            'supplier_id.*' => 'exists:suppliers,id',
            'harga_beli' => 'required|array',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('gambar-barang', 'public');
        } else {
            $gambarPath = null;
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambarPath,
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'supplier_id' => 'required|array|min:1',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'required|array',
        ]);

        $barang = Barang::where('id', $id)->firstOrFail();

        // Cek apakah user meng-upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }


            // Simpan gambar baru
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('gambar-barang', 'public');

            $barang->gambar = $gambarPath;
        }

        // Update data lainnya
        $barang->nama_barang = $request->nama_barang;
        $barang->stok = $request->stok;
        $barang->kategori_id = $request->kategori_id;
        $barang->save();

        // Update pivot supplier
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



    public function exportPdf(Request $request)
    {
        $barangs = $this->getFilteredBarangs($request);

        // Gunakan alias yang benar
        $pdf = FacadePdf::loadView('barangs.export_pdf', compact('barangs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new BarangExport($request), 'laporan-barang.xlsx');
    }

    private function getFilteredBarangs(Request $request)
    {
        $query = Barang::with(['kategori', 'suppliers']);

        if ($request->filled('keyword')) {
            $query->where('nama_barang', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        return $query->get();
    }
}
