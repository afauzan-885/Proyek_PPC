<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POJadwalPengiriman extends Model
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

  public function finishgoods()
  {
    return $this->belongsTo(PBFinishGood::class, 'kode_barang', 'kode_barang');
  }
  public function pomasuk()
  {
    return $this->belongsTo(POMasuk::class, 'no_po', 'no_po');
  }
}
