<?php

namespace App\Models\PersediaanBarang;

use App\Models\PelangganPemasok\Customer;
use App\Models\POCostumer\PO_PM_FgProduct;
use App\Models\POCostumer\POJadwalPengiriman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBFinishGood extends Model
{
    use HasFactory;
    protected $table = 'pb__finish_goods';
    protected $fillable = [

        'kode_barang',
        'nama_barang',
        'no_part',
        'stok_material',
        'harga',
        'tipe_barang',
    ];
    public function popmprodukfg()
    {
        return $this->hasMany(PO_PM_FgProduct::class);
    }
    public function pomasuk()
    {
        return $this->hasMany(POJadwalPengiriman::class, 'kode_barang', 'kode_barang');
    }
    public function customer()
    {
        return $this->hasMany(Customer::class, 'kode_customer', 'kode_customer');
    }
}
