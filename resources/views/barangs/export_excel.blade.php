<table>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Harga Beli</th>
            <th>Tanggal Ditambahkan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
            <tr>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->stok }}</td>
                <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    {{ $barang->suppliers->pluck('nama_supplier')->implode(', ') }}
                </td>
                <td>
                    @php
                        echo 'Rp' . implode(', ', $barang->suppliers->map(function($s) {
                            return number_format($s->pivot->harga_beli, 0, ',', '.');
                        })->toArray());
                    @endphp
                </td>
                <td>{{ \Carbon\Carbon::parse($barang->created_at)->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
