<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - TokoKu</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #525659; } /* Background gelap ala PDF Viewer */
        
        /* CSS Khusus Cetak */
        @media print {
            body { background-color: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-container { 
                box-shadow: none !important; 
                margin: 0 !important; 
                width: 100% !important; 
                max-width: 100% !important;
                padding: 0 !important;
            }
            /* Memaksa background warna (header tabel) tetap muncul saat print */
            th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body class="py-10 px-4">

    <!-- NAVIGATION BAR (Hilang saat diprint) -->
    <div class="no-print max-w-[210mm] mx-auto mb-6 flex justify-between items-center bg-gray-800 text-white p-4 rounded-lg shadow-lg">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-gray-300 transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <span class="text-gray-500">|</span>
            <span class="font-semibold">Laporan Penjualan</span>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded shadow-md transition font-bold flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- KERTAS LAPORAN (Ukuran A4) -->
    <div class="print-container bg-white w-full max-w-[210mm] min-h-[297mm] mx-auto p-[15mm] shadow-2xl relative">
        
        <!-- Header Laporan -->
        <div class="border-b-2 border-gray-800 pb-6 mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 uppercase tracking-wide">Laporan Penjualan</h1>
                <p class="text-gray-500 mt-1">TokoKu Official Store</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Tanggal Cetak:</p>
                <p class="font-bold text-gray-900 text-lg">{{ now()->format('d F Y') }}</p>
                <p class="text-sm text-gray-500">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>

        <!-- Ringkasan (Summary Cards) -->
        <!-- Menghitung Total secara manual di View karena Controller tidak diubah -->
        @php
            $totalPendapatan = 0;
            foreach($orders as $o) {
                $totalPendapatan += $o->total_harga;
            }
        @endphp

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                <p class="text-2xl font-bold text-indigo-600">{{ count($orders) }} <span class="text-sm text-gray-400 font-normal">Pesanan</span></p>
            </div>
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="w-full border-collapse mb-8">
            <thead>
                <tr class="bg-gray-800 text-white text-xs uppercase font-bold tracking-wider text-left">
                    <th class="p-3 w-12 text-center">No</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Nama Pemesan</th>
                    <th class="p-3">Email</th>
                    <th class="p-3 text-right">Total (Rp)</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-200 border-b border-gray-200">
                @forelse($orders as $i => $order)
                <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="p-3 text-center font-medium">{{ $i + 1 }}</td>
                    <td class="p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="p-3 font-bold text-gray-900">{{ $order->nama_pemesan }}</td>
                    <td class="p-3 text-gray-500">{{ $order->email ?? '-' }}</td>
                    <td class="p-3 text-right font-mono font-medium">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400 italic bg-gray-50">
                        Tidak ada data penjualan untuk ditampilkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <!-- Footer Tabel (Grand Total) -->
            <tfoot>
                <tr class="bg-gray-100 font-bold text-gray-900">
                    <td colspan="4" class="p-3 text-right uppercase text-xs tracking-wider">Grand Total</td>
                    <td class="p-3 text-right font-mono text-lg">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Tanda Tangan (Area Footer) -->
        <div class="mt-16 flex justify-end page-break-inside-avoid">
            <div class="text-center w-48">
                <p class="mb-16 text-sm text-gray-600">Mengetahui,<br>Manager Toko</p>
                <div class="border-b border-gray-400 w-full mb-2"></div>
                <p class="font-bold text-gray-900">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</p>
            </div>
        </div>

        <!-- Copyright Kecil -->
        <div class="absolute bottom-10 left-0 w-full text-center">
            <p class="text-[10px] text-gray-400">Dokumen ini dicetak otomatis oleh sistem pada {{ now() }}.</p>
        </div>

    </div>

</body>
</html>