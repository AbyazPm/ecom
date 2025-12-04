<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $samples = [
            ['nama_produk'=>'Sepatu Casual', 'harga'=>150000, 'kategori'=>'Fashion', 'stok'=>10, 'deskripsi'=>'Sepatu nyaman untuk sehari-hari.','foto'=>null],
            ['nama_produk'=>'Kaos Polos', 'harga'=>50000, 'kategori'=>'Fashion', 'stok'=>50, 'deskripsi'=>'Kaos katun 100%.','foto'=>null],
            ['nama_produk'=>'Headset Gaming', 'harga'=>250000, 'kategori'=>'Elektronik', 'stok'=>8, 'deskripsi'=>'Headset stereo dengan mic.','foto'=>null],
            ['nama_produk'=>'Kamera Aksi', 'harga'=>750000, 'kategori'=>'Elektronik', 'stok'=>3, 'deskripsi'=>'Kamera kecil untuk vlogging.','foto'=>null],
            ['nama_produk'=>'Botol Minum', 'harga'=>45000, 'kategori'=>'Home', 'stok'=>20, 'deskripsi'=>'Botol stainless steel.','foto'=>null],
            ['nama_produk'=>'Buku Pemrograman', 'harga'=>120000, 'kategori'=>'Buku', 'stok'=>15, 'deskripsi'=>'Belajar Laravel dari dasar.','foto'=>null],
        ];

        foreach ($samples as $s) {
            Product::create($s);
        }
    }
}
