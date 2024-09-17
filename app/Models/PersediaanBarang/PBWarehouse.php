<?php

namespace App\Models\PersediaanBarang;

use App\Models\POCostumer\POKedatanganMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBWarehouse extends Model
{
    use HasFactory;
    protected $table = 'pb__warehouses';
    protected $fillable = [
        'kode_material',
        'nama_material',
        'ukuran_material',
        'stok_material',
        'satuan',
        'harga_material',
        'deskripsi',
        'status'
    ];
    public function pokedatanganmaterial()
    {
        return $this->hasMany(POKedatanganMaterial::class);
    }
}
