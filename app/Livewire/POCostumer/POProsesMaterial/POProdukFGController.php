<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_FgProduct as PoFG;
use App\Models\PersediaanBarang\PBFinishGood as FGModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class POProdukFGController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
        $kode_produk,
        $nama_produk,
        $shift_produksi,
        $qty_awal,
        $qty_in;

    public $PoFG_id, $lastPage, $searchTerm = '', $page, $query, $kode_barang;

    protected $rules = [
        // 'kode_produk' =>'required|unique:po__pm__produk_fg,kode_produk',
        'kode_produk' => 'required',
        'nama_produk' => 'required',
        'shift_produksi' => 'required',
        'qty_awal' => 'required',
        'qty_in' => 'required',
        // 'qty_out' => 'required',
    ];

    public function validateKodeMaterial()
    {
        $this->validateOnly('kode_produk'); // Hanya validasi field 'kode_material'
    }

    public function messages()
    {
        return [
            'kode_produk.unique' => 'kode yang sama telah ada',
            '*' => 'Form ini tidak boleh kosong'
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

    public function cari()
    {
        $finishgood = FGModel::where('kode_barang', $this->kode_produk)->first();

        if ($finishgood) {
            $this->nama_produk = $finishgood->nama_barang;
            $this->qty_awal = $finishgood->stok_material;
            $this->resetErrorBag('kode_produk');
        } else {
            $this->addError('kode_produk', 'Kode tidak ditemukan');
        }
    }

    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $validatedData = $this->validate();

        $finishgood = FGModel::firstOrCreate(
            ['kode_barang' => $validatedData['kode_produk']],
            [
                'nama_barang' => $validatedData['nama_produk'],
            ]
        );

        // Update stok_material dengan menambahkan qty_in
        $finishgood->stok_material += $validatedData['qty_in'];
        $finishgood->save();
        $validatedData['kode_produk'] = $validatedData['kode_produk']['value'];

        PoFG::create($validatedData);
        sleep(1);

        $namaproduk = $validatedData['nama_produk'];
        $this->reset(
            'kode_produk',
            'nama_produk',
            'shift_produksi',
            'qty_awal',
            'qty_in'
        );
        session()->flash('suksesinput', 'Material ' . $namaproduk . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = PoFG::find($id);
        $this->fill($validatedData->toArray());
        $this->PoFG_id = $id;
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate();
            $PoFG = PoFG::findOrFail($this->PoFG_id);

            $original_stok = $PoFG->qty_in;

            // Dapatkan data WIP saat ini
            $fg = FGModel::where('kode_barang', $validatedData['kode_produk'])->first();

            if ($fg) {
                // Kembalikan stok ke kondisi semula (sebelum update PoFG ini)
                $fg->stok_material -= $original_stok;

                // Hitung stok baru setelah update PoFG
                $new_stok = $fg->stok_material + $validatedData['qty_in'];

                // Memastikan stok tidak negatif
                if ($new_stok < 0) {
                    session()->flash('error', 'Edit stok tidak boleh membuat stok gudang menjadi negatif.');
                    return redirect()->back()->withInput();
                }

                // Periksa apakah ada perubahan data sebelum melakukan update
                if ($fg->fill($validatedData)->isDirty()) {
                    $fg->update([
                        'stok_material' => $new_stok,
                        // '?????' => $validatedData['?????'],
                    ]);

                    $namaProduk = $validatedData['nama_produk'];
                    session()->flash('suksesupdate', 'Produk ' . $namaProduk . ' berhasil diupdate.');
                } else {
                    session()->flash('suksesupdate', 'Update berhasil, data tidak ada yang berubah.');
                }
            } else {
                // Tangani kasus di mana WIP tidak ditemukan
                session()->flash('error', 'Data FG tidak ditemukan untuk kode barang ini.');
            }

            // Periksa apakah ada perubahan data sebelum melakukan update pada PoFG
            if ($PoFG->fill($validatedData)->isDirty()) {
                PoFG::findOrFail($this->PoFG_id)->update($validatedData);
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('error', 'Terjadi kesalahan saat mengupdate data.');
        }

        return redirect()->back();
    }




    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $produkFG = PoFG::find($id);
        $namaproduk = $produkFG->nama_produk;
        $produkFG->delete();

        $this->dispatch('toastify', 'Produk ' . $namaproduk . ' berhasil dihapus.');
        // session()->flash('sukseshapus', 'Data berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->resetExcept('activeTab');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $searchTerm = '%' . strtolower(str_replace([' ', '.'], '', $this->searchTerm)) . '%';

        $produkFG = PoFG::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            // ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_barang, " ", ""), ".", "")) LIKE ?', [$searchTerm])
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_produk, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $finishgoods = FGModel::all();

        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-produk_fg', [
            'produkFG' => $produkFG,
            'finishgood' => $finishgoods,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
