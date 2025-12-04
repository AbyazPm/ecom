<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TokoKu</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- SIDEBAR -->
        <aside class="w-full md:w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold tracking-tight text-white hover:text-gray-200 transition">
                    <i class="fa-solid fa-store text-indigo-500"></i> TokoKu.
                </a>
            </div>
            
            <nav class="p-4 space-y-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
                
                <a href="#" class="block px-4 py-2.5 bg-gray-800 text-white rounded-lg transition">
                    <i class="fa-solid fa-chart-line w-6 text-center"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.orders') }}" class="block px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    <i class="fa-solid fa-box w-6 text-center"></i> Kelola Pesanan
                </a>

                <a href="{{ route('products.create') }}" class="block px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    <i class="fa-solid fa-plus w-6 text-center"></i> Tambah Produk
                </a>

                <a href="{{ route('reports.products') }}" class="block px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    <i class="fa-solid fa-file-invoice w-6 text-center"></i> Laporan
                </a>

                <div class="border-t border-gray-800 my-4 pt-4">
                    <a href="{{ route('home') }}" class="block px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                        <i class="fa-solid fa-arrow-left w-6 text-center"></i> Kembali ke Toko
                    </a>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-10">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-500 mt-1">Selamat datang kembali, Admin! 👋</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium text-gray-600 border border-gray-200">
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- Card 1: Pendapatan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <!-- Card 2: Pesanan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalPesanan }} <span class="text-sm text-gray-400 font-normal">Transaksi</span></h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xl">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>

                <!-- Card 3: Produk -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Produk</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalProduk }} <span class="text-sm text-gray-400 font-normal">Item</span></h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 text-xl">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                </div>

            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua →</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">ID Order</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pesananTerbaru as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-mono text-gray-500">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->nama_pemesan }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 text-xs font-medium border border-indigo-200 bg-indigo-50 px-3 py-1 rounded-full">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                                    Belum ada transaksi terbaru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>