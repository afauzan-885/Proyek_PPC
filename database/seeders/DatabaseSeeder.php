<?php

namespace Database\Seeders;

use App\Models\CostumerSupplier;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


     public function run()
     {
         $faker = Faker::create('id_ID'); 
 
         $costumers = [
             [
                 'nama_costumer' => 'PT. Adiperkasa Anugrah Pratama',
                 'kode_costumer' => 'AAP-01',
                 'no_telepon_pt' => '(021) 5522725', 
                 'alamat_costumer' => 'Jl. Imam Bonjol No.38, RT.004/RW.003, Karawaci, Kec. Karawaci, Kota Tangerang, Banten 15115', 
                 'email_costumer' => 'info@adiperkasa.com', 
                 'kontak_costumer' => 'Bapak Budi Santoso', 
             ],
             [
                 'nama_costumer' => 'PT. Arai Rubbe Seal Indonesia',
                 'kode_costumer' => 'ARSI-02',
                 'no_telepon_pt' => '+62 21 54391672', 
                 'alamat_costumer' => 'Jl. Gaya Motor Raya No. 8, Sunter II, Jakarta Utara, DKI Jakarta 14350, Indonesia', 
                 'email_costumer' => 'arai@arai-rsi.com', 
                 'kontak_costumer' => 'Customer Service', 
             ],
             [
                 'nama_costumer' => 'PT. ARS Indonesia',
                 'kode_costumer' => 'ARS-03',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@arsindonesia.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Beton Perkasa Wijaksana',
                 'kode_costumer' => 'BPW-04',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@betonperkasawijaksana.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Bonecom Tricom',
                 'kode_costumer' => 'BT-05',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@bonecomtricom.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Citra Galvalindo Sukses Mandiri',
                 'kode_costumer' => 'CGSM-06',
                 'no_telepon_pt' => '+62-21 89980714', 
                 'alamat_costumer' => 'Jl. Lingkar Luar Barat Ruko Green Lake Sunter Blok M Nomor 31-32, Sunter Jaya, Tanjung Priok, Jakarta Utara, DKI Jakarta 14350', 
                 'email_costumer' => 'info@citragalvalindo.com',
                 'kontak_costumer' => 'Customer Service', 
             ],
             [
                 'nama_costumer' => 'PT. Duta Nichirindo Pratama',
                 'kode_costumer' => 'DNIP-07',
                 'no_telepon_pt' => '+62 21 65832222', 
                 'alamat_costumer' => 'Jl. Bandengan Utara No. 80-P, Penjaringan, Jakarta Utara 14440', 
                 'email_costumer' => 'marketing@nichirindo.com', 
                 'kontak_costumer' => 'Bagian Pemasaran', 
             ],
             [
                 'nama_costumer' => 'PT. Dama Jaya Technindo',
                 'kode_costumer' => 'DJT-08',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@damajayatechindo.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Giga Creative Engineering',
                 'kode_costumer' => 'GCE-09',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@gigacreativeengineering.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Global Teknik Perkasa',
                 'kode_costumer' => 'GTP-10',
                 'no_telepon_pt' => '+62 21 6330468', 
                 'alamat_costumer' => 'Jl. Bandengan Utara Blok I No. 31, Penjaringan, Jakarta Utara, DKI Jakarta 14440, Indonesia', 
                 'email_costumer' => 'info@globalteknikperkasa.co.id', 
                 'kontak_costumer' => 'Customer Service', 
             ],
             [
                 'nama_costumer' => 'PT. Gunung Selang',
                 'kode_costumer' => 'GS-11',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@gunungselang.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Kongo Citra Manufactur Indonesia',
                 'kode_costumer' => 'KCMI-12',
                 'no_telepon_pt' => '+62 21 29512000', 
                 'alamat_costumer' => 'Jl. Pulogadung No.33, RT.3/RW.9, Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13210', 
                 'email_costumer' => 'info@kongo-citra.com', 
                 'kontak_costumer' => 'Customer Service', 
             ],
             [
                 'nama_costumer' => 'PT. Magacipta Wira Sentosa',
                 'kode_costumer' => 'MWS-13',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@magaciptawira.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Metal Fastindo Abadi',
                 'kode_costumer' => 'MFA-14',
                 'no_telepon_pt' => $faker->phoneNumber(), 
                 'alamat_costumer' => $faker->address(), 
                 'email_costumer' => 'info@metalfastindoabadi.com', 
                 'kontak_costumer' => $faker->name(), 
             ],
             [
                 'nama_costumer' => 'PT. Multi Instrumentasi',
                 'kode_costumer' => 'MI-15',
                 'no_telepon_pt' => '+62 21 42883030', 
                 'alamat_costumer' => 'Jl. Tanah Merdeka No.8B, RT.1/RW.10, Rambutan, Kec. Ciracas, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13830', 
                 'email_costumer' => 'info@multiinstrumentasi.com', 
                 'kontak_costumer' => 'Customer Service', 
                ],
                [
                    'nama_costumer' => 'PT. Nandya Karya Perkasa',
                    'kode_costumer' => 'NKP-16',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@nandyakarya.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. Nusaka Toolsindo Sejahtera',
                    'kode_costumer' => 'NTS-17',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@nusakatoolsindo.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. NHK Precision Part Indonesia',
                    'kode_costumer' => 'NHKPPI-18',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@nhkprecision.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. Pelangi Prima Teknikraya',
                    'kode_costumer' => 'PPT-19',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@pelangiprimateknik.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. Surya Jaya Teknik',
                    'kode_costumer' => 'SJT-20',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@suryajayateknik.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. Sukses Cipta Makmur',
                    'kode_costumer' => 'SCM-21',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@suksesciptamakmur.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
                [
                    'nama_costumer' => 'PT. Toyota Boshoku Indonesia',
                    'kode_costumer' => 'TBI-22',
                    'no_telepon_pt' => '+62 21 5820666', 
                    'alamat_costumer' => 'Jl. Surya Madya Kav. 7, Greenland International Industrial Center (GIIC), Kota Deltamas, Cikarang Pusat, Bekasi 17550', 
                    'email_costumer' => 'info@toyota-boshoku.co.id', 
                    'kontak_costumer' => 'Customer Service', 
                ],
                [
                    'nama_costumer' => 'PT. Taralon Polyalloy',
                    'kode_costumer' => 'TP-23',
                    'no_telepon_pt' => $faker->phoneNumber(), 
                    'alamat_costumer' => $faker->address(), 
                    'email_costumer' => 'info@taralonpolyalloy.com', 
                    'kontak_costumer' => $faker->name(), 
                ],
            ];
    
            foreach ($costumers as $costumer) {
                CostumerSupplier::create($costumer);
            }
        }

    
}