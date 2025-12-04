<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - TokoKu</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- NAVBAR (Minimalis untuk navigasi kembali) -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
                </div>
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition flex items-center gap-2">
                    <i class="fa-solid fa-store"></i> Lanjut Belanja
                </a>
            </div>
        </div>
    </nav>

    <!-- NOTIFIKASI -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
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

    <!-- MAIN CONTENT -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Pesanan 📦</h1>
                <p class="text-gray-500 text-sm mt-1">Pantau status pesanan dan unduh invoice Anda di sini.</p>
            </div>
            <!-- Tombol Balik di Mobile -->
            <div class="mt-4 sm:mt-0 sm:hidden">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">
                    Kembali Belanja
                </a>
            </div>
        </div>

        <!-- Tabel Card Wrapper -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center w-16">No</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Detail Pemesan</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Harga</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $i => $order)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <!-- No -->
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $orders->firstItem() + $i }}
                            </td>
                            
                            <!-- Nama -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $order->nama_pemesan }}</div>
                                <div class="text-xs text-gray-400">Order ID: #{{ $order->id }}</div>
                            </td>

                            <!-- Total Harga -->
                            <td class="px-6 py-4 text-right">
                                <div class="text-sm font-bold text-indigo-600">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </div>
                            </td>

                            <!-- Status (Badge Logic) -->
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusClass = '';
                                    $icon = '';
                                    switch($order->status) {
                                        case 'Pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                            $icon = 'fa-clock';
                                            break;
                                        case 'Diproses':
                                            $statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                            $icon = 'fa-spinner fa-spin';
                                            break;
                                        case 'Dikirim':
                                            $statusClass = 'bg-cyan-100 text-cyan-700 border-cyan-200';
                                            $icon = 'fa-truck-fast';
                                            break;
                                        case 'Selesai':
                                            $statusClass = 'bg-green-100 text-green-700 border-green-200';
                                            $icon = 'fa-check-circle';
                                            break;
                                        case 'Dibatalkan':
                                            $statusClass = 'bg-red-100 text-red-700 border-red-200';
                                            $icon = 'fa-times-circle';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                            $icon = 'fa-question-circle';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                    <i class="fa-solid {{ $icon }} mr-1.5"></i> {{ $order->status }}
                                </span>
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</span>
                            </td>

                            <!-- Aksi (Invoice) -->
                            <td class="px-6 py-4 text-center">
                                <!-- Asumsi route invoice adalah 'orders.show' atau 'orders.invoice' -->
                                <!-- Sesuaikan nama route dengan route invoice kamu -->
                                <a href="{{ route('orders.invoice', $order->id) }}" 
                                  class="inline-flex items-center justify-center p-2 bg-white border border-gray-300 rounded-lg text-gray-600 hover:text-indigo-600 hover:border-indigo-600 hover:bg-indigo-50 transition shadow-sm"
                                  title="Download Invoice">
                                    <i class="fa-solid fa-file-invoice text-lg"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-base font-medium text-gray-600">Belum ada riwayat transaksi.</p>
                                    <a href="{{ route('home') }}" class="mt-2 text-indigo-600 hover:underline text-sm">Mulai Belanja Sekarang</a>
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
    </div>

    <!-- Footer Simple -->
    <footer class="text-center py-8 text-gray-400 text-sm">
        &copy; {{ date('Y') }} TokoKu. All rights reserved.
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