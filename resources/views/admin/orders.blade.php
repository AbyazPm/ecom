<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Admin TokoKu</title>
    
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

        <!-- SIDEBAR (Konsisten dengan Dashboard) -->
        <aside class="w-full md:w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold tracking-tight text-white hover:text-gray-200 transition">
                    <i class="fa-solid fa-store text-indigo-500"></i> TokoKu.
                </a>
            </div>
            
            <nav class="p-4 space-y-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    <i class="fa-solid fa-chart-line w-6 text-center"></i> Dashboard
                </a>
                
                <!-- Menu Aktif -->
                <a href="#" class="block px-4 py-2.5 bg-gray-800 text-white rounded-lg transition shadow-inner">
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
        <main class="flex-1 p-6 md:p-10 overflow-hidden">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Pesanan 📦</h1>
                    <p class="text-gray-500 mt-1">Pantau dan update status pesanan pelanggan.</p>
                </div>
            </div>

            <!-- Flash Message (Notifikasi) -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex items-center">
                <i class="fa-solid fa-circle-check text-green-500 mr-3"></i>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Table Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center w-16">No</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemesan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Harga</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center w-48">Update Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($orders as $i => $order)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <!-- No -->
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ $orders->firstItem() + $i }}
                                </td>
                                
                                <!-- Pemesan -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $order->nama_pemesan }}</div>
                                    <div class="text-xs text-gray-400">#INV-{{ $order->id }}</div>
                                </td>

                                <!-- Total -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-indigo-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                </td>

                                <!-- Tanggal -->
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y') }} <br>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                                </td>

                                <!-- Status Dropdown -->
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="relative">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="block w-full pl-3 pr-8 py-2 text-xs font-semibold rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm
                                                    {{ $order->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status == 'Dikirim' ? 'bg-cyan-100 text-cyan-800' : '' }}
                                                    {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status == 'Dibatalkan' ? 'bg-red-100 text-red-800' : '' }}">
                                                
                                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                                <option value="Dikirim" {{ $order->status == 'Dikirim' ? 'selected' : '' }}>🚚 Dikirim</option>
                                                <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                                <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                                            </select>
                                        </div>
                                    </form>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                        <i class="fa-solid fa-file-invoice mr-1.5 text-gray-400"></i> Invoice
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic bg-gray-50">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-2"></i>
                                        <p>Belum ada pesanan masuk.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-center">
                    {{ $orders->links() }}
                </div>
            </div>

        </main>
    </div>

</body>
</html>