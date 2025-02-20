<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Faktur Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
        }

        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
        }

        .print-btn {
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h1>Faktur Pembelian</h1>
        <p>Nomor Invoice: <strong>{{ $invoiceNumber }}</strong></p>
        <p>Nama Pemesan: {{ $userName }}</p>
        <p>Alamat Pengiriman: {{ $shippingAddress }}</p>
        <p>Kode Pos: {{ $postalCode }}</p>

        <h2>Detail Pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>

        <div class="print-btn">
            <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded">Cetak Faktur</button>
        </div>
    </div>
</body>

</html>
