<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER Sinkronisasi_data_Costumer_Supplier
        AFTER UPDATE ON costumer_suppliers
        FOR EACH ROW
        BEGIN
            UPDATE finish_goods
            SET kode_costumer = NEW.kode_costumer
            WHERE kode_costumer = OLD.kode_costumer;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `Sinkronisasi_data_Costumer_Supplier`');
    }
};
