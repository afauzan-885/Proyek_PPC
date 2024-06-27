<?php
 
 namespace App\Services;

 use App\Models\PersediaanBarang\PBfinishGood as FGModel;
 use NumberFormatter;
 
 class POMasukService
 {
    public function getFinishGoodDataByKodeBarang($kodeBarang)
    {
        $finishGood = FGModel::where('kode_barang', $kodeBarang)->first();
        if (!$finishGood) {
            return null; // Atau throw exception, tergantung pada penanganan error Anda
        }

        $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
        $hargaFormatted = $formatter->formatCurrency($finishGood->harga, 'IDR');

        return [
            'harga_material' => $hargaFormatted,
            // Tambahkan properti lain yang ingin Anda isi dari $finishGood
        ];
    }

    public function calculateTotalAmount($hargaMaterial, $qty)
    {
        if (is_numeric($hargaMaterial) && is_numeric($qty)) {
            $hargaBersih = preg_replace('/[^0-9]/', '', $hargaMaterial);
            $totalAmount = $hargaBersih * $qty;

            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            return $formatter->formatCurrency($totalAmount, 'IDR');
        } else {
            return 0;
        }
    }
 }