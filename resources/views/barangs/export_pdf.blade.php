<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: #2c2c2c;
            background-color: #fff;
            margin: 30px;
        }

        h2 {
            text-align: center;
            color: #e74c3c;
            font-size: 22px;
            text-transform: uppercase;
            margin-bottom: 25px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }

        thead {
            background-color: #e74c3c;
            color: #fff;
        }

        th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #fff6f5;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffeceb;
        }

        td img {
            width: 60px;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
            box-shadow: 0 2px 6px rgba(231, 76, 60, 0.2);
        }

        .text-muted {
            color: #7f8c8d;
            font-style: italic;
            text-align: center;
        }

        .supplier, .harga {
            font-size: 11px;
            line-height: 1.4;
        }

        @media print {
            body {
                margin: 0;
            }

            table {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <h2>Laporan Barang</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Ditambahkan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>
                        @if ($barang->gambar && file_exists(public_path('storage/' . $barang->gambar)))
                            <img src="{{ public_path('storage/' . $barang->gambar) }}">
                        @else
                            <div class="text-muted">No Image</div>
                        @endif
                    </td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    <td class="supplier">
                        @foreach ($barang->suppliers as $s)
                            • {{ $s->nama_supplier }}<br>
                        @endforeach
                    </td>
                    <td class="harga">
                        @foreach ($barang->suppliers as $s)
                            Rp{{ number_format($s->pivot->harga_beli, 0, ',', '.') }}<br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($barang->created_at)->translatedFormat('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
