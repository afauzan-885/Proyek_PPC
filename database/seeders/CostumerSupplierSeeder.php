<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostumerSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('
            CREATE TRIGGER Sinkronisasi data Costumer Supplier
            AFTER UPDATE ON costumer_suppliers
            FOR EACH ROW
            BEGIN
                UPDATE finish_goods
                SET kode_costumer = NEW.kode_costumer
                WHERE kode_costumer = OLD.kode_costumer;
            END;
        ');
    }
}
