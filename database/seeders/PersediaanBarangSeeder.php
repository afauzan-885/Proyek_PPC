<?php

namespace Database\Seeders;

use App\Models\PersediaanBarang\PBFinishGood as FGModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use App\Models\PersediaanBarang\PBWIP as WIPModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersediaanBarangSeeder extends Seeder
{
    public function run(): void
    {
        $finishGoods = [
            ['nama_barang' => 'Kampas Rem Depan Mobil', 'harga' => 150000, 'tipe_barang' => 'S-Stamping'],
            ['nama_barang' => 'Filter Udara Motor', 'harga' => 50000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Busi Mobil', 'harga' => 30000, 'tipe_barang' => 'W-Workshop'],
            ['nama_barang' => 'Aki Mobil', 'harga' => 800000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Lampu Depan Motor', 'harga' => 200000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Oli Mesin Mobil', 'harga' => 120000, 'tipe_barang' => 'W-Workshop'],
            ['nama_barang' => 'Ban Mobil', 'harga' => 700000, 'tipe_barang' => 'W-Workshop'],
            ['nama_barang' => 'Rantai Motor', 'harga' => 180000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Knalpot Motor', 'harga' => 350000, 'tipe_barang' => 'S-Stamping'],
            ['nama_barang' => 'Spion Mobil', 'harga' => 100000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Filter Oli Mobil', 'harga' => 40000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Shockbreaker Motor', 'harga' => 250000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Bearing Roda Mobil', 'harga' => 80000, 'tipe_barang' => 'W-Workshop'],
            ['nama_barang' => 'V-belt Motor', 'harga' => 60000, 'tipe_barang' => 'W-Workshop'],
            ['nama_barang' => 'Piston Motor', 'harga' => 150000, 'tipe_barang' => 'S-Stamping'],
            ['nama_barang' => 'Kampas Kopling Motor', 'harga' => 90000, 'tipe_barang' => 'S-Stamping'],
            ['nama_barang' => 'Disc Brake Mobil', 'harga' => 280000, 'tipe_barang' => 'S-Stamping'],
            ['nama_barang' => 'Karburator Motor', 'harga' => 400000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Pompa Bensin Mobil', 'harga' => 550000, 'tipe_barang' => 'A-Assy'],
            ['nama_barang' => 'Velg Racing Mobil', 'harga' => 1200000, 'tipe_barang' => 'S-Stamping']
        ];


        $materialPenyusun = [
            // Kampas Rem Depan Mobil
            [
                'kode_material' => 'KRDM-01',
                'nama_material' => 'Pelat Baja',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 8000,
                'deskripsi' => 'Pelat baja untuk membuat backing plate kampas rem.',
            ],
            [
                'kode_material' => 'KRDM-02',
                'nama_material' => 'Material Friksi',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 20000,
                'deskripsi' => 'Material friksi untuk menghasilkan gesekan pada kampas rem.',
            ],
            // Filter Udara Motor
            [
                'kode_material' => 'FUM-01',
                'nama_material' => 'Kertas Filter',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 5000,
                'deskripsi' => 'Kertas filter untuk menyaring udara.',
            ],
            [
                'kode_material' => 'FUM-02',
                'nama_material' => 'Plastik',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 3000,
                'deskripsi' => 'Plastik untuk membuat rumah filter.',
            ],
            // Busi Mobil
            [
                'kode_material' => 'BM-01',
                'nama_material' => 'Baja',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 5000,
                'deskripsi' => 'Baja untuk membuat badan busi.',
            ],
            [
                'kode_material' => 'BM-02',
                'nama_material' => 'Keramik',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 2000,
                'deskripsi' => 'Keramik untuk isolator busi.',
            ],
            [
                'kode_material' => 'BM-03',
                'nama_material' => 'Elektroda Pusat',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 1000,
                'deskripsi' => 'Elektroda pusat untuk menghasilkan percikan api.',
            ],
            // Aki Mobil
            [
                'kode_material' => 'AM-01',
                'nama_material' => 'Timah',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 30000,
                'deskripsi' => 'Timah untuk membuat kisi-kisi aki.',
            ],
            [
                'kode_material' => 'AM-02',
                'nama_material' => 'Asam Sulfat',
                'ukuran_material' => '-',
                'satuan' => 'liter',
                'harga_material' => 15000,
                'deskripsi' => 'Asam sulfat sebagai elektrolit aki.',
            ],
            [
                'kode_material' => 'AM-03',
                'nama_material' => 'Plastik',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 5000,
                'deskripsi' => 'Plastik untuk membuat wadah aki.',
            ],
            // Lampu Depan Motor
            [
                'kode_material' => 'LDM-01',
                'nama_material' => 'Kaca',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 10000,
                'deskripsi' => 'Kaca untuk lensa lampu.',
            ],
            [
                'kode_material' => 'LDM-02',
                'nama_material' => 'Reflektor',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 15000,
                'deskripsi' => 'Reflektor untuk memantulkan cahaya.',
            ],
            [
                'kode_material' => 'LDM-03',
                'nama_material' => 'Bohlam',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 5000,
                'deskripsi' => 'Bohlam sebagai sumber cahaya.',
            ],
            // Oli Mesin Mobil
            [
                'kode_material' => 'OMM-01',
                'nama_material' => 'Minyak Dasar',
                'ukuran_material' => '-',
                'satuan' => 'liter',
                'harga_material' => 50000,
                'deskripsi' => 'Minyak dasar sebagai bahan utama oli.',
            ],
            [
                'kode_material' => 'OMM-02',
                'nama_material' => 'Aditif',
                'ukuran_material' => '-',
                'satuan' => 'liter',
                'harga_material' => 20000,
                'deskripsi' => 'Aditif untuk meningkatkan performa oli.',
            ],
            // Ban Mobil
            [
                'kode_material' => 'BANM-01',
                'nama_material' => 'Karet Alam',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 20000,
                'deskripsi' => 'Karet alam untuk membuat tapak ban.',
            ],
            [
                'kode_material' => 'BANM-02',
                'nama_material' => 'Karet Sintetis',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 15000,
                'deskripsi' => 'Karet sintetis untuk bagian dinding ban.',
            ],
            [
                'kode_material' => 'BANM-03',
                'nama_material' => 'Benang Nylon',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 10000,
                'deskripsi' => 'Benang nylon untuk memperkuat struktur ban.',
            ],
            [
                'kode_material' => 'BANM-04',
                'nama_material' => 'Kawat Baja',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 8000,
                'deskripsi' => 'Kawat baja untuk bead ban.',
            ],
            // Rantai Motor
            [
                'kode_material' => 'RANTM-01',
                'nama_material' => 'Baja Paduan',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 15000,
                'deskripsi' => 'Baja paduan untuk membuat mata rantai.',
            ],
            [
                'kode_material' => 'RANTM-02',
                'nama_material' => 'Pelumas',
                'ukuran_material' => '-',
                'satuan' => 'liter',
                'harga_material' => 5000,
                'deskripsi' => 'Pelumas untuk mengurangi gesekan pada rantai.',
            ],
            // Knalpot Motor
            [
                'kode_material' => 'KNPM-01',
                'nama_material' => 'Pipa Baja',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 10000, // Angka yang lebih realistis untuk pipa baja
                'deskripsi' => 'Pipa baja untuk membentuk badan knalpot.',
            ],
            [
                'kode_material' => 'KNPM-02',
                'nama_material' => 'Glasswool',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 5000,
                'deskripsi' => 'Glasswool untuk peredam suara.',
            ],
            [
                'kode_material' => 'KNPM-03',
                'nama_material' => 'Pelat Besi',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 8000,
                'deskripsi' => 'Pelat besi untuk membuat braket dan komponen lain.',
            ],

            // Spion Mobil
            [
                'kode_material' => 'SPM-01',
                'nama_material' => 'Kaca Spion',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 30000,
                'deskripsi' => 'Kaca untuk memantulkan pandangan.',
            ],
            [
                'kode_material' => 'SPM-02',
                'nama_material' => 'Plastik',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 5000,
                'deskripsi' => 'Plastik untuk membuat rumah spion.',
            ],
            [
                'kode_material' => 'SPM-03',
                'nama_material' => 'Motor Penggerak (opsional)',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 20000,
                'deskripsi' => 'Motor untuk mengatur posisi spion secara elektrik.',
            ],

            // Filter Oli Mobil
            [
                'kode_material' => 'FOM-01',
                'nama_material' => 'Kertas Filter',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 3000,
                'deskripsi' => 'Kertas filter untuk menyaring oli.',
            ],
            [
                'kode_material' => 'FOM-02',
                'nama_material' => 'Logam',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 4000,
                'deskripsi' => 'Logam untuk membuat rumah filter.',
            ],
            [
                'kode_material' => 'FOM-03',
                'nama_material' => 'Karet Seal',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 1000,
                'deskripsi' => 'Karet seal untuk mencegah kebocoran.',
            ],

            // Shockbreaker Motor
            [
                'kode_material' => 'SHKM-01',
                'nama_material' => 'Tabung Baja',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 20000,
                'deskripsi' => 'Tabung baja sebagai bagian luar shockbreaker.',
            ],
            [
                'kode_material' => 'SHKM-02',
                'nama_material' => 'Piston',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 10000,
                'deskripsi' => 'Piston untuk mengatur aliran oli.',
            ],
            [
                'kode_material' => 'SHKM-03',
                'nama_material' => 'Oli Shockbreaker',
                'ukuran_material' => '-',
                'satuan' => 'liter',
                'harga_material' => 15000,
                'deskripsi' => 'Oli untuk meredam guncangan.',
            ],
            [
                'kode_material' => 'SHKM-04',
                'nama_material' => 'Per',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 8000,
                'deskripsi' => 'Per untuk memberikan tekanan balik.',
            ],

            // Bearing Roda Mobil
            [
                'kode_material' => 'BRM-01',
                'nama_material' => 'Baja Krom',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 12000,
                'deskripsi' => 'Baja krom untuk membuat cincin dalam dan luar bearing.',
            ],
            [
                'kode_material' => 'BRM-02',
                'nama_material' => 'Bola Baja',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 500,
                'deskripsi' => 'Bola baja sebagai elemen gelinding.',
            ],
            [
                'kode_material' => 'BRM-03',
                'nama_material' => 'Gemuk',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 3000,
                'deskripsi' => 'Gemuk untuk pelumasan.',
            ],

            // V-belt Motor
            [
                'kode_material' => 'VBM-01',
                'nama_material' => 'Karet',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 4000,
                'deskripsi' => 'Karet sebagai bahan utama V-belt.',
            ],
            [
                'kode_material' => 'VBM-02',
                'nama_material' => 'Benang Polyester',
                'ukuran_material' => '-',
                'satuan' => 'meter',
                'harga_material' => 2000,
                'deskripsi' => 'Benang polyester untuk memperkuat V-belt.',
            ],

            // Piston Motor
            [
                'kode_material' => 'PISM-01',
                'nama_material' => 'Aluminium Paduan',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 10000,
                'deskripsi' => 'Aluminium paduan untuk membuat badan piston.',
            ],
            [
                'kode_material' => 'PISM-02',
                'nama_material' => 'Ring Piston',
                'ukuran_material' => '-',
                'satuan' => 'set',
                'harga_material' => 5000,
                'deskripsi' => 'Ring piston untuk mencegah kebocoran kompresi.',
            ],

            [
                'kode_material' => 'PISM-03',
                'nama_material' => 'Pen Piston',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 3000,
                'deskripsi' => 'Pen piston untuk menghubungkan piston dengan batang piston.',
            ],

            // Kampas Kopling Motor
            [
                'kode_material' => 'KKM-01',
                'nama_material' => 'Pelat Baja',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 6000,
                'deskripsi' => 'Pelat baja untuk membuat pelat kopling.',
            ],
            [
                'kode_material' => 'KKM-02',
                'nama_material' => 'Material Friksi',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 15000,
                'deskripsi' => 'Material friksi untuk menghasilkan gesekan pada kampas kopling.',
            ],
            [
                'kode_material' => 'KKM-03',
                'nama_material' => 'Per Kopling',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 3000,
                'deskripsi' => 'Per untuk memberikan tekanan pada kampas kopling.',
            ],

            // Disc Brake Mobil
            [
                'kode_material' => 'DBM-01',
                'nama_material' => 'Besi Tuang',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 5000,
                'deskripsi' => 'Besi tuang untuk membuat rotor disc brake.',
            ],

            // Karburator Motor
            [
                'kode_material' => 'KARBM-01',
                'nama_material' => 'Aluminium Paduan',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 8000,
                'deskripsi' => 'Aluminium paduan untuk membuat badan karburator.',
            ],
            [
                'kode_material' => 'KARBM-02',
                'nama_material' => 'Kuningan',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 12000,
                'deskripsi' => 'Kuningan untuk membuat jarum skep dan komponen lainnya.',
            ],
            [
                'kode_material' => 'KARBM-03',
                'nama_material' => 'Plastik',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 3000,
                'deskripsi' => 'Plastik untuk membuat pelampung dan komponen lainnya.',
            ],

            // Pompa Bensin Mobil
            [
                'kode_material' => 'PBM-01',
                'nama_material' => 'Baja',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 6000,
                'deskripsi' => 'Baja untuk membuat rumah pompa.',
            ],
            [
                'kode_material' => 'PBM-02',
                'nama_material' => 'Motor Listrik',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 30000,
                'deskripsi' => 'Motor listrik untuk menggerakkan pompa.',
            ],
            [
                'kode_material' => 'PBM-03',
                'nama_material' => 'Diafragma',
                'ukuran_material' => '-',
                'satuan' => 'pcs',
                'harga_material' => 5000,
                'deskripsi' => 'Diafragma untuk memompa bahan bakar.',
            ],

            // Velg Racing Mobil
            [
                'kode_material' => 'VRM-01',
                'nama_material' => 'Aluminium Paduan',
                'ukuran_material' => '-',
                'satuan' => 'kg',
                'harga_material' => 15000,
                'deskripsi' => 'Aluminium paduan untuk membuat velg yang ringan dan kuat.',
            ],
        ];

        foreach ($materialPenyusun as $material) {
            DB::table('pb__warehouses')->insert([
                'kode_material' => $material['kode_material'],
                'nama_material' => $material['nama_material'],
                'ukuran_material' => $material['ukuran_material'],
                'stok_material' => 0, // Default sesuai permintaan
                'satuan' => $material['satuan'],
                'harga_material' => $material['harga_material'],
                'deskripsi' => $material['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($finishGoods as $barang) {
            DB::table('pb__finish_goods')->insert([
                'kode_barang' => Str::slug($barang['nama_barang']),
                'nama_barang' => $barang['nama_barang'],
                'no_part' => Str::slug($barang['nama_barang']),
                'harga' => $barang['harga'],
                'tipe_barang' => $barang['tipe_barang'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
