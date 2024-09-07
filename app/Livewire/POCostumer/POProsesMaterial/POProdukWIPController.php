<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_WipProduct as PoWIP;
use App\Models\PersediaanBarang\PBWIP as WIPModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class POProdukWIPController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // #[Locked]
    public
    $nama_produk,
    $kode_barang,
    $tanggal_produksi,
    $shift,
    $no_mesin,
    $proses_produksi,
    $hasil_ok,
    $hasil_ng;

    public $PoWIP_id, $lastPage, $searchTerm='', $page, $query;

    protected $rules = [
        'nama_produk' => 'required',
        'kode_barang' => 'required',
        'tanggal_produksi' => 'required',
        'shift' => 'required',
        'no_mesin' => 'required',
        'proses_produksi' => 'required',
        'hasil_ok' => 'required',
        'hasil_ng' => 'required',
    ];

    public function messages()
    {
        return [
             '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function storeData()
    {
        $validatedData = $this->validate();

        $uuid = Str::uuid();
         
        // Cari data di WIPModel berdasarkan nama_produk
        $wip = WIPModel::where('kode_barang', $validatedData['kode_barang'])->first();
        
        // 1. Cari atau buat data di pb__wip berdasarkan kode_barang
        if ($wip) {

            // Jika data sudah ada, perbarui
            $wip->update([
                'stok_barang' => $validatedData['hasil_ok'],
                'jenis_proses' => $validatedData['proses_produksi'],
            ]);
        } else {

            // Jika data belum ada, buat baru
            WIPModel::create([

                // Kiri untuk database  WIP dari database Produk WIP
                'uuid' => $uuid, 
                'kode_barang' => $validatedData['kode_barang'],
                'nama_barang' => $validatedData['nama_produk'],
                'stok_barang' => $validatedData['hasil_ok'],
                'jenis_proses' => $validatedData['proses_produksi'],
            ]);
        }
        
        PoWIP::create($validatedData);
        sleep(1);
        $namaproduk = $validatedData['nama_produk'];



        $this->reset('nama_produk',
'kode_barang',
'tanggal_produksi',
'shift',
'no_mesin',
'proses_produksi',
'hasil_ok',
'hasil_ng');
        session()->flash('suksesinput', 'Material ' . $namaproduk . ' berhasil ditambahkan.');
    }
    
    public function showData(int $id)
    {
        $validatedData = PoWIP::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();

            PoWIP::findOrFail($this->PoWIP_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Produk tidak ditemukan.');   
        }

        $namaproduk = $validatedData['nama_produk'];
        session()->flash('suksesupdate', 'Material ' . $namaproduk . ' berhasil diupdate.');
    }


    public function delete($id)
    {
        $produkWIP = PoWIP::findOrFail($id);
        $namaproduk = $produkWIP->nama_produk;
        $produkWIP->delete();

        $this->dispatch('toastify', 'Produk '. $namaproduk . ' berhasil dihapus.');
    }
    
    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function updatedSearchTerm()
    {
        if ($this->searchTerm) { // Jika ada input pencarian
            if (empty($this->lastPage)) { 
                $this->lastPage = $this->page; // Simpan halaman saat ini jika pencarian baru dimulai
            }
            $this->resetPage(); // Reset ke halaman 1 saat pencarian berlangsung
        } else {
            if ($this->lastPage) {
                $this->setPage($this->lastPage);
                $this->lastPage = null; // Reset lastPage setelah digunakan
            }
        }
    }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $produkWIP = PoWIP::where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(tanggal_produksi, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(tanggal_produksi, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);
        
        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-produk_wip', [
            'produkWIP' => $produkWIP,
        ]);
    }
}
