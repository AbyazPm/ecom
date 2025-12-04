<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_produk }} | TokoKu</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Transisi halus untuk gambar */
        .fade-enter { opacity: 0; }
        .fade-enter-active { opacity: 1; transition: opacity 300ms ease-in; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- NAVBAR SIMPLE -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.show') }}" class="text-gray-500 hover:text-indigo-600 relative">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                    </a>
                    @auth
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- BREADCRUMB -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-2">/</span>
            <span class="hover:text-indigo-600 cursor-pointer">{{ $product->kategori ?? 'Umum' }}</span>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $product->nama_produk }}</span>
        </nav>
    </div>

    <!-- MAIN PRODUCT CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-20">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            
            <!-- KOLOM KIRI: GALERI GAMBAR -->
            <div class="flex flex-col-reverse">
                
                <!-- Thumbnails Slider -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-4" id="galleryContainer">
                        <!-- Thumbnail Foto Utama (Manual Add) -->
                        <button class="thumb active relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4 ring-indigo-500 ring-2 ring-offset-2"
                                onclick="changeImage(this, '{{ $product->foto ? asset('storage/'.$product->foto) : 'https://via.placeholder.com/500?text=No+Image' }}')">
                            <span class="sr-only">Foto Utama</span>
                            <span class="absolute inset-0 rounded-md overflow-hidden">
                                <img src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://via.placeholder.com/500?text=No+Image' }}" alt="" class="w-full h-full object-center object-cover">
                            </span>
                        </button>

                        <!-- Loop Foto Tambahan -->
                        @foreach($product->images as $img)
                        <button class="thumb relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4 ring-transparent"
                                onclick="changeImage(this, '{{ asset('storage/' . $img->path_image) }}')">
                            <span class="sr-only">Foto Tambahan</span>
                            <span class="absolute inset-0 rounded-md overflow-hidden">
                                <img src="{{ asset('storage/' . $img->path_image) }}" alt="" class="w-full h-full object-center object-cover">
                            </span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Main Image Display -->
                <div class="w-full aspect-w-1 aspect-h-1 bg-gray-100 rounded-2xl overflow-hidden shadow-sm relative group">
                    <img id="mainImage" 
                         src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://via.placeholder.com/500?text=No+Image' }}" 
                         alt="{{ $product->nama_produk }}" 
                         class="w-full h-[400px] lg:h-[500px] object-center object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    <!-- Badge Kategori -->
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                        {{ $product->kategori ?? 'Produk' }}
                    </span>
                </div>
            </div>

            <!-- KOLOM KANAN: INFO PRODUK -->
            <div class="mt-10 px-2 sm:px-0 sm:mt-16 lg:mt-0 sticky top-24">
                
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->nama_produk }}</h1>
                
                <div class="mt-3 flex items-end">
                    <p class="text-3xl text-indigo-600 font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                </div>

                <!-- Status Stok -->
                <div class="mt-4 flex items-center">
                    @if($product->stok > 0)
                        <i class="fa-solid fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-500">Stok Tersedia: <span class="text-gray-900">{{ $product->stok }}</span></span>
                    @else
                        <i class="fa-solid fa-circle-xmark text-red-500 mr-2"></i>
                        <span class="text-sm font-medium text-red-500">Stok Habis</span>
                    @endif
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Description</h3>
                    <div class="text-base text-gray-700 space-y-6 leading-relaxed">
                        <p>{{ $product->deskripsi }}</p>
                    </div>
                </div>

                <!-- Garansi & Info Tambahan -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <i class="fa-solid fa-truck-fast text-gray-400 mr-3 text-lg"></i>
                            <span class="text-sm text-gray-500">Pengiriman Cepat</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-shield-halved text-gray-400 mr-3 text-lg"></i>
                            <span class="text-sm text-gray-500">Jaminan Original</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    @if($product->stok > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-xl py-4 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                <i class="fa-solid fa-cart-plus mr-2"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-200 border border-transparent rounded-xl py-4 px-8 flex items-center justify-center text-base font-medium text-gray-500 cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif

                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-white border border-gray-300 rounded-xl py-4 px-6 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-pink-500 transition shadow-sm" title="Simpan ke Wishlist">
                            <i class="fa-regular fa-heart text-xl"></i>
                        </button>
                    </form>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ url()->previous() }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium flex items-center justify-center gap-1">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Sebelumnya
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} TokoKu Official.</p>
        </div>
    </footer>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumb');
        let currentIndex = 0;
        let slideInterval;

        // Fungsi Ganti Gambar saat klik
        function changeImage(element, src) {
            // Reset semua active state
            thumbnails.forEach(t => {
                t.classList.remove('ring-indigo-500', 'ring-2', 'ring-offset-2');
                t.classList.add('ring-transparent');
            });

            // Set active state ke elemen yang diklik
            element.classList.remove('ring-transparent');
            element.classList.add('ring-indigo-500', 'ring-2', 'ring-offset-2');

            // Ganti Source Gambar Utama dengan efek fade sederhana
            mainImage.style.opacity = '0.5';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 150);

            // Update index untuk auto slide
            // Mencari index dari element yang diklik dalam NodeList thumbnails
            currentIndex = Array.from(thumbnails).indexOf(element);
            
            // Reset timer auto slide agar tidak "bentrok" saat user klik manual
            resetTimer();
        }

        // Fungsi Auto Slide
        function autoSlide() {
            if (thumbnails.length > 1) {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                // Simulasi klik pada thumbnail berikutnya
                thumbnails[currentIndex].click();
            }
        }

        function startTimer() {
            slideInterval = setInterval(autoSlide, 3000); // Ganti gambar tiap 3 detik
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        // Jalankan timer saat halaman muat
        window.onload = startTimer;

        // Optional: Pause saat mouse hover di gambar utama
        mainImage.addEventListener('mouseenter', () => clearInterval(slideInterval));
        mainImage.addEventListener('mouseleave', startTimer);

    </script>

</body>
</html>