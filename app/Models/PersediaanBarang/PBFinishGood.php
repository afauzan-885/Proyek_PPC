<?php

namespace App\Models\PersediaanBarang;
use App\Models\CostumerSupplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBFinishGood extends Model
{
    use HasFactory;
    protected $table = 'pb__finish_goods';
    protected $fillable = [
        // 'kode_costumer', 
        'kode_barang',
        'nama_barang',
        'no_part',
        'harga',
        'tipe_barang',
    ];
    public function costumerSupplier()
    {
        return $this->belongsTo(CostumerSupplier::class);
    }
}
