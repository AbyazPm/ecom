<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk', 'harga', 'kategori', 'stok', 'deskripsi', 'foto'
    ];
    
    public function images()
{
    return $this->hasMany(ProductImage::class);
}

}
