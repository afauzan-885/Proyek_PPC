<?php

namespace App\Livewire\PersediaanBarang;

use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Lazy;

// #[Lazy(isolate:false)]
class WarehouseController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_material, $status, $nama_material, $ukuran_material, $jumlah_material, $berat, $harga_material, $wh_id, $deskripsi, $stok_material;

    public $lastPage, $searchTerm = '', $page, $query;
    // protected $listeners = ['refreshComponent' => '$refresh'];
    protected $rules = [
        'kode_material' => 'required|unique:pb__warehouses,kode_material',
        'nama_material' => 'required',
        'ukuran_material' => 'required',
        // 'harga_material' => 'required',
        // 'stok_material' => 'required',
        // 'status' => 'required',
        'deskripsi' => 'nullable',
    ];

    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong',
            'kode_material.unique' => 'Kode yang sama telah ada'
        ];
    }

    private function checkUserActive()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi admin.');
            return redirect()->route('login');
        }
    }

    public function storeData()
    {
        $this->checkUserActive();
        $validatedData = $this->validate();
        $hargaKeys = ['harga_material'];

        foreach ($hargaKeys as $hargaKey) {
            if (isset($validatedData[$hargaKey])) {
                $validatedData[$hargaKey] = (float)Str::of($validatedData[$hargaKey])
                    ->replaceMatches('/[^0-9,]/', '')
                    ->replace(',', '.')
                    ->__toString();
            }
        }


        sleep(1);
        WHModel::create($validatedData);

        $this->reset();
        session()->flash('suksesinput', 'Data Warehouse berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datawh = WHModel::findOrFail($id);
            $datawh->harga_material = number_format($datawh->harga_material, 0, ',', '.'); // Format harga untuk tampilan
            $this->fill($datawh->toArray());
            $this->wh_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data Warehouse tidak ditemukan.');
        }
    }

    public function updateData()
    {
        $this->checkUserActive();
        try {
            $validatedData = $this->validate([
                'kode_material' => 'required',
                'nama_material' => 'required',
                'ukuran_material' => 'required',
                'harga_material' => 'required',
                'stok_material' => 'required',
                // 'status' => 'required',
                'deskripsi' => 'nullable',
            ]);

            $validatedData['harga_material'] = (float)preg_replace('/[^\d,]/', '', $validatedData['harga_material']);
            $validatedData['harga_material'] = str_replace(',', '.', $validatedData['harga_material']);

            $warehouse = WHModel::findOrFail($this->wh_id);
            $warehouse->update($validatedData);

            WHModel::findOrFail($this->wh_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data Warehouse berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->checkUserActive();
        $warehouse = WHModel::find($id);
        $namaMaterial = $warehouse->nama_material;
        $warehouse->delete();

        $this->dispatch('toastify', 'Material ' . $namaMaterial . ' berhasil dihapus.');
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

        $warehouses = WHModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        return view('livewire.persediaan_barang.tabel.tabel_wh', [
            'Warehouse' => $warehouses,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
