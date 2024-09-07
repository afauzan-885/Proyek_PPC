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
            CREATE TRIGGER `Sinkronisasi_dan_Kalkulasi_PO_Masuk` 
            AFTER UPDATE ON `pb__finish_goods`
            FOR EACH ROW 
            BEGIN
                UPDATE po__po_masuk
                SET kode_barang = NEW.kode_barang,
                    harga = NEW.harga,
                    total_amount = harga * qty
                WHERE kode_barang = OLD.kode_barang;
            END

        ');

        //Sinkronisasi dan Kalkulasi data Pembelian Material
            DB::unprepared('
            CREATE TRIGGER `Sinkronisasi_Data_Pembelian_Material` 
            AFTER UPDATE ON `pb__warehouses`
            FOR EACH ROW 
            BEGIN
            UPDATE po__pembelian_material
            SET
                kode_material = NEW.kode_material,
                harga_material = NEW.harga_material,
                ukuran = NEW.ukuran_material,
                total_amount = NEW.harga_material * qty
                WHERE kode_material = OLD.kode_material;
            END

        ');
    }
        
        
        public function down(): void
        {
            DB::unprepared('DROP TRIGGER `Sinkronisasi_data_Costumer_Supplier`');
            DB::unprepared('DROP TRIGGER `Sinkronisasi_dan_Kalkulasi_PO_Masuk`');
            DB::unprepared('DROP TRIGGER `Sinkronisasi_Data_Pembelian_Material`');
        }
    };
