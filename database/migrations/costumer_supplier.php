<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costumer_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_costumer');
            $table->string('kode_costumer', 50)->unique();
            $table->string('no_telepon_pt', 20);
            $table->text('alamat_costumer');
            $table->string('email_costumer');
            $table->text('kontak_costumer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costumer_suppliers');
    }
};
