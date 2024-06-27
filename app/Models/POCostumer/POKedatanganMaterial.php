<?php

namespace App\Models\POCostumer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POKedatanganMaterial extends Model
{
    use HasFactory;
    protected $table = 'po__kedatangan_material';
    protected $fillable = [
        'nama_material',
        'tgl_masuk_material',
        'nama_supplier',
        'qty_sheet_lyr',
        'qty_kg',
        'surat_jalan',
      ];
}
