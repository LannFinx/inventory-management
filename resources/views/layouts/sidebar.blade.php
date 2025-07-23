<aside class="w-64 h-screen bg-gray-800 text-white fixed top-0 left-0 p-6 space-y-6 shadow-lg flex flex-col justify-between">
    <div>
        <div class="text-2xl font-bold text-white mb-6">📊 Dashboard</div>
        <nav class="flex flex-col space-y-4">
            <a href="{{ route('barangs.index') }}" class="text-gray-300 hover:bg-gray-700 px-4 py-2 rounded transition">📦 Barang</a>
            <a href="{{ route('kategoris.index') }}" class="text-gray-300 hover:bg-gray-700 px-4 py-2 rounded transition">📂 Kategori</a>
            <a href="{{ route('suppliers.index') }}" class="text-gray-300 hover:bg-gray-700 px-4 py-2 rounded transition">🚚 Supplier</a>
        </nav>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white transition">
            🔓 Logout
        </button>
    </form>
</aside>
