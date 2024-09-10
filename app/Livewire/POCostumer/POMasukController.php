<?php
namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POMasuk as PMModel;
use App\Models\CostumerSupplier as CSModel;
use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class POMasukController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['poMasukUpdated']; 

    public $nama_customer, $tanggal_po, $term_of_payment, $qty, $no_po, $tanggal_pengiriman, $kode_barang, $total_amount, $harga;
    public $PM_id, $costumersupplier, $lastPage, $searchTerm='', $page, $query;
    protected $rules = [
        'nama_customer' => 'required',
        'tanggal_po' => 'required',
        'term_of_payment' => 'required',
        'qty' => 'required',
        'harga' => 'required',
        'no_po' => 'required',
        'tanggal_pengiriman' => 'required',
        'kode_barang' => 'required',
        'total_amount' => 'required',
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

        function toFloat($value) {
            return (float) Str::of($value)
                ->replaceMatches('/[^0-9,]/', '')
                ->replace(',', '.')
                ->__toString();
        }
        
        $validatedData['total_amount'] = toFloat($validatedData['total_amount']);
        $validatedData['harga'] = toFloat($validatedData['harga']);

        PMModel::create($validatedData);
        sleep(1);

        $namaCustomer = $validatedData['nama_customer'];
        $this->reset();
        session()->flash('suksesinput',   $namaCustomer . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datapm = PMModel::findOrFail($id);
            $this->fill($datapm->toArray());
            $this->PM_id = $id;

            $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();
            if ($finishGood) {
                $this->harga = $finishGood->harga;
                $datapm->total_amount = number_format($datapm->total_amount, 0, ',', '.'); // Format harga untuk tampilan
                $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                $this->harga = $formatter->formatCurrency($finishGood->harga, 'IDR');

                $this->total_amount = $datapm->total_amount;
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function cari()
    {
        $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();
        sleep(1);
        if ($finishGood) {
            $this->harga = $finishGood->harga;
            
            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $this->harga = $formatter->formatCurrency($finishGood->harga, 'IDR');
            $this->resetErrorBag('kode_barang'); // Reset error jika data ditemukan
        } else {
            $this->addError('kode_barang', 'Kode barang tidak ditemukan.');
        }
    }

    public function updateData()
    {
        try {

            $validatedData = $this->validate([
                'nama_customer' => 'required',
                'tanggal_po' => 'required',
                'term_of_payment' => 'required',
                'qty' => 'required',
                'no_po' => 'required',
                'tanggal_pengiriman' => 'required',
                'kode_barang' => 'required',
                'total_amount' => 'required',
            ]);
            sleep(1);
       
        //Logika Untuk menghilangkan pembatas ribuan
        $validatedData['total_amount'] = preg_replace('/[^0-9]/', '', $validatedData['total_amount']);
        $validatedData['total_amount'] = (float) $validatedData['total_amount'];
        $hargaPerQty = (float) str_replace(['.', ','], ['', '.'], $this->harga);
        $validatedData['total_amount'] = $validatedData['qty'] * $hargaPerQty;

        PMModel::findOrFail($this->PM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        $namaCustomer = $validatedData['nama_customer'];
        session()->flash('suksesupdate', 'Data ' .$namaCustomer. ' berhasil diupdate.');
    }

    public function updated($propertyName)
    {
        switch ($propertyName) {
            case 'qty':
                $this->hitungTotalAmount();
                break;

            case 'kode_barang':
                $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();
                if ($finishGood) {
                    $this->hitungTotalAmount(); 
                    $this->harga = $finishGood->harga;
                    $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                    $this->harga = $formatter->formatCurrency($finishGood->harga, 'IDR');
                    $this->total_amount = $finishGood->total_amount;
                    $this->hitungTotalAmount(); 
                } else {
                    $this->reset(['nama_customer', 'harga', 'total_harga']);
                    session()->flash('message', 'Kode barang tidak valid.');
                }
                break;
        }
    }

    private function hitungTotalAmount()
    {
        //Membersihkan angka sebelum melakukan operasi perhitungan
        $harga_input = (float) str_replace(['.', ','], ['', '.'], $this->harga); 

        $this->total_amount = $harga_input * $this->qty;

        //Format Kembali untuk ditampilkan pada total amount
        $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
        $this->total_amount = $formatter->formatCurrency($this->total_amount, 'IDR');
    }

    public function delete($id)
    {
        $pomasuk = PMModel::find($id);
        $namaCustomer = $pomasuk->nama_customer;
        $pomasuk->delete();

        $this->dispatch('toastify', 'Customer '. $namaCustomer . ' berhasil dihapus.');
        // session()->flash('sukseshapus', 'Data PO Masuk berhasil dihapus.');
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

    // public function searchCustomers()
    // {
    //     if (strlen($this->searchCustomer) >= 1) {
    //         $this->costumersupplier = CSModel::where('nama_costumer', 'like', '%' . $this->searchCustomer . '%')->limit(7)->get();
    //     } else {
    //         $this->costumersupplier = [];
    //     }
    // }

   
    public function render()
    {
        // $result = [];

        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $poMasuk = PMModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(term_of_payment, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(term_of_payment, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
        ->paginate(9);

        $finishgoods = FGModel::all();

        // $this->searchCustomers(); // Panggil fungsi searchCustomers

        return view('livewire.po_costumer.tabel.tabel-po_masuk', [
            'poMasuk' => $poMasuk,
            'finishgoods' => $finishgoods,
            // 'costumersupplier' => $this->costumersupplier,
        ]);
    }
        

}