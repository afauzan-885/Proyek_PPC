<?php

namespace App\Models\POCostumer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoL_Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'po__jadwal_pengiriman';
    protected $fillable = [
        'nama_customer',
        'no_po',
        'permintaan_po',
        'pengeluaran_barang',
        'tanggal_keluar_pt',
        'surat_jalan',
      ];
}
