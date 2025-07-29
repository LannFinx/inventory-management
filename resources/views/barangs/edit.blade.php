<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-200 font-sans">
    <div class="container mx-auto px-4 py-10 max-w-3xl">
        <h1 class="text-3xl font-bold mb-6">✏️ Edit Barang</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-700 p-4 rounded">
                <ul class="list-disc list-inside text-white">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/barangs/update/' . $barang->id) }}" method="POST"
            class="space-y-4 bg-gray-800 p-6 rounded shadow" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Nama Barang:</label>
                <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required
                    class="w-full bg-gray-700 text-white px-4 py-2 rounded">
            </div>
            
            <div>
                <label class="block mb-1">Gambar Barang:</label>

                @if ($barang->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="h-32 rounded">
                    </div>
                @endif

                <input type="file" name="gambar" accept="image/*"
                    class="w-full bg-gray-700 text-white px-4 py-2 rounded">
                <p class="text-sm text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>


            <div>
                <label class="block mb-1">Stok:</label>
                <input type="number" name="stok" value="{{ $barang->stok }}" required
                    class="w-full bg-gray-700 text-white px-4 py-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Kategori:</label>
                <select name="kategori_id" required class="w-full bg-gray-700 text-white px-4 py-2 rounded">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $kategori->id == $barang->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="supplier-container">
                <label class="block mb-2">Supplier dan Harga Beli:</label>

                @foreach ($barang->suppliers as $supplier)
                    <div class="supplier-group mb-4">
                        <select name="supplier_id[]" class="w-full bg-gray-700 text-white px-4 py-2 rounded mb-2">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $supplier->id ? 'selected' : '' }}>
                                    {{ $s->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex items-center gap-2">
                            <input type="number" name="harga_beli[]" value="{{ $supplier->pivot->harga_beli }}"
                                step="0.01" placeholder="Harga Beli"
                                class="w-full bg-gray-700 text-white px-4 py-2 rounded" />
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">🔄
                Update</button>
        </form>
    </div>
</body>

</html>
