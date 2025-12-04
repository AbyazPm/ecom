<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya | TokoKu</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- NAVBAR SIMPLE -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                    <a href="{{ route('cart.show') }}" class="text-gray-500 hover:text-indigo-600 relative">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- NOTIFIKASI -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session('success'))
        <div class="alert-fade bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm mb-4 flex items-center transition-opacity duration-1000">
            <i class="fa-solid fa-circle-check text-green-500 mr-3"></i>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    Wishlist Saya <i class="fa-solid fa-heart text-pink-500 animate-pulse"></i>
                </h1>
                <p class="text-gray-500 text-sm mt-1">Simpan barang impianmu di sini sebelum kehabisan.</p>
            </div>
            <span class="bg-pink-100 text-pink-600 text-xs font-bold px-3 py-1 rounded-full">
                {{ count($wishlist) }} Item
            </span>
        </div>

        <!-- PRODUCT GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($wishlist as $w)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 group overflow-hidden flex flex-col h-full relative">
                    
                    <!-- Hapus Button (Absolute Top Right) -->
                    <a href="{{ route('wishlist.remove', $w->product->id) }}" 
                       onclick="return confirm('Hapus produk ini dari wishlist?')"
                       class="absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/80 hover:bg-red-50 text-gray-400 hover:text-red-500 shadow-sm flex items-center justify-center transition"
                       title="Hapus dari Wishlist">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>

                    <!-- Image Section -->
                    <a href="{{ route('product.show', $w->product->id) }}" class="relative h-48 overflow-hidden bg-gray-100 block">
                        <img src="{{ $w->product->foto ? asset('storage/'.$w->product->foto) : 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                             alt="{{ $w->product->nama_produk }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        
                        @if($w->product->stok <= 0)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded shadow-sm">Stok Habis</span>
                            </div>
                        @endif
                    </a>

                    <!-- Content Section -->
                    <div class="p-4 flex-1 flex flex-col">
                        <div class="mb-2">
                            <p class="text-xs text-gray-500 mb-1">{{ $w->product->kategori ?? 'Umum' }}</p>
                            <a href="{{ route('product.show', $w->product->id) }}" class="text-base font-bold text-gray-900 hover:text-indigo-600 line-clamp-1 transition">
                                {{ $w->product->nama_produk }}
                            </a>
                        </div>
                        
                        <p class="text-lg font-bold text-indigo-600 mb-4">Rp {{ number_format($w->product->harga,0,',','.') }}</p>

                        <!-- Action Buttons -->
                        <div class="mt-auto flex flex-col gap-2">
                            @if($w->product->stok > 0)
                                <form action="{{ route('cart.add', $w->product->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus"></i> + Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-100 text-gray-400 text-sm font-medium py-2 rounded-lg cursor-not-allowed border border-gray-200">
                                    Stok Habis
                                </button>
                            @endif
                            
                            <a href="{{ route('product.show', $w->product->id) }}" class="w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium py-2 rounded-lg transition text-center">
                                Detail Produk
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-heart-crack text-4xl text-pink-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Wishlist Masih Kosong</h3>
                    <p class="text-gray-500 mb-6 max-w-sm">Sepertinya kamu belum menyimpan barang impianmu. Yuk mulai jelajahi katalog kami!</p>
                    <a href="{{ route('home') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition shadow-md hover:shadow-indigo-500/30">
                        Cari Produk Sekarang
                    </a>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-gray-200 mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} TokoKu Official.</p>
        </div>
    </footer>

    <!-- Script Notifikasi Fade Out -->
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-fade');
            alerts.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 1000); 
            });
        }, 3000);
    </script>

</body>
</html>