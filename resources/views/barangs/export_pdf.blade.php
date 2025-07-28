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
            background-color: #ffffff;
            color: #333;
            margin: 40px;
        }

        h2 {
            text-align: center;
            color: #d63031;
            text-transform: uppercase;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        th {
            background-color: #d63031;
            color: #fff;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            border-top: 1px solid #ccc;
            border-bottom: 2px solid #c0392b;
        }

        td {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 10px;
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        td, th {
            border-left: 1px solid #eee;
        }

        td:first-child, th:first-child {
            border-left: none;
        }

        tr:last-child td {
            border-bottom: 2px solid #dcdcdc;
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
                    <td>{{ \Carbon\Carbon::parse($barang->created_at)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
