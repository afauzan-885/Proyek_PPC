<?php

namespace App\Livewire;

use App\Models\CostumerSupplier as CSModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

#[Computed]
class CSController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_costumer, $kode_costumer, $no_telepon_pt, $alamat_costumer,  $kontak_costumer, $email_costumer;
    public $cs_id, $searchTerm = '', $CostumerSuppliers, $lastPage, $page;

    protected $rules = [
        'nama_costumer' => 'required',
        'kode_costumer' => 'required|unique:costumer_suppliers',
        'no_telepon_pt' => 'required',
        'alamat_costumer' => 'required',
        'kontak_costumer' => 'required',
        'email_costumer' => 'required',
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
            'kode_costumer.unique' => 'Kode yang sama telah ada',
            '*' => 'Form ini tidak boleh kosong'
        ];
    }


    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status

        $validatedData = $this->validate();
        CSModel::create($validatedData);

        $namaCustomer = $validatedData['nama_costumer'];

        $this->reset('nama_costumer', 'kode_costumer', 'no_telepon_pt', 'alamat_costumer', 'kontak_costumer', 'email_costumer');
        session()->flash('suksesinput', 'Data ' . $namaCustomer . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = CSModel::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate([
                'nama_costumer' => 'required',
                'kode_costumer' => 'required',
                'no_telepon_pt' => 'required',
                'alamat_costumer' => 'required',
                'kontak_costumer' => 'required',
                'email_costumer' => 'required',
            ]);

            CSModel::findOrFail($this->cs_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            // session()->flash('error', 'Data customer tidak ditemukan.');
        }

        $namacostumer = $validatedData['nama_costumer'];
        session()->flash('suksesupdate', ' Data ' . $namacostumer . ' berhasil diupdate.');
    }


    public function closeModal()
    {
        $this->reset();
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status

        $customer = CSModel::find($id);
        $namaCustomer = $customer->nama_costumer;
        $customer->delete();

        $this->dispatch('toastify',  $namaCustomer . ' berhasil dihapus.');
        // Tampilkan pesan flash dengan nama customer
    }

    public function placeholder(array $params = [])
    {

        return view('livewire.placeholder.costumer_supplier_placeholder', $params);
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

        $CostumerSuppliers = CSMOdel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_costumer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_costumer, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_costumer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);
        // $CostumerSuppliers = CSModel::paginate(9);

        return view('livewire.costumer-supplier', [
            'cs' => $CostumerSuppliers,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
