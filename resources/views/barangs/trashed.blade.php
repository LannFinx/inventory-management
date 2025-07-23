<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barang Terhapus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200 font-sans">
<div class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold mb-6">🗑️ Barang Terhapus</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700 text-gray-300 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Supplier</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($barangs as $barang)
                <tr class="hover:bg-gray-700 transition">
                    <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                    <td class="px-6 py-4">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @foreach($barang->suppliers as $supplier)
                            {{ $supplier->nama_supplier }}<br>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <form action="{{ route('barangs.restore', $barang->id) }}" method="POST" class="inline">
                            @csrf @method('PUT')
                            <button type="submit" class="text-yellow-400 hover:underline">Restore</button>
                        </form>
                        <form action="{{ route('barangs.forceDelete', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:underline">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('barangs.index') }}" class="text-blue-400 hover:underline">← Kembali ke Barang</a>
    </div>
</div>
</body>
</html>
