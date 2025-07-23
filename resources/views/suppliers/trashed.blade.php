<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Terhapus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200 font-sans">
    <div class="container mx-auto px-4 py-10">
        <h2 class="text-3xl font-extrabold mb-6 text-white">🗑️ Supplier Terhapus</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-700 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

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
                    @foreach($suppliers as $supplier)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-4">{{ $supplier->nama_supplier }}</td>
                        <td class="px-6 py-4">{{ $supplier->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 flex gap-2 flex-wrap">
                            <form action="{{ route('suppliers.restore', $supplier->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-1 rounded text-sm shadow-md hover:shadow-yellow-500 transition">
                                    ♻️ Restore
                                </button>
                            </form>
                            <form action="{{ route('suppliers.forceDelete', $supplier->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-sm shadow-md hover:shadow-red-500 transition">
                                    ❌ Hapus Permanen
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            <a href="{{ route('suppliers.index') }}"
                class="text-blue-400 hover:underline">← Kembali ke Supplier</a>
        </div>
    </div>
</body>
</html>
