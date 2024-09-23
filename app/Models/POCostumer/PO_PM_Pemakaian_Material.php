<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO_PM_Pemakaian_Material extends Model
{
    use HasFactory;
    protected $table = 'po__pm__pemakaian_material';
    protected $fillable = [
        'kode_material',
        'jumlah_pengeluaran_material',
        'stok_awal',
        'no_po',
        'satuan',
        'tgl_pemakaian_mtrial',
    ];
    public function warehouse()
    {
        return $this->belongsTo(WHModel::class, 'kode_material', 'kode_material'); // Ganti 'kode_material' dengan foreign key dan local key yang sesuai jika berbeda
    }
}
