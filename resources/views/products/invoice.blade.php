<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
        }

        .header {
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #4F46E5;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .info-box {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fafafa;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .info-label {
            color: #777;
            font-size: 13px;
        }

        .info-value {
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #4F46E5;
            color: white;
            padding: 10px;
            font-size: 14px;
        }

        td {
            border-bottom: 1px solid #e5e5e5;
            padding: 10px;
            font-size: 13px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .total-box {
            margin-top: 25px;
            padding: 15px;
            background: #EEF2FF;
            border: 1px solid #C7D2FE;
            border-radius: 10px;
        }

        .total-label {
            font-size: 16px;
            font-weight: bold;
            color: #4338CA;
        }

        .total-amount {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 35px;
            font-size: 12px;
            color: #777;
        }

        .thankyou {
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            color: #4F46E5;
            font-weight: bold;
        }

    </style>
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>INVOICE</h1>
        <div>
            <p><strong>TokoKu</strong></p>
            <p>Invoice #: {{ $order->id }}</p>
            <p>Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <!-- Info Pemesan -->
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nama Pemesan</div>
            <div class="info-value">{{ $order->nama_pemesan }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $order->email ?? '-' }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-value">{{ $order->alamat }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">No HP</div>
            <div class="info-value">{{ $order->no_hp }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">{{ $order->status }}</div>
        </div>
    </div>

    <!-- Table Pesanan -->
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->nama_produk }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->harga_satuan,0,',','.') }}</td>
                <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <div class="total-box">
        <div class="total-label">Total Pembayaran:</div>
        <div class="total-amount">
            Rp {{ number_format($order->total_harga,0,',','.') }}
        </div>
    </div>

    <!-- Thanks Message -->
    <div class="thankyou">
        Terima kasih telah berbelanja di TokoKu 💙  
    </div>

    <!-- Footer -->
    <div class="footer">
        Invoice ini dibuat otomatis dan sah tanpa tanda tangan.
    </div>

</div>

</body>
</html>
