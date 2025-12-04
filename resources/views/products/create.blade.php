<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin Panel</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <!-- ADMIN HEADER (Simple) -->
    <div class="bg-gray-900 text-white py-4 shadow-md">
        <div class="max-w-4xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-layer-group text-indigo-400 text-xl"></i>
                <h1 class="font-bold text-lg tracking-wide">Admin Panel</h1>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-store mr-1"></i> Lihat Toko
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-4xl mx-auto px-6 py-10">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Produk Baru 📦</h2>
                <p class="text-sm text-gray-500 mt-1">Isi informasi produk dengan lengkap.</p>
            </div>
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm transition flex items-center bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left mr-2"></i> Batal / Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8">
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Informasi Dasar -->
                    <div class="space-y-6">
                        <h3 class="text-indigo-600 font-bold border-b border-indigo-50 pb-2 mb-4 uppercase text-xs tracking-wider">Informasi Dasar</h3>
                        
                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 border transition"
                                   placeholder="Contoh: Sepatu Sneakers Putih">
                        </div>

                        <!-- Grid: Harga & Stok & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <!-- Harga -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm font-bold">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga') }}" required
                                           class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 border transition"
                                           placeholder="0">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                                <input type="number" name="stok" value="{{ old('stok') }}" required
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 border transition"
                                       placeholder="Jumlah barang">
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 border transition"
                                       placeholder="Misal: Elektronik">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="5"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 border transition"
                                      placeholder="Jelaskan detail produk, spesifikasi, dan keunggulan...">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>

                    <!-- 2. Media / Foto -->
                    <div class="pt-6 space-y-6">
                        <h3 class="text-indigo-600 font-bold border-b border-indigo-50 pb-2 mb-4 uppercase text-xs tracking-wider">Media & Gambar</h3>
                        
                        <!-- Foto Utama -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Utama Produk</label>
                            <input type="file" name="foto" accept="image/*"
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-100 file:text-indigo-700
                                          hover:file:bg-indigo-200 transition cursor-pointer">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maks 2MB.</p>
                        </div>

                        <!-- Foto Tambahan -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Galeri Tambahan (Opsional)</label>
                            <input type="file" name="foto_tambahan[]" multiple
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-gray-200 file:text-gray-700
                                          hover:file:bg-gray-300 transition cursor-pointer">
                            <p class="mt-1 text-xs text-gray-500">Bisa pilih lebih dari 1 foto sekaligus.</p>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-lg text-gray-700 font-medium hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Produk
                        </button>
                    </div>

                </form>
            </div>
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Admin System.
        </div>

    </div>

</body>
</html>