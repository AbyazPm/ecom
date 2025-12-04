<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Modern E-commerce</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>


    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

{{-- ======================= ADMIN BAR ======================= --}}
@auth
@if(auth()->user()->is_admin)
<div class="bg-gray-900 text-white text-xs py-2 px-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <span class="font-bold">🔧 Admin Mode</span>

        <div class="space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-400">Dashboard</a>
            <a href="{{ route('products.create') }}" class="hover:text-indigo-400">Tambah Produk</a>
            <a href="{{ route('reports.products') }}" class="hover:text-indigo-400">Laporan</a>
        </div>
    </div>
</div>
@endif
@endauth

{{-- ======================= NAVBAR ======================= --}}
<nav class="bg-white sticky top-0 z-50 border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
            </div>

            {{-- Search --}}
            <div class="hidden md:flex flex-1 items-center justify-center px-8">
                <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-lg">
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="w-full border border-gray-300 rounded-full py-2 pl-4 pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Cari produk apa hari ini?">
                    <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            {{-- ICONS --}}
            <div class="flex items-center space-x-6">

                {{-- Wishlist --}}
                <a href="{{ route('wishlist.show') }}" class="text-gray-500 hover:text-pink-500 relative">
                    <i class="fa-regular fa-heart text-xl"></i>
                </a>

                {{-- Keranjang --}}
                <a href="{{ route('cart.show') }}" class="text-gray-500 hover:text-indigo-600 relative">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </a>

                {{-- USER DROPDOWN FIXED (CLICK TO OPEN) --}}
                @auth
                <div class="relative" x-data="{ open: false }">

                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                        <img class="h-8 w-8 rounded-full border"
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random">
                        <span class="hidden md:block">Halo, {{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 bg-white shadow-md rounded-lg w-40 py-1 z-50">

                        {{-- Pesanan --}}
                        <a href="{{ route('orders.list') }}"
                            class="block px-4 py-2 hover:bg-gray-100 text-sm">
                            📦 Pesanan Saya
                        </a>

                        {{-- Logout --}}
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-red-600">
                                Logout
                            </button>
                        </form>

                    </div>
                </div>
                @endauth


            </div>

        </div>
    </div>
</nav>

{{-- ======================= HALAMAN UTAMA ======================= --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Judul --}}
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Katalog Produk</h1>
    <p class="text-gray-500 text-sm mb-6">Menampilkan semua produk terbaru</p>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ======================= SIDEBAR FILTER ======================= --}}
        <div class="w-full lg:w-1/4">
            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm sticky top-24">

                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Filter</h3>

                <form action="{{ route('home') }}" method="GET">

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm">
                            <option value="">Semua Kategori</option>
                            <option value="Elektronik" {{ request('kategori')=='Elektronik'?'selected':'' }}>Elektronik</option>
                            <option value="Fashion" {{ request('kategori')=='Fashion'?'selected':'' }}>Fashion</option>
                            <option value="Makanan" {{ request('kategori')=='Makanan'?'selected':'' }}>Makanan</option>
                        </select>
                    </div>

                    {{-- Harga --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>

                        <div class="flex items-center space-x-3">
                            <input type="number" name="min_harga" value="{{ request('min_harga') }}"
                                   placeholder="Min"
                                   class="w-full border-gray-300 p-2 rounded-md text-sm">
                            <span>-</span>
                            <input type="number" name="max_harga" value="{{ request('max_harga') }}"
                                   placeholder="Max"
                                   class="w-full border-gray-300 p-2 rounded-md text-sm">
                        </div>
                    </div>

                    {{-- Tombol Filter --}}
                    <button class="w-full bg-indigo-600 text-white py-2 rounded-md text-sm hover:bg-indigo-700">
                        Terapkan Filter
                    </button>

                    {{-- Reset --}}
                    @if(request()->hasAny(['q','kategori','min_harga','max_harga']))
                    <a href="{{ route('home') }}"
                       class="block text-center text-gray-500 text-sm mt-2 hover:text-gray-700">
                        Reset Filter
                    </a>
                    @endif

                </form>

            </div>
        </div>

        {{-- ======================= PRODUK GRID ======================= --}}
        <div class="w-full lg:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($products as $p)

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition overflow-hidden">

                    <div class="relative">
                        <img src="{{ $p->foto ? asset('storage/'.$p->foto) : 'https://via.placeholder.com/250x180?text=No+Image' }}"
                             class="w-full h-56 object-cover">

                        {{-- Stock Badge --}}
                        @if($p->stok > 0)
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">Ready Stock</span>
                        @else
                            <span class="absolute top-2 left-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded">Stok Habis</span>
                        @endif

                        {{-- Wishlist --}}
                        <form action="{{ route('wishlist.add',$p->id) }}" method="POST"
                              class="absolute top-2 right-2">
                            @csrf
                            <button class="bg-white/80 p-2 rounded-full text-gray-400 hover:text-pink-500 shadow-sm">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </form>
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-indigo-500 font-semibold mb-1">{{ $p->kategori }}</p>

                        <h3 class="text-gray-900 font-bold text-lg mb-1 truncate">
                            {{ $p->nama_produk }}
                        </h3>

                        <p class="text-gray-900 font-bold mb-2">
                            Rp {{ number_format($p->harga,0,',','.') }}
                        </p>

                        {{-- Tambah Keranjang --}}
                        @if($p->stok > 0)
                        <form action="{{ route('cart.add',$p->id) }}" method="POST">
                            @csrf
                            <button class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> Tambah
                            </button>
                        </form>
                        @else
                        <button disabled class="w-full bg-gray-200 text-gray-400 py-2 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                        @endif

                        {{-- Detail --}}
                        <a href="{{ route('product.show',$p->id) }}"
                           class="block text-center mt-2 text-sm text-gray-700 hover:text-indigo-600">
                           Detail Produk
                        </a>

                        {{-- Admin --}}
                        @auth
                        @if(auth()->user()->is_admin)
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('products.edit',$p->id) }}" class="flex-1 bg-orange-500 text-white py-2 rounded-lg text-center">Edit</a>
                            <a href="{{ route('products.destroy',$p->id) }}"
                               onclick="return confirm('Hapus produk ini?')"
                               class="flex-1 bg-red-600 text-white py-2 rounded-lg text-center">Hapus</a>
                        </div>
                        @endif
                        @endauth

                    </div>
                </div>

                @empty
                <p class="text-center text-gray-500 col-span-full">Tidak ada produk ditemukan.</p>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>

        </div>

    </div>

</div>

</body>
</html>
