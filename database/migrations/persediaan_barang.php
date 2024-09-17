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
            // $table->string('kode_costumer', 50)->unique();
            $table->string('kode_barang', 50);
            $table->string('nama_barang', 200);
            $table->string('no_part', 50);
            $table->integer('stok_material')->default(0);
            $table->decimal('harga', 19);
            $table->string('tipe_barang', 20);
            $table->timestamps();
        });

        Schema::create('pb__warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material', 50)->unique();
            $table->string('nama_material');
            $table->string('ukuran_material', 50);
            $table->integer('stok_material')->default(0);
            $table->string('satuan', 10)->nullable();
            // $table->decimal('berat', 10, 2);
            $table->decimal('harga_material', 19);
            $table->string('deskripsi');
            $table->timestamps();
        });

        Schema::create('pb__WIP', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 50);
            $table->string('jenis_proses', 10);
            $table->integer('stok_barang')->default(0);
            $table->string('status', 10)->nullable();
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
        Schema::dropIfExists('pb__WIP');
    }
};
