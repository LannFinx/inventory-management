<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200 font-sans">

<div class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-extrabold mb-8 text-white">📦 Data Supplier</h2>

    <div class="flex flex-wrap gap-4 mb-8">
        <a href="{{ route('suppliers.create') }}" class="btn-glow btn-blue">
            ➕ Tambah Supplier
        </a>
        <a href="{{ route('suppliers.trashed') }}" class="btn-glow btn-yellow">
            ♻️ Restore Supplier
        </a>
    </div>

    <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700 text-gray-300 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Supplier</th>
                    <th class="px-6 py-3 text-left">Alamat</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($suppliers as $supplier)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-4">{{ $supplier->nama_supplier }}</td>
                        <td class="px-6 py-4">{{ $supplier->alamat }}</td>
                        <td class="px-6 py-4 flex flex-wrap gap-2">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn-glow btn-green text-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-glow btn-red text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex gap-6 mt-10 text-sm">
        <a href="{{ route('kategoris.index') }}" class="text-blue-400 hover:underline">📂 Kategori</a>
        <a href="{{ route('barangs.index') }}" class="text-blue-400 hover:underline">📦 Barang</a>
    </div>
</div>

</body>
</html>
