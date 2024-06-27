<?php
namespace App\Models\POCostumer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO_PM_PemakaianMaterial extends Model
{

    use HasFactory;
    protected $table = 'po__pm__pemakaian_material';
    protected $fillable = [
        'nama_material',
        'jumlah_pengeluaran_material',
        'tanggal_keluar_po',
        'tanggal_keluar_pt',
    ];
}


