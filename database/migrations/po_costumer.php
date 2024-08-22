<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        //PO Masuk
        Schema::create('po__po_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->date('tanggal_po');
            $table->string('term_of_payment', 50);
            $table->integer('qty');
            $table->decimal('harga', 19, 2);
            $table->string('no_po', 50)->unique();
            $table->date('tanggal_pengiriman');
            $table->string('kode_barang', 50);
            $table->decimal('total_amount', 19, 2);
            $table->timestamps();
        });

         //Pembelian Material
         Schema::create('po__pembelian_material', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material');
            $table->string('nama_material');
            $table->string('ukuran', 50);
            $table->integer('qty');
            $table->string('no_po', 50);
            $table->decimal('harga_material', 19, 2);
            $table->decimal('total_amount', 19, 2);
            $table->timestamps();
        });

        //Kedatangan Material
        Schema::create('po__kedatangan_material', function (Blueprint $table) {
            $table->id();
            $table->string('nama_material', 50);
            $table->date('tgl_msk_material');
            $table->string('nama_supplier', 50);
            $table->string('qty_sheet_lyr', 50);
            $table->string('surat_jalan', 50);
            $table->timestamps();
        });
 

        //Proses Material
        Schema::create('po__pm__pemakaian_material', function (Blueprint $table) {
            $table->id();
            $table->string('nama_material');
            $table->integer('jumlah_pengeluaran_material');
            $table->date('tanggal_keluar_po');
            $table->date('tanggal_keluar_pt');
            $table->timestamps();
        });

        Schema::create('po__pm__produk_wip', function (Blueprint $table) {
            $table->id();
            $table->string('nama_material');
            $table->date('tanggal_produksi');
            $table->string('shift', 50);
            $table->string('no_mesin', 50);
            $table->string('proses_produksi');
            $table->integer('hasil_ok');
            $table->integer('hasil_ng');
            $table->timestamps();
        });

        Schema::create('po__pm__produk_fg', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('shift_produksi', 50);
            $table->integer('qty_awal');
            $table->integer('qty_in');
            $table->integer('qty_out');
            $table->timestamps();
        });

        //Jadwal Pengiriman
        Schema::create('po__jadwal_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('no_po', 50);
            $table->integer('pengeluaran_material');
            $table->date('tanggal_keluar_pt');
            $table->string('surat_jalan', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //PO Masuk
        Schema::dropIfExists('po__po_masuk');

        //Kedatangan Material
        Schema::dropIfExists('po__kedatangan_material');

        //Pembelian Material
        Schema::dropIfExists('po__pembelian_material');

        //Proses Material
        Schema::dropIfExists('po__pm__pemakaian_material');
        Schema::dropIfExists('po__pm__produk_fg');
        Schema::dropIfExists('po__pm__produk_wip');

        //Jadwal Pengiriman
        Schema::dropIfExists('po__jadwal_pengiriman');
    }
};
