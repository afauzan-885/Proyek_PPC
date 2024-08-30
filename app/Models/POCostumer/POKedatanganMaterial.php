<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POKedatanganMaterial extends Model
{
    use HasFactory;
    protected $table = 'po__kedatangan_material';
    protected $fillable = [
      'kode_material',
      'nama_material',
      'tgl_msk_material',
      'nama_supplier',
      'qty',
      'surat_jalan',
      'satuan',
  ];
  public function warehouse()
  {
      return $this->belongsTo(PBWarehouse::class, 'kode_material', 'kode_material'); // Hubungkan berdasarkan kode_material
  }
}
