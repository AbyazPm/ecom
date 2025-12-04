<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TokoOnline</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR KHUSUS CHECKOUT (Minimalis) -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Toko<span class="text-gray-900">Ku.</span></a>
                    <span class="text-gray-300 text-2xl font-light">|</span>
                    <span class="text-gray-500 font-medium flex items-center gap-2">
                        <i class="fa-solid fa-lock text-green-500"></i> Secure Checkout
                    </span>
                </div>
                <a href="{{ route('cart.show') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Keranjang
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- KOLOM KIRI: FORM PENGIRIMAN -->
            <div class="w-full md:w-2/3">
                <!-- Progress Step (Visual) -->
                <div class="flex items-center mb-8 text-sm font-medium text-gray-400">
                    <span class="text-indigo-600 flex items-center gap-2"><div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs">1</div> Keranjang</span>
                    <div class="h-px w-8 bg-gray-300 mx-2"></div>
                    <span class="text-indigo-600 flex items-center gap-2"><div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs">2</div> Pengiriman</span>
                    <div class="h-px w-8 bg-gray-300 mx-2"></div>
                    <span class="flex items-center gap-2"><div class="w-6 h-6 rounded-full border border-gray-300 text-gray-400 flex items-center justify-center text-xs">3</div> Selesai</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-900">Informasi Pengiriman 🚚</h2>
                        <p class="text-sm text-gray-500">Lengkapi detail alamat pengiriman Anda.</p>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Grid Nama & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama (Readonly) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemesan</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-regular fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" name="nama_pemesan" value="{{ $user->name }}" 
                                               class="pl-10 block w-full bg-gray-100 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-300 sm:text-sm" 
                                               readonly>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">*Sesuai nama akun Anda</p>
                                </div>

                                <!-- Email (Readonly) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-regular fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ $user->email }}" 
                                               class="pl-10 block w-full bg-gray-100 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-300 sm:text-sm" 
                                               readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No HP / WhatsApp <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="text" name="no_hp" required placeholder="Contoh: 08123456789"
                                           class="pl-10 block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2.5 transition">
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <i class="fa-solid fa-map-location-dot text-gray-400"></i>
                                    </div>
                                    <textarea name="alamat" rows="4" required placeholder="Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan, Kode Pos..."
                                              class="pl-10 block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2.5 transition"></textarea>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="pt-4">
                                <button type="submit" class="w-full flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                                    <i class="fa-regular fa-paper-plane mr-2"></i> Proses Pesanan Sekarang
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-4">
                                    <i class="fa-solid fa-shield-halved mr-1"></i> Data Anda dienkripsi dan aman.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: INFO TAMBAHAN (Visual) -->
            <div class="w-full md:w-1/3 space-y-6">
                
                <!-- Info Box -->
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5">
                    <h3 class="text-indigo-800 font-bold mb-2">Mengapa belanja di sini?</h3>
                    <ul class="space-y-3 text-sm text-indigo-700">
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle mt-0.5 mr-2"></i>
                            <span>Barang Original & Berkualitas</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle mt-0.5 mr-2"></i>
                            <span>Pengiriman Cepat & Aman</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle mt-0.5 mr-2"></i>
                            <span>Garansi Uang Kembali</span>
                        </li>
                    </ul>
                </div>

                <!-- Bantuan -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 text-green-600">
                        <i class="fa-brands fa-whatsapp text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-500 mb-3">Hubungi CS kami jika ada kendala.</p>
                    <a 
                        href="https://wa.me/6281252789292" 
                        target="_blank"
                        class="inline-block text-green-600 font-bold hover:underline text-sm">
                        Chat WhatsApp
                    </a>

                </div>

            </div>
        </div>
    </div>

    <footer class="text-center py-8 text-gray-400 text-sm border-t border-gray-200 mt-10">
        &copy; {{ date('Y') }} Tokoku Official.
    </footer>

</body>
</html>