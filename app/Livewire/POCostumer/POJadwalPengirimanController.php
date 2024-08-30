<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POJadwalPengiriman as PJPModel;
use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class POJadwalPengirimanController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
    $nama_customer,
    $no_po,
    $pengeluaran_barang,
    $tanggal_keluar_pt,
    $surat_jalan;

    public $searchNoPo = '';
    public $searchResults = [];
    public $PKM_id;

    protected $rules = [
        'nama_customer' => 'required',
        'no_po' => 'required',
        'pengeluaran_barang' => 'required',
        'tanggal_keluar_pt' => 'required',
        'surat_jalan' => 'required',
    ];

    public function messages()
    {
        return [
             '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function search()
    {
        $this->searchResults = PBFinishGood::where('no_po', 'like', '%' . $this->searchNoPo . '%')->get();
    }

    public function storeData()
    {
        $validatedData = $this->validate();
        PJPModel::create($validatedData);

        $this->reset('nama_customer',
'no_po',
'pengeluaran_barang',
'tanggal_keluar_pt',
'surat_jalan');
        session()->flash('suksesinput', 'Pengiriman berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = PJPModel::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PJPModel::findOrFail($this->PKM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        $namaMaterial = $validatedData['nama_material'];
        session()->flash('suksesupdate', 'Pengiriman ' . $namaMaterial . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        PJPModel::findOrFail($id)->delete();
        session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $poJadwalPengiriman = PJPModel::paginate(9);
        
        return view('livewire.po_costumer.tabel.tabel-jadwal_pengiriman', [
            'poJadwalPengiriman' => $poJadwalPengiriman,
        ]);
    }
}
