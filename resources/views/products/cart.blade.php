<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - TokoOnline</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR (Sederhana untuk konteks) -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Lanjut Belanja
                </a>
            </div>
        </div>
    </nav>

    <!-- ALERT NOTIFIKASI -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session('success'))
        <div class="alert-fade bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm mb-4 flex items-center transition-opacity duration-1000">
            <i class="fa-solid fa-circle-check text-green-500 mr-3"></i>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-fade bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-4 flex items-center transition-opacity duration-1000">
            <i class="fa-solid fa-circle-exclamation text-red-500 mr-3"></i>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        @endif
    </div>

    <!-- KONTEN KERANJANG -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Keranjang Belanja 🛒</h1>

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- KOLOM KIRI: DAFTAR BARANG -->
                <div class="w-full lg:w-2/3 space-y-4">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['harga'] * $item['quantity']; $total += $subtotal; @endphp
                        
                        <!-- Item Card -->
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4 hover:shadow-md transition">
                            <!-- Foto Produk -->
                            <div class="w-full sm:w-24 h-24 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden">
                                <img src="{{ $item['foto'] ? asset('storage/'.$item['foto']) : 'https://via.placeholder.com/150?text=No+Image' }}" 
                                     class="w-full h-full object-cover">
                            </div>

                            <!-- Detail Produk -->
                            <div class="flex-1 w-full text-center sm:text-left">
                                <h3 class="text-lg font-bold text-gray-900">{{ $item['nama_produk'] }}</h3>
                                <p class="text-sm text-gray-500 mb-2">Harga Satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                
                                <div class="flex items-center justify-center sm:justify-start gap-4 mt-3">
                                    <!-- Badge Jumlah -->
                                    <span class="inline-flex items-center rounded-md bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                        Qty: {{ $item['quantity'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Harga & Hapus -->
                            <div class="text-center sm:text-right w-full sm:w-auto mt-4 sm:mt-0">
                                <p class="text-lg font-bold text-indigo-600 mb-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                
                                <a href="{{ route('cart.remove', $id) }}" 
                                   onclick="return confirm('Hapus produk ini dari keranjang?')"
                                   class="text-sm text-red-500 hover:text-red-700 font-medium inline-flex items-center transition">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- KOLOM KANAN: RINGKASAN BELANJA (Sticky) -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Ringkasan Belanja</h2>
                        
                        <div class="flex justify-between items-center mb-2 text-gray-600">
                            <span>Total Item</span>
                            <span>{{ count($cart) }} Barang</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-6 pt-4 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-900">Total Harga</span>
                            <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout.form') }}" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5 mb-3">
                            Checkout Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>

                        <a href="{{ route('home') }}" class="w-full block text-center bg-white border border-gray-300 text-gray-700 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 transition">
                            Lanjut Belanja
                        </a>

                        <div class="mt-4 text-xs text-center text-gray-400">
                            <i class="fa-solid fa-shield-halved mr-1"></i> Transaksi Aman & Terenkripsi
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- KONDISI KERANJANG KOSONG -->
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-indigo-50 text-indigo-200 mb-6">
                    <i class="fa-solid fa-cart-shopping text-5xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong 😅</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Wah, kelihatannya kamu belum menambahkan apapun. Yuk cari produk favoritmu!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-indigo-500/30 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </div>

    <!-- Footer Simple -->
    <footer class="text-center py-8 text-gray-400 text-sm mt-auto">
        &copy; {{ date('Y') }} Tokoku Official.
    </footer>

    <!-- Script Notifikasi Fade Out -->
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-fade');
            alerts.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 1000); // Hapus elemen setelah animasi selesai
            });
        }, 3000);
    </script>
</body>
</html>