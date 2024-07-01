<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pb__finish_goods', function (Blueprint $table) {
            $table->id();
            $table->string('kode_costumer', 50)->unique();
            $table->string('kode_barang', 50);
            $table->string('nama_barang');
            $table->string('no_part', 50);
            $table->decimal('harga', 19, 2);
            $table->string('tipe_barang', 50);
            $table->timestamps();
        });

        Schema::create('pb__warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material', 50)->unique();
            $table->string('nama_material');
            $table->string('ukuran_material', 50);
            // $table->decimal('jumlah_material', 50);
            // $table->decimal('berat', 10, 2);
            $table->decimal('harga_material', 19, 2);
            $table->string('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pb__finish_goods');
        Schema::dropIfExists('pb__warehouses');
    }
};
