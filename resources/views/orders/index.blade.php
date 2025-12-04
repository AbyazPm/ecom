<!DOCTYPE html>
<html>
<head>
  <title>Riwayat Pesanan</title>
</head>
<body style="background:#f5f5f5; padding:20px;">

<h2 style="text-align:center;">📦 Riwayat Pesanan</h2>

<div style="max-width:800px; margin:auto;">
  @foreach($orders as $order)
    <div style="background:white; padding:15px; margin-bottom:15px; border-radius:10px;">
      <p><strong>ID Pesanan:</strong> #{{ $order->id }}</p>
      <p><strong>Total:</strong> Rp {{ number_format($order->total,0,',','.') }}</p>
      <p><strong>Status:</strong> {{ $order->status }}</p>
      <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
    </div>
  @endforeach

  <div style="text-align:center;">
      {{ $orders->links() }}
  </div>
</div>

</body>
</html>
