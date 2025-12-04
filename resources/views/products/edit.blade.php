<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin Panel</title>
    
    <!-- CDN Tailwind & FontAwesome & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <!-- ADMIN HEADER -->
    <div class="bg-gray-900 text-white py-4 shadow-md">
        <div class="max-w-4xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-layer-group text-yellow-500 text-xl"></i>
                <h1 class="font-bold text-lg tracking-wide">Admin Panel <span class="text-gray-500 text-sm font-normal">| Edit Mode</span></h1>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-store mr-1"></i> Lihat Toko
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-4xl mx-auto px-6 py-10">
        
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Produk ✏️</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi produk: <span class="font-semibold text-indigo-600">{{ $product->nama_produk }}</span></p>
            </div>
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm transition flex items-center bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8">
                
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT') <!-- Penting untuk Update di Laravel Resource -->

                    <!-- 1. Informasi Dasar -->
                    <div class="space-y-6">
                        <h3 class="text-yellow-600 font-bold border-b border-yellow-100 pb-2 mb-4 uppercase text-xs tracking-wider">
                            <i class="fa-regular fa-file-lines mr-1"></i> Informasi Dasar
                        </h3>
                        
                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5 px-4 border transition">
                        </div>

                        <!-- Grid: Harga & Stok & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Harga -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm font-bold">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required
                                           class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5 px-4 border transition">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                                <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5 px-4 border transition">
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5 px-4 border transition">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="5"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5 px-4 border transition">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        </div>
                    </div>

                    <!-- 2. Media / Foto -->
                    <div class="pt-8 space-y-6">
                        <h3 class="text-yellow-600 font-bold border-b border-yellow-100 pb-2 mb-4 uppercase text-xs tracking-wider">
                            <i class="fa-regular fa-images mr-1"></i> Media & Gambar
                        </h3>
                        
                        <!-- Foto Utama (Upload + Preview) -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Foto Utama Produk</label>
                            <div class="flex flex-col sm:flex-row gap-4 items-start">
                                <!-- Preview Foto Lama -->
                                @if($product->foto)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/'.$product->foto) }}" alt="Foto Lama" class="w-32 h-32 object-cover rounded-lg shadow-sm border border-gray-300">
                                        <div class="absolute inset-0 bg-black/50 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-white text-xs">
                                            Foto Saat Ini
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Input Upload Baru -->
                                <div class="w-full">
                                    <input type="file" name="foto" accept="image/*"
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-yellow-100 file:text-yellow-700
                                                  hover:file:bg-yellow-200 transition cursor-pointer mb-2">
                                    <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto utama.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Foto Tambahan (Upload) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto Tambahan Baru</label>
                            <input type="file" name="foto_tambahan[]" multiple
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-gray-200 file:text-gray-700
                                          hover:file:bg-gray-300 transition cursor-pointer">
                        </div>

                        <!-- Grid Foto Tambahan (Hapus) -->
                        @if($product->images && count($product->images) > 0)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Kelola Foto Tambahan (Centang untuk Hapus)</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative bg-white border border-gray-200 rounded-lg p-2 shadow-sm hover:shadow-md transition">
                                            <img src="{{ asset('storage/' . $image->path_image) }}" 
                                                 class="w-full h-24 object-cover rounded-md mb-2">
                                            
                                            <label class="flex items-center justify-center space-x-2 cursor-pointer p-1 rounded hover:bg-red-50 transition w-full">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" 
                                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                                <span class="text-xs font-bold text-red-500">Hapus</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-lg text-gray-700 font-medium hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-yellow-500 text-white font-bold rounded-lg shadow-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-check mr-2"></i> Perbarui Produk
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