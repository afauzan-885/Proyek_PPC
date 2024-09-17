<?php

namespace App\Livewire\PersediaanBarang;

use App\Models\PersediaanBarang\PBWIP as WIPModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class WIPController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //Public wip
    public
        $kode_barang,
        $nama_barang,
        $jenis_proses,
        $stok_barang,
        $status,
        $wip_id;

    public $lastPage, $searchTerm = '', $page, $query;

    // protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'kode_barang' => 'required|unique:pb__wip,kode_barang',
        'nama_barang' => 'required',
        'jenis_proses' => 'required',
        // 'stok_barang' => 'required',
        // 'status' => 'required',
    ];

    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong',
            'kode_barang.unique' => 'Kode yang sama telah ada'
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

        sleep(1);
        WIPModel::create($validatedData);

        $this->reset();
        session()->flash('suksesinput', 'Data wip berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        try {
            $datawh = WIPModel::findOrFail($id);
            $datawh->harga_material = number_format($datawh->harga_material, 0, ',', '.'); // Format harga untuk tampilan
            $this->fill($datawh->toArray());
            $this->wip_id = $id;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data WIP tidak ditemukan.');
        }
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate([
                'kode_barang' => 'required',
                'nama_barang' => 'required',
                'jenis_proses' => 'required',
                'stok_barang' => 'required',
                'status' => 'required',
            ]);

            $wip = WIPModel::findOrFail($this->wip_id);
            $wip->update($validatedData);

            WIPModel::findOrFail($this->wip_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }
        session()->flash('suksesupdate', 'Data wip berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $wip = WIPModel::find($id);
        $namaBarang = $wip->nama_barang;
        $wip->delete();

        $this->dispatch('toastify', 'Barang ' . $namaBarang . ' berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $wips = WIPModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);
        return view('livewire.persediaan_barang.tabel.tabel_wip', [
            'Wip' => $wips,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
