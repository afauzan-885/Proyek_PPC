<?php
namespace App\Models\PersediaanBarang;

use App\Models\POCostumer\PO_PM_WipProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBWIP extends Model
{
    use HasFactory;
    protected $table = 'pb__wip';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_proses',
        'stok_barang',
        'status'
    ];
    public function PO_PM_WipProduct()
    {
        return $this->hasMany(PO_PM_WipProduct::class);
    }
}


