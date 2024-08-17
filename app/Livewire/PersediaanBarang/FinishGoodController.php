<?php

namespace App\Livewire\PersediaanBarang;

use App\Models\CostumerSupplier;
use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class FinishGoodController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $costumerSuppliers = [];

    //Public Finish Good
    public $kode_costumer, $kode_barang, $nama_barang, $no_part, $harga, $tipe_barang, $deskripsi = '', $fg_id;

    public function mount()
    {
        $this->costumerSuppliers = CostumerSupplier::all();
    }

    protected $rules = [
        'kode_costumer' => 'required|unique:pb__finish_goods,kode_costumer',
        'kode_barang' => 'required|unique:pb__finish_goods,kode_barang',
        'nama_barang' => 'required',
        'no_part' => 'required',
        'harga' => 'required',
        'tipe_barang' => 'required',
    ];

    public function storeData()
    {
        $validatedData = $this->validate();

        $hargaKeys = ['harga']; // Hanya untuk harga di Finish Good

        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float)Str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '')
                    ->replace(',', '.')
                    ->__toString();
            }
        }

        FGModel::create($validatedData);

        $this->reset(); // Reset semua input field setelah menyimpan
        session()->flash('suksesinput', 'Data Finish Good berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datafg = FGModel::findOrFail($id);
            $datafg->harga = number_format($datafg->harga, 0, ',', '.'); // Format harga untuk tampilan
            $this->fill($datafg->toArray());
            $this->fg_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data Finish Good tidak ditemukan.');
        }
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate([
                'kode_costumer' => 'required',
                'kode_barang' => 'required',
                'nama_barang' => 'required',
                'no_part' => 'required',
                'harga' => 'required',
                'tipe_barang' => 'required',
            ]);

            $validatedData['harga'] = (float) str_replace('.', '', $validatedData['harga']);

            $fg = FGModel::findOrFail($this->fg_id);
            $fg->update($validatedData);

            session()->flash('suksesupdate', 'Data ' . $fg->kode_costumer . ' berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
        $this->costumerSuppliers = CostumerSupplier::all();
    }

    public function delete($id)
    {
        FGModel::find($id)->delete();
        session()->flash('sukseshapus', 'Data Finish Good berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function render()
    {
        $finishGoods = FGModel::paginate(10);
        $costumerSuppliers = CostumerSupplier::all(); // Ambil data dari model CostumerSupplier
    
        return view('livewire.persediaan_barang.tabel.tabel_fg', [
            'finishGoods' => $finishGoods,
        ])
            ->with('costumerSuppliers', $costumerSuppliers); // Pass data ke view
    }
}
