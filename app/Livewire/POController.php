<?php

namespace App\Livewire;

use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use App\Models\POCostumer\POKedatanganMaterial as PKMModel;
use App\Models\POCostumer\POMasuk as PMModel;
use App\Models\POCostumer\POPembelianMaterial as PPMModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;

class POController extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $warehouses = [];
    public $nama_customer, $tanggal_po, $kode_material, $term_of_payment, $quantity, $no_po, $tanggal_pengiriman, $kode_barang, $total_amount, $tgl_masuk_material, $nama_supplier, $qty_sheet_lyr, $qty_kg, $surat_jalan, $nama_material, $ukuran, $harga_material;
    public $PPM_id, $PM_id, $PKM_id;
    public $activeTab = 'PM';
    public $qty = 0;
    public $total_harga;
    
    public function mount()
    {
        // Ambil semua data CostumerSupplier, eager load untuk optimasi
        $this->warehouses = FGModel::all();
    }
    public function rules()
    {
        switch ($this->activeTab) {
            case 'PM':
                return [
                    'nama_customer' => 'required',
                    'tanggal_po' => 'required',
                    'term_of_payment' => 'required',
                    'qty' => 'required',
                    'no_po'=>'required',
                    'tanggal_pengiriman' => 'required',
                    'kode_barang' => 'required|unique:po__po_masuk,kode_barang',
                    'total_amount' => 'required',
                ];
            case 'PPM':
                return [
                    'kode_material' => 'required|unique:po__kedatangan_material,kode_material',
                    'nama_material' => 'required',
                    'ukuran' => 'required',
                    'quantity' => 'required',
                    'no_po'=>'required',
                    'harga' => 'required|numeric',
                    'total_amount' => 'required|numeric',
                ];
            case 'PKM':
                return [
                    'nama_material' => 'required',
                    'tgl_masuk_material' => 'required',
                    'nama_supplier'=>'required',
                    'qty_sheet_lyr' => 'required|numeric',
                    'qty_kg' => 'required|numeric',
                    'surat_jalan' => 'required|numeric',
                ];
            // Tambahkan case lain untuk tab lainnya
            default:
                return [];
        }
    }

    public function storeData()
    {
        $validatedData = $this->validate();

        // Bersihkan format angka pada kolom yang ditentukan
        $hargaKeys = ['total_amount'];
        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float) str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '') // Hapus karakter selain angka dan koma
                    ->replace(',', '.') // Ganti koma dengan titik (jika perlu)
                    ->__toString(); // Konversi ke string sebelum menjadi float
            }
        }
        
        switch ($this->activeTab) {
            case 'PM':
                PMModel::create($validatedData);
                break;

            case 'PPM':
                PPMModel::create($validatedData);
                break;

            case 'PKM':
                PKMModel::create($validatedData);
                break;

            default:
                break;
        }
        $this->resetExcept('activeTab');
        session()->flash('suksesinput', 'Data berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        switch ($this->activeTab) {
            case 'PM':
                try {
                    $datapm = PMModel::findOrFail($id);
                    $this->fill($datapm->toArray());
                    $this->PM_id = $id;
                    
    
                    // Isi otomatis kolom formulir saat mengedit
                    $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();
                    if ($finishGood) {
                        $this->harga_material = $finishGood->harga;
                        $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                        $this->harga_material = $formatter->formatCurrency($finishGood->harga, 'IDR');
                       
                        $this->total_amount = $datapm->total_amount;
                    }
                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Data tidak ditemukan.');
                }
                break;

            case 'PPM':
                try {
                    $datappm = PPMModel::findOrFail($id);
                    $this->fill($datappm->toArray());
                    $this->PPM_id = $id;
                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Data tidak ditemukan.');
                }
                break;

            case 'PKM':
                try {
                    $datapkm = PKMModel::findOrFail($id);
                    $this->fill($datapkm->toArray());
                    $this->PKM_id = $id;
                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Data tidak ditemukan.');
                }
                break;

            // Tambahkan case lain jika ada tab tambahan
            default:
                break;
        }
    }

    public function updateData()
    {
        try {
            switch ($this->activeTab) {
                case 'PM':
                    $validatedData = $this->validate([
                        'nama_customer' => 'required',
                        'term_of_payment' => 'required',
                        'tanggal_po' => 'required',
                        'qty' => 'required',
                        'no_po' => 'required',
                        'tanggal_pengiriman' => 'required',
                        'kode_barang' => 'required',
                        'total_amount' => 'required',
                    ]);

                     // Pembersihan harga yang lebih ringkas
                $validatedData['total_amount'] = (float) preg_replace('/[^\d,]/', '', $validatedData['total_amount']); // Hapus karakter selain angka dan koma
                $validatedData['total_amount'] = str_replace(',', '.', $validatedData['total_amount']); // Ganti koma dengan titik

                    PMModel::findOrFail($this->PM_id)->update($validatedData);
                    break;

                case 'PPM':
                    $validatedData = $this->validate([
                        'kode_material' => 'required',
                        'nama_material' => 'required',
                        'ukuran_material' => 'required',
                        'jumlah_material' => 'required',
                        'berat' => 'required',
                        'harga_material' => 'required',
                    ]);

                    PPMModel::findOrFail($this->PPM_id)->update($validatedData);
                    break;

                case 'PKM':
                    $validatedData = $this->validate([
                        'nama_material' => 'required',
                        'ukuran_material' => 'required',
                        'jumlah_material' => 'required',
                        'berat' => 'required',
                        'harga_material' => 'required',
                    ]);

                    PKMModel::findOrFail($this->PKM_id)->update($validatedData);
                    break;

                default:
                    // Handle case jika activeTab tidak valid (opsional)
                    break;
            }          
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data berhasil diupdate.');
    }

    public function updated($propertyName)
    {
        switch ($propertyName) {
            case 'qty':
                $this->hitungTotalAmount();
                break;

            case 'kode_barang':
                
                $finishGood = FGModel::where('kode_barang', $this->kode_barang)->first();
                if (in_array($propertyName, ['qty', 'kode_barang'])) {
                    $this->hitungTotalAmount();
                    $this->harga_material = $finishGood->harga;
        
                    // Format harga dengan pemisah ribuan
                    $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
                    $this->harga_material = $formatter->formatCurrency($finishGood->harga, 'IDR');
                    $this->total_amount = $finishGood->total_amount;
        
                    $this->dispatch('updateTotalAmount');
                    $this->hitungTotalAmount(); // Hitung total amount setelah harga terisi
                } else {
                    $this->reset(['nama_customer', 'harga_material', 'total_harga']);
                    session()->flash('message', 'Kode barang tidak valid.');
                }
                break;
                
                // Tambahkan case lain sesuai kebutuhan
                default:
                // Logika jika tidak ada properti yang cocok
                break;
        }
    }

    private function hitungTotalAmount()
    {
        // Pastikan harga_material adalah angka sebelum dikalikan
        $harga_input = (float) str_replace(['.', ','], ['', '.'], $this->harga_material); 
        
        $this->total_amount = $harga_input * $this->qty;

        // Format kembali total_amount
        $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
        $this->total_amount = $formatter->formatCurrency($this->total_amount, 'IDR');
    }


    public function delete($id)
    {
        try {
            switch ($this->activeTab) {
                case 'PM':
                    PMModel::findOrFail($id)->delete();
                    session()->flash('sukseshapus', 'Data Finish Good berhasil dihapus.');
                    break;

                case 'PPM':
                    PPMModel::findOrFail($id)->delete();
                    session()->flash('sukseshapus', 'Data Pembelian Material berhasil dihapus.'); // Sesuaikan pesan
                    break;

                case 'PKM':
                    PKMModel::findOrFail($id)->delete();
                    session()->flash('sukseshapus', 'Data Kedatangan Material berhasil dihapus.'); // Sesuaikan pesan
                    break;

                default:
                    // Handle case jika activeTab tidak valid (opsional)
                    break;
            }
            
            // $this->emit('dataDeleted', ['model' => $this->activeTab]); // Emit event untuk update data

        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }


    public function closeModal()
    {
       $this->resetExcept('activeTab'); 
        $this->resetErrorBag();
        $this->resetValidation(); 
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function render()
    {
        $poMasuk = PMModel::paginate(10);
        $poPembelianMaterial = PPMModel::paginate(10);
        $poKedatanganMaterial = PKMModel::paginate(10);
        $warehouse = FGModel::all();

        return view('livewire.po-costumer', [
            'poMasuk' => $poMasuk,
            'poPembelianMaterial' => $poPembelianMaterial,
            'poKedatanganMaterial' => $poKedatanganMaterial,
            'activeTab' => $this->activeTab,
        ])
        ->with('warehouse', $warehouse); // Pass data ke view
    }
}
