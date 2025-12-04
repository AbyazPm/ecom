<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama_pemesan');
        $table->string('email')->nullable();
        $table->string('alamat');
        $table->string('no_hp')->nullable();
        $table->integer('total_harga');
        $table->timestamps();
    });
}



    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
