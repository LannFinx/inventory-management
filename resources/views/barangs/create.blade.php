<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-200 font-sans">
    <div class="container mx-auto px-4 py-10 max-w-3xl">
        <h1 class="text-3xl font-bold mb-6">➕ Tambah Barang</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-700 p-4 rounded">
                <ul class="list-disc list-inside text-white">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/barangs/store') }}" method="POST" class="space-y-4 bg-gray-800 p-6 rounded shadow">
            @csrf

            <div>
                <label class="block mb-1">Nama Barang:</label>
                <input type="text" name="nama_barang" required
                    class="w-full bg-gray-700 text-white px-4 py-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Stok:</label>
                <input type="number" name="stok" required class="w-full bg-gray-700 text-white px-4 py-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Kategori:</label>
                <select name="kategori_id" required class="w-full bg-gray-700 text-white px-4 py-2 rounded">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div id="supplier-container">
                <label class="block mb-2">Supplier dan Harga Beli:</label>

                <div class="supplier-group mb-4">
                    <select name="supplier_id[]" class="w-full bg-gray-700 text-white px-4 py-2 rounded mb-2">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="harga_beli[]" step="0.01" required placeholder="Harga Beli"
                        class="w-full bg-gray-700 text-white px-4 py-2 rounded" />
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">💾
                Simpan</button>
        </form>
    </div>


</body>

</html>
