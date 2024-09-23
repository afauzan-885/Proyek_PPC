<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('kode_customer', 50);
            $table->string('no_telepon_pt', 30);
            $table->text('alamat_customer');
            $table->string('email_customer')->nullable();
            $table->text('kontak_customer')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_supplier');
            $table->string('kode_supplier', 50);
            $table->string('no_telepon_pt', 30);
            $table->text('alamat_supplier');
            $table->string('email_supplier')->nullable();
            $table->text('kontak_supplier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_suppliers');
    }
};
