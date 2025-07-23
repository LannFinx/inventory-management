<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">📂 Data Kategori</h2>

        <a href="{{ route('kategoris.create') }}" class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">➕ Tambah Kategori</a>

        <ul class="space-y-4">
            @foreach ($kategoris as $kategori)
                <li class="bg-gray-800 p-4 rounded shadow flex justify-between items-center">
                    <span>{{ $kategori->nama_kategori }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('kategoris.edit', $kategori->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="flex gap-6 mt-10 text-sm">
            <a href="{{ route('suppliers.index') }}" class="text-blue-400 hover:underline">📂 Kategori</a>
            <a href="{{ route('barangs.index') }}" class="text-blue-400 hover:underline">📦 Barang</a>
        </div>
    </div>
</body>
</html>
