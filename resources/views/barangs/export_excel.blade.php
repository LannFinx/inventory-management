
<table>
    <thead>
        <tr>
            <th colspan="6"
                style="background-color:#c0392b; color:#fff; padding:12px; font-size:16px; text-transform:uppercase; letter-spacing:1px;">
                Judul Laporan Barang
            </th>
        </tr>
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
            @php
                $rowspan = $barang->suppliers->count();
            @endphp

            @foreach ($barang->suppliers as $index => $supplier)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ $rowspan }}">{{ $barang->nama_barang }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $barang->stok }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    @endif

                    <td>{{ $supplier->nama_supplier }}</td>
                    <td>Rp{{ number_format($supplier->pivot->harga_beli, 0, ',', '.') }}</td>

                    @if ($index === 0)
                        <td rowspan="{{ $rowspan }}">
                            {{ \Carbon\Carbon::parse($barang->created_at)->translatedFormat('d F Y') }}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>