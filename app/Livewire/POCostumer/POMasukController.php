<?php

namespace App\Livewire\POCostumer;

use App\Models\PelangganPemasok\Customer;
use App\Models\POCostumer\POMasuk as PMModel;
use App\Models\PersediaanBarang\PBfinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use NumberFormatter;
use Illuminate\Support\Str;

use Livewire\WithPagination;

class POMasukController extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['poMasukUpdated'];

    public $kode_customer, $tanggal_po, $term_of_payment, $qty, $no_po, $tanggal_pengiriman, $kode_barang, $total_amount, $harga;
    public $PM_id, $costumersupplier, $lastPage, $searchTerm = '', $page, $query;
    protected $rules = [
        'kode_customer' => 'required',
        'tanggal_po' => 'required',
        'term_of_payment' => 'required',
        'qty' => 'required',
        'harga' => 'required',
        'no_po' => 'required|unique:po__po_masuk',
        'tanggal_pengiriman' => 'required',
        'kode_barang' => 'required',
        'total_amount' => 'required',
    ];


    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong',
            'no_po.unique' => 'No. PO ini sudah ada.',
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
        function toFloat($value)
        {
            return (float) Str::of($value)
                ->replaceMatches('/[^0-9,]/', '')
                ->replace(',', '.')
                ->__toString();
        }

        $validatedData['total_amount'] = toFloat($validatedData['total_amount']);
        $validatedData['harga'] = toFloat($validatedData['harga']);
        $validatedData['total_pesanan'] = $validatedData['qty'];


        $validatedData['kode_barang'] = $validatedData['kode_barang']['value'];
        $validatedData['kode_customer'] = $validatedData['kode_customer']['value'];

        PMModel::create($validatedData);

        $namaCustomer = $validatedData['kode_customer'];

        $this->reset();
        session()->flash('suksesinput',   $namaCustomer . ' berhasil ditambahkan.');
        $this->dispatch('dataStored');
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
        $customer = Customer::where('kode_customer', $this->kode_customer)->first();

        if ($finishGood && $customer) {
            $this->harga = $finishGood->harga;


            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $this->harga = $formatter->formatCurrency($finishGood->harga, 'IDR');
            $this->resetErrorBag(['kode_barang', 'kode_customer']);
        } else {
            $errorMessages = []; // Array untuk mengumpulkan pesan error

            if (!$finishGood) {
                $errorMessages[] = 'Kode barang tidak ditemukan.';
            }
            if (!$customer) {
                $errorMessages[] = 'Nama customer tidak ditemukan.';
            }

            // Gabungkan pesan error dan tambahkan ke 'errorBag'
            $this->addError('search', implode(' ', $errorMessages));
        }
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {

            $validatedData = $this->validate([
                'kode_customer' => 'required',
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
            $validatedData['total_pesanan'] = $validatedData['qty'];

            $validatedData['total_amount'] = $validatedData['qty'] * $hargaPerQty;

            // Ekstrak nilai 'value' dari 'kode_barang' hanya jika 'kode_barang' adalah array
            if (is_array($validatedData['kode_barang'])) {
                $validatedData['kode_barang'] = $validatedData['kode_barang']['value'];
            }

            PMModel::findOrFail($this->PM_id)->update($validatedData);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        $namaCustomer = $validatedData['kode_customer'];
        session()->flash('suksesupdate', 'Data ' . $namaCustomer . ' berhasil diupdate.');
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
                    $this->reset(['kode_customer', 'harga', 'total_amount']);
                    session()->flash('message', 'Kode barang tidak valid.');
                }
                break;
        }
    }



    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $pomasuk = PMModel::find($id);
        $kodeCustomer = $pomasuk->kode_customer;
        $pomasuk->delete();

        $this->dispatch('toastify', 'Customer ' . $kodeCustomer . ' berhasil dihapus.');
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

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $poMasuk = PMModel::with('finishgoods', 'Customer')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(kode_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(term_of_payment, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(term_of_payment, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $finishgoods = FGModel::all();
        $Customer = Customer::all();

        // $this->searchCustomers(); // Panggil fungsi searchCustomers

        return view('livewire.po_costumer.tabel.tabel-po_masuk', [
            'poMasuk' => $poMasuk,
            'finishgoods' => $finishgoods,
            'Customer' => $Customer,
            'user' => Auth::user(),
            // 'costumersupplier' => $this->costumersupplier,
        ]);
    }
}
