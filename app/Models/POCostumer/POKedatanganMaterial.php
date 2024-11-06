<?php

namespace App\Models\POCostumer;

use App\Models\PelangganPemasok\Supplier;
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
    'kode_supplier',
    'qty',
    'surat_jalan',
    'satuan',
  ];
  
  public function warehouse()
  {
    return $this->belongsTo(PBWarehouse::class); // Hubungkan berdasarkan kode_material
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier'); // Hubungkan berdasarkan kode_material
  }
}
