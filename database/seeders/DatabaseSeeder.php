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
        // Buat user
        User::factory()->create([
            'name' => 'tester akun',
            'email' => 'tester@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
        ]);

        User::factory()->count(2)->create();

        // Buat customer_supplier
        $faker = Faker::create('id_ID');
        $industries = ['Teknologi Informasi', 'Pangan', 'Otomotif', 'Farmasi', 'Konstruksi', 'Retail'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Makassar'];

        for ($i = 0; $i < 24; $i++) {
            $industry = $industries[array_rand($industries)];
            $city = $cities[array_rand($cities)];

            $customerSupplier = new CostumerSupplier([
                'nama_costumer' => $faker->company . ' ' . $industry,
                'kode_costumer' => $this->generateUniqueCode($industry, $i),
                // ... kolom lainnya
            ]);
            $customerSupplier->save();
        }
    }

    private function generateUniqueCode(string $industry, int $index): string
    {
        $retries = 0;
        do {
            $code = substr($industry, 0, 3) . sprintf('%03d', $index + 1);
            $retries++;
        } while (CostumerSupplier::where('kode_costumer', $code)->exists() && $retries < 100);

        if ($retries >= 100) {
            throw new \Exception('Unable to generate unique code');
        }

        return $code;
    }
}