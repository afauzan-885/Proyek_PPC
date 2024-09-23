<?php

namespace App\Livewire\PelangganPemasok;

use App\Models\PelangganPemasok\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_customer, $kode_customer, $no_telepon_pt, $alamat_customer,  $kontak_customer, $email_customer;
    public $customer_id, $searchTerm = '', $Customer, $lastPage, $page;

    protected $rules = [
        'nama_customer' => 'required',
        'kode_customer' => 'required',
        'no_telepon_pt' => 'required',
        'alamat_customer' => 'required',
        'kontak_customer' => 'nullable',
        'email_customer' => 'nullable',
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
            'kode_customer.unique' => 'Kode yang sama telah ada',
            '*' => 'Form ini tidak boleh kosong'
        ];
    }


    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status

        $validatedData = $this->validate();
        Customer::create($validatedData);

        $namaCustomer = $validatedData['nama_customer'];

        $this->reset('nama_customer', 'kode_customer', 'no_telepon_pt', 'alamat_customer', 'kontak_customer', 'email_customer');
        session()->flash('suksesinput', 'Data ' . $namaCustomer . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = Customer::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate([
                'nama_customer' => 'required',
                'kode_customer' => 'required',
                'no_telepon_pt' => 'required',
                'alamat_customer' => 'required',
                'kontak_customer' => 'nullable',
                'email_customer' => 'nullable',
            ]);

            Customer::findOrFail($this->customer_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            // session()->flash('error', 'Data customer tidak ditemukan.');
        }

        $namacustomer = $validatedData['nama_customer'];
        session()->flash('suksesupdate', ' Data ' . $namacustomer . ' berhasil diupdate.');
    }


    public function closeModal()
    {
        $this->reset();
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status

        $customer = Customer::find($id);
        $namaCustomer = $customer->nama_customer;
        $customer->delete();

        $this->dispatch('toastify',  $namaCustomer . ' berhasil dihapus.');
        // Tampilkan pesan flash dengan nama customer
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

        $Customer = Customer::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        return view('livewire.customer_supplier.tabel_customer', [
            'Customers' => $Customer,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
