<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
    //Sinkronisasi data customer supplier ke finish goods
        DB::unprepared('
        CREATE TRIGGER `Sinkronisasi_data_Costumer_Supplier`
        AFTER UPDATE ON `costumer_suppliers`
        FOR EACH ROW
        BEGIN
            UPDATE pb__finish_goods
            SET kode_costumer = NEW.kode_costumer
            WHERE kode_costumer = OLD.kode_costumer;
        END

    ');

    //sinkronisasi kalkulasi data harga material dengan qty di PO Masuk
        DB::unprepared('
        CREATE TRIGGER `Sinkronisasi_data_po_masuk` 
        AFTER UPDATE ON `pb__finish_goods`
        FOR EACH ROW 
        BEGIN
            UPDATE po__po_masuk
            SET harga = NEW.harga
            WHERE kode_barang = NEW.kode_barang;
        END
    ');

    
    //Perhitungan Realtime Total Amount di PO Masuk
        DB::unprepared('
        CREATE TRIGGER `Realtime_Kalkulasi_Total_amount_data_PO_Masuk`
        AFTER UPDATE ON `pb__finish_goods`
        FOR EACH ROW 
        BEGIN
            UPDATE po__po_masuk
            SET total_amount = harga * qty
            WHERE id = NEW.id;
        END
     ');
}
    
    
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `Sinkronisasi_data_Costumer_Supplier`');
        DB::unprepared('DROP TRIGGER `Sinkronisasi_data_po_masuk`');
        DB::unprepared('DROP TRIGGER `Realtime_Kalkulasi_Total_amount_data_PO_Masuk`');
    }
};
