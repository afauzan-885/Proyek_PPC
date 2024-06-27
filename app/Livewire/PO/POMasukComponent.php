<?php

namespace App\Livewire\PO;

use App\Models\PersediaanBarang\PBFinishGood;
use Livewire\Component;
use App\Models\POCostumer\POMasuk as PMModel; // Model untuk PO Masuk
use NumberFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Untuk penanganan error

class POMasukComponent extends Component
{
    // Properti untuk form
    public $nama_customer, $tanggal_po, $term_of_payment, $quantity, $no_po, $tanggal_pengiriman, $kode_barang, $total_amount, $harga_material;
    public $PM_id;  // Untuk update
    public $qty = 0; // Inisialisasi qty dengan 0
    public $pomasukdata;

    // Rules validasi untuk form
    protected $rules = [
        'nama_customer' => 'required',
        'tanggal_po' => 'required',
        'term_of_payment' => 'required',
        'quantity' => 'required',
        'no_po' => 'required',
        'tanggal_pengiriman' => 'required',
        'kode_barang' => 'required|unique:po__po_masuk,kode_barang',
        'total_amount' => 'required',
    ];

    public function mount($pomasukdata)
    {
        $this->pomasukdata = $pomasukdata;
    }

    // Fungsi untuk menampilkan data saat modal dibuka
    public function showData(int $id)
    {
        try {
            $datapm = PMModel::findOrFail($id);
            $this->fill($datapm->toArray());
            $this->PM_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    // Fungsi untuk memperbarui data
    public function updateData()
    {
        $this->validate();

        try {
            PMModel::findOrFail($this->PM_id)->update([
                'nama_customer' => $this->nama_customer,
                'tanggal_po' => $this->tanggal_po,
                'term_of_payment' => $this->term_of_payment,
                'quantity' => $this->quantity,
                'no_po' => $this->no_po,
                'tanggal_pengiriman' => $this->tanggal_pengiriman,
                'kode_barang' => $this->kode_barang,
                'total_amount' => $this->total_amount,
            ]);
            session()->flash('suksesupdate', 'Data berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }
  
    // Fungsi untuk menambahkan data baru
    public function storeData()
    {
        $validatedData = $this->validate();
        PMModel::create($validatedData);

        $this->resetExcept('activeTab'); 
        session()->flash('suksesinput', 'Data berhasil ditambahkan.');
        $this->emit('refreshParent');
    }
  
     // Fungsi untuk menghapus data
    public function delete($id)
    {
        try {
            PMModel::findOrFail($id)->delete();
            session()->flash('sukseshapus', 'Data PO Masuk berhasil dihapus.');
            $this->emit('refreshParent');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function updatedKodeBarang($value)
    {
        // Cari data finish good berdasarkan kode barang
        $finishGood = PBFinishGood::where('kode_barang', $value)->first();
  
        if ($finishGood) {
            $this->harga_material = $finishGood->harga;
            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $this->harga_material = $formatter->formatCurrency($finishGood->harga, 'IDR');
        } else {
            $this->reset(['nama_customer', 'harga_material', 'harga_material_asli']);
            session()->flash('message', 'Kode barang tidak valid.');
        }
    }
    public function updatedQty()
    {
        $this->hitungTotalAmount();
    }

    public function updatedHargaMaterial()
    {
        $this->hitungTotalAmount();
    }

    public function hitungTotalAmount()
    {
        // Pastikan kedua nilai terisi dan valid (numerik)
        if (is_numeric($this->harga_material) && is_numeric($this->qty)) {
            $hargaBersih = preg_replace('/[^0-9]/', '', $this->harga_material);
            $this->total_amount = $hargaBersih * $this->qty;

            // Format total_amount dengan tanda baca
            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $this->total_amount = $formatter->formatCurrency($this->total_amount, 'IDR');
        } else {
            $this->total_amount = 0;
        }
    }


    public function closeModal()
    {
        $this->resetExcept('activeTab', 'kode_barang'); // kode_barang dikecualikan
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.po-costumer.po-masuk-component');
    }
}
