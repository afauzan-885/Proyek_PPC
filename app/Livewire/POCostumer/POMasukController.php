<?php
namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POMasuk as PMModel;
use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;

class POMasukController extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $nama_customer, $tanggal_po, $term_of_payment, $qty, $no_po, $tanggal_pengiriman, $kode_barang, $total_amount, $harga;
    public $PM_id;

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

    public function storeData()
    {
        $validatedData = $this->validate();

        $validatedData['total_amount'] = (float) Str::of($validatedData['total_amount'])
            ->replaceMatches('/[^0-9,]/', '')
            ->replace(',', '.')
            ->__toString();

        PMModel::create($validatedData);
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

    public function cariHarga()
    {
        $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();

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
               
        //Logika Untuk menghilangkan pembatas ribuan
        $validatedData['total_amount'] = preg_replace('/[^0-9]/', '', $validatedData['total_amount']);
        $validatedData['total_amount'] = (float) $validatedData['total_amount'];
        $hargaPerQty = (float) str_replace(['.', ','], ['', '.'], $this->harga);
        $validatedData['total_amount'] = $validatedData['qty'] * $hargaPerQty;

        PMModel::findOrFail($this->PM_id)->update($validatedData);
            
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
        PMModel::findOrFail($id)->delete();
        session()->flash('sukseshapus', 'Data PO Masuk berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function render()
    {
        $poMasuk = PMModel::paginate(10);
        $warehouses = FGModel::all();
        
        return view('livewire.po_costumer.tabel.tabel-po_masuk', [
            'poMasuk' => $poMasuk,
        ])->with('warehouses', $warehouses);
    }

}