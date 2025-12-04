<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk', 150);
            $table->unsignedBigInteger('harga')->default(0);
            $table->string('kategori', 100)->nullable();
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // path to storage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
