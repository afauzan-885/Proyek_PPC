<?php

namespace App\Models\POCostumer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POJadwalPengiriman extends Model
{
    use HasFactory;
    protected $table = 'po__jadwal_pengiriman';
    protected $fillable = [
        'nama_customer',
        'no_po',
        'pengeluaran_barang',
        'tanggal_keluar_pt',
        'surat_jalan',
      ];
}
