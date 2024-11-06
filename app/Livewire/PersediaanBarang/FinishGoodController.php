<?php

namespace App\Livewire\PersediaanBarang;

use App\Models\PelangganPemasok\Customer;
use App\Models\PersediaanBarang\PBFinishGood as FGModel;
use App\Models\POCostumer\POMasuk;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class FinishGoodController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $query;

    public $kode_barang, $nama_barang, $no_part, $harga, $tipe_barang, $deskripsi, $stok_material;

    public $fg_id,  $searchTerm = '', $lastPage, $page;

    protected $rules = [
        'kode_barang' => 'required|unique:pb__finish_goods,kode_barang',
        'nama_barang' => 'required',
        'no_part' => 'required',
        // 'stok_material' => 'required',
        'harga' => 'required',
        'tipe_barang' => 'required',
        // 'status' => 'required',
    ];

    private function checkUserActive()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi admin.');
            return redirect()->route('login');
        }
    }

    public function messages()
    {
        return [
            'kode_barang.unique' => 'kode barang yang sama telah ada',
            '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function storeData()
    {
        $this->checkUserActive();
        $validatedData = $this->validate();
    
        $hargaKeys = ['harga'];
    
        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float)Str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '')
                    ->replace(',', '.')
                    ->__toString();
            }
        }

        $validatedData['stok_material'] = 0;
    
        FGModel::create($validatedData);
        sleep(1);
    
        $this->reset(); // Reset all input fields after saving
        session()->flash('suksesinput', 'Item ' . $validatedData['nama_barang'] . ' dengan kode ' . $validatedData['kode_barang'] . ' berhasil ditambahkan.');
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
        $this->checkUserActive();
        try {
            $validatedData = $this->validate([
                'kode_barang' => 'required',
                'nama_barang' => 'required',
                'no_part' => 'required',
                'stok_material' => 'required',
                'harga' => 'required',
                'tipe_barang' => 'required',
            ]);

            $validatedData['harga'] = (float) str_replace('.', '', $validatedData['harga']);
            $validatedData['harga'] = str_replace(',', '.', $validatedData['harga']);

            $fg = FGModel::findOrFail($this->fg_id);
            $fg->update($validatedData);

           // Replikasi logika trigger 
           $poMasuk = POMasuk::where('kode_barang', $fg->kode_barang)->first();

           if ($poMasuk) {
               POMasuk::where('kode_barang', $fg->kode_barang)
                   ->update([
                       'kode_barang' => $fg->kode_barang,
                       'harga' => $fg->harga,
                       'total_amount' => $fg->harga * $poMasuk->total_pesanan
                   ]);
           }

        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Item ' . $fg->nama_barang . ' dengan kode ' . $fg->kode_barang . ' berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->checkUserActive();

        $finishgood = FGModel::find($id);
        $namaBarang = $finishgood->nama_barang;
        $finishgood->delete();

        $this->dispatch('toastify_sukses',  $namaBarang . ' berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.tabel_placeholder', $params);
    }

    public function updatedSearchTerm()
    {
        if ($this->searchTerm) {
            if (empty($this->lastPage)) {
                $this->lastPage = $this->page;
            }
            $this->resetPage();
        } else {
            if ($this->lastPage) {
                $this->setPage($this->lastPage);
                $this->lastPage = null;
            }
        }
    }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $finishGoods = FGModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);


        $costumerSuppliers = Customer::all(); // Ambil data dari model CostumerSupplier
        return view('livewire.persediaan_barang.tabel.tabel_fg', [
            'finishGoods' => $finishGoods,
            'user' => Auth::user(), // Pass the authenticated user
        ])
            ->with('costumerSuppliers', $costumerSuppliers); // Pass data ke view
    }
}
