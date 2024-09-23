<?php

namespace App\Livewire;

use App\Models\PersediaanBarang\PBFinishGood;
use Livewire\Component;
use App\Models\POCostumer\POMasuk; // Pastikan Anda mengimpor model Pomasuk
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GrafikChartsController extends Component
{

    // private function prepareChartData()
    // {
    //     // Ambil data total_pesanan, kode_barang, dan created_at dari tabel pomasuk
    //     $pomasukData = POMasuk::select('total_pesanan', 'kode_barang', 'created_at')->get();

    //     // Kelompokkan data berdasarkan kode_barang
    //     $groupedData = $pomasukData->groupBy('kode_barang');

    //     // Ambil semua tanggal pengiriman yang unik dan urutkan, format sesuai kebutuhan
    //     $categories = $pomasukData->pluck('created_at')->unique()->sort()->map(function ($date) {
    //         return Carbon::parse($date)->format('d-m-y'); // Format yang sama dengan yang digunakan di loop
    //     })->values()->toArray();

    //     // Siapkan data series untuk ApexCharts, pastikan setiap seri memiliki data untuk semua kategori
    //     $series = $groupedData->map(function ($items, $kodeBarang) use ($categories) {
    //         $data = [];
    //         foreach ($categories as $category) {
    //             $totalPesanan = $items->filter(function ($item) use ($category) {
    //                 return Carbon::parse($item->created_at)->format('d-m-y') === $category;
    //             })->sum('total_pesanan') ?? 0;
    //             $data[] = $totalPesanan;
    //         }

    //         return [
    //             'name' => $kodeBarang,
    //             'data' => $data,
    //         ];
    //     })->values()->toArray();

    //     return [
    //         'series' => $series,
    //         'categories' => $categories,
    //     ];
    // }

    private function prepareChartData()
    {
        // Ambil data yang dibutuhkan dan format tanggal langsung
        $pomasukData = POMasuk::select('total_pesanan', 'kode_barang', DB::raw("DATE_FORMAT(created_at, '%d-%m-%y') as formatted_date"))
            ->get();

        // Kelompokkan data dan hitung total pesanan per tanggal untuk setiap kode barang
        $groupedData = $pomasukData->groupBy('kode_barang')->map(function ($items) {
            return $items->groupBy('formatted_date')->map->sum('total_pesanan');
        });

        // Ambil semua tanggal unik dan urutkan
        $categories = $pomasukData->pluck('formatted_date')->unique()->sort()->values()->toArray();

        // Siapkan data series, pastikan setiap seri memiliki data untuk semua kategori
        $series = $groupedData->map(function ($dataPerTanggal, $kodeBarang) use ($categories) {
            $data = [];
            foreach ($categories as $category) {
                $data[] = $dataPerTanggal[$category] ?? 0;
            }
            return [
                'name' => $kodeBarang,
                'data' => $data,
            ];
        })->values()->toArray();

        return [
            'series' => $series,
            'categories' => $categories,
        ];
    }

    public function render()
    {
        $chartData = $this->prepareChartData();

        return view('livewire.grafik_chart')
            ->with([
                'categories' => $chartData['categories'],
                'series' => $chartData['series'],
            ]);
    }
}
