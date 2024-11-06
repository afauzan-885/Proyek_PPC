<?php

namespace App\Livewire\PelangganPemasok;

use App\Models\PelangganPemasok\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_supplier, $kode_supplier, $no_telepon_pt, $alamat_supplier,  $kontak_supplier, $email_supplier;
    public $supplier_id, $searchTerm = '', $supplier, $lastPage, $page;

    protected $rules = [
        'nama_supplier' => 'required',
        'kode_supplier' => 'required',
        'no_telepon_pt' => 'required',
        'alamat_supplier' => 'required',
        'kontak_supplier' => 'nullable',
        'email_supplier' => 'nullable',
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
            // 'kode_supplier.unique' => 'Kode yang sama telah ada',
            '*' => 'Form ini tidak boleh kosong'
        ];
    }


    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status

        $validatedData = $this->validate();
        Supplier::create($validatedData);

        $namaSupplier = $validatedData['nama_supplier'];

        $this->reset();
        session()->flash('suksesinput', 'Data ' . $namaSupplier . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = Supplier::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        $this->checkUserActive();
        try {
            $validatedData = $this->validate([
                'nama_supplier' => 'required',
                'kode_supplier' => 'required',
                'no_telepon_pt' => 'required',
                'alamat_supplier' => 'required',
                'kontak_supplier' => 'nullable',
                'email_supplier' => 'nullable',
            ]);

            Supplier::findOrFail($this->supplier_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
        }

        $namaSupplier = $validatedData['nama_supplier'];
        session()->flash('suksesupdate', ' Data ' . $namaSupplier . ' berhasil diupdate.');
    }


    public function closeModal()
    {
        $this->reset();
    }

    public function delete($id)
    {
        $this->checkUserActive();

        $supplier = Supplier::find($id);
        $namaSupplier = $supplier->nama_supplier;
        $supplier->delete();

        $this->dispatch('toastify_sukses',  $namaSupplier . ' berhasil dihapus.');
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

        $Supplier = Supplier::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_supplier, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_supplier, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_supplier, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        return view('livewire.customer_supplier.tabel_supplier', [
            'Suppliers' => $Supplier,
            'user' => Auth::user(),
        ]);
    }
}
