<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-200 font-sans">
    @include('layouts.sidebar')
    <div class="ml-64 px-6 py-10">
        <h1 class="text-3xl font-bold mb-6">📦 Daftar Barang</h1>

        <div class="flex gap-4 mb-6">
            <a href="{{ route('barangs.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                ➕ Tambah Barang
            </a>
            <a href="{{ route('barangs.trashed') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                ♻️ Restore Barang
            </a>
            <a href="{{ route('barangs.export.pdf', request()->query()) }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
                🧾 Export PDF
            </a>
            <a href="{{ route('barangs.export.excel', request()->query()) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                📊 Export Excel
            </a>
        </div>

        <form method="GET" class="flex gap-4 mb-6 items-end flex-wrap">
            <input type="text" name="keyword" placeholder="Cari Nama Barang" value="{{ request('keyword') }}"
                class="px-3 py-2 rounded bg-gray-700 text-white border border-gray-600" />

            <select name="kategori_id" class="px-3 py-2 rounded bg-gray-700 text-white border border-gray-600">
                <option value="">Pilih Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <div>
                <label class="text-white text-sm block mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    class="px-3 py-2 rounded bg-gray-700 text-white border border-gray-600" />
            </div>

            <div>
                <label class="text-white text-sm block mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}"
                    class="px-3 py-2 rounded bg-gray-700 text-white border border-gray-600" />
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">🔍
                Filter</button>

            <a href="{{ route('barangs.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">❌ Reset</a>
        </form>



        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700 text-gray-300 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Stok</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Supplier</th>
                        <th class="px-6 py-3 text-left">Harga</th>
                        <th class="px-6 py-3 text-left">Tanggal Ditambahkan</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @foreach ($barangs as $barang)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $barang->stok }}</td>
                            <td class="px-6 py-4">{{ $barang->kategori->nama_kategori ?? 'Tidak ada' }}</td>
                            <td class="px-6 py-4">
                                @foreach ($barang->suppliers as $supplier)
                                    <div>{{ $supplier->nama_supplier }}</div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @foreach ($barang->suppliers as $supplier)
                                    <div>- Rp{{ number_format($supplier->pivot->harga_beli, 0, ',', '.') }}</div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $barang->created_at->translatedFormat('d F Y') }}</td>

                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('barangs.edit', $barang->id) }}"
                                    class="text-green-400 hover:underline">Edit</a>
                                <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
