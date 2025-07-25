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
                    @foreach ($barang->suppliers as $s)
                        {{ $s->nama_supplier }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($barang->suppliers as $s)
                        Rp{{ number_format($s->pivot->harga_beli, 0, ',', '.') }}<br>
                    @endforeach
                </td>
                <td>{{ \Carbon\Carbon::parse($barang->created_at)->format('Y-m-d') }}</td> {{-- nilai --}}
            </tr>
        @endforeach
    </tbody>
</table>
