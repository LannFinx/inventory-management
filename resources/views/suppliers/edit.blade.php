<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200 font-sans">
    <div class="container mx-auto px-4 py-10 max-w-xl">
        <h2 class="text-3xl font-extrabold mb-6 text-white">✏️ Edit Supplier</h2>

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block mb-1 text-sm font-medium">Nama Supplier:</label>
                <input type="text" name="nama_supplier" value="{{ $supplier->nama_supplier }}" required
                    class="w-full px-4 py-2 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Alamat:</label>
                <textarea name="alamat" required
                    class="w-full px-4 py-2 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-green-500">{{ $supplier->alamat }}</textarea>
            </div>

            <button type="submit"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow-md hover:shadow-green-500 transition">
                🔄 Update
            </button>
        </form>
    </div>
</body>
</html>
