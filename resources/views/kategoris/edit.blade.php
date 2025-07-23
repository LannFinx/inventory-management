<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">✏️ Edit Kategori</h2>
        <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1 text-sm font-medium">Nama Kategori:</label>
                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded">Update</button>
        </form>
    </div>
</body>
</html>