<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POJadwalPengiriman as PJPModel;
use App\Models\POCostumer\POMasuk as PMModel;
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
    $permintaan_po,
    $pengeluaran_barang,
    $tanggal_keluar_pt,
    $surat_jalan;

    public $PKM_id, $lastPage, $searchTerm='', $page, $query;

    protected $rules = [
        'nama_customer' => 'required',
        'no_po' => 'required',
        'permintaan_po' => 'required',
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

       public function cari()
    {
        $pomasuk = PMModel::where('no_po', $this->no_po)->first();
        sleep(1);
        if ($pomasuk) {
            $this->permintaan_po = $pomasuk->qty;
            $this->nama_customer = $pomasuk->nama_customer;
        } else {
            $this->addError('no_po', 'No. PO tidak ditemukan.');
        }
    }

    public function storeData()
{
    $validatedData = $this->validate();

    $pomasuk = PMModel::firstOrCreate(
        ['no_po' => $validatedData['no_po']], 
        [
            'nama_customer' => $validatedData['nama_customer'],
            // ... (field lainnya jika ada)
        ]
    );

    // Pastikan $pomasuk berhasil ditemukan/dibuat
    if ($pomasuk) {
        // Update stok_material dengan menambahkan qty_in setelah disimpan
        $pomasuk->qty -= $validatedData['pengeluaran_barang'];
        $pomasuk->save(); 

        PJPModel::create($validatedData);

        $this->reset(
            'nama_customer',
            'no_po',
            'permintaan_po',
            'pengeluaran_barang',
            'tanggal_keluar_pt',
            'surat_jalan'
        );
        session()->flash('suksesinput', 'Jadwal berhasil dibuat.');
    } else {
        // Tangani kasus jika $pomasuk tidak ditemukan/dibuat
        session()->flash('error', 'Terjadi kesalahan dalam memproses data PO Masuk.'); 
    }
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
        $namacustomer = $validatedData['nama_customer'];
        session()->flash('suksesupdate', 'Dadwal ' . $namacustomer . ' berhasil diupdate.');
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
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $poJadwalPengiriman = PJPModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->paginate(9);

        $poJadwalPengiriman = PJPModel::paginate(9);
        $poMasuk = PMModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-jadwal_pengiriman', [
            'poJadwalPengiriman' => $poJadwalPengiriman,
            'pomasuk' => $poMasuk,
        ]);
    }
}
