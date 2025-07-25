<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            background-color: #ffffff;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #c0392b; /* merah tua */
            text-transform: uppercase;
            margin-bottom: 20px;
            text-shadow: 1px 1px 1px #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #e74c3c; /* merah */
            color: #fff;
            padding: 10px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #fdf5f5;
        }
    </style>
</head>
<body>
    <h2>Laporan Barang</h2>

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
                    @foreach($barang->suppliers as $s)
                        {{ $s->nama_supplier }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($barang->suppliers as $s)
                        Rp{{ number_format($s->pivot->harga_beli, 0, ',', '.') }}<br>
                    @endforeach
                </td>
                <td>{{ \Carbon\Carbon::parse($barang->created_at)->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
