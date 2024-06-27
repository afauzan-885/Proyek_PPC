<?php
namespace App\Models\PersediaanBarang;

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
        // 'jumlah_material',
        // 'berat',
        'harga_material',
        'deskripsi'
    ];
}


