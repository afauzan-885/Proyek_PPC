<?php

namespace App\Livewire\POCostumer;

use App\Models\POCostumer\POKedatanganMaterial as PKMModel;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use App\Models\POCostumer\POPembelianMaterial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class POKedatanganMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
        $nama_material,
        $kode_material,
        $tgl_msk_material,
        $kode_supplier,
        $qty,
        $surat_jalan,
        $harga_material,
        $satuan;

    public $PKM_id, $lastPage, $searchTerm = '', $page, $query;

    protected $rules = [
        'nama_material' => 'required',
        'kode_material' => 'required',
        'tgl_msk_material' => 'required',
        'kode_supplier' => 'required',
        'qty' => 'required',
        'surat_jalan' => 'required',
        'satuan' => 'required',
    ];

    private function checkUserActive()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi admin.');
            return redirect()->route('login');
        }
    }

    public function validateKodeMaterial()
    {
        $this->validateOnly('kode_material'); // Hanya validasi field 'kode_material'
    }

    public function messages()
    {
        return [
            '*' => 'Form ini tidak boleh kosong',
            'kode_material.unique' => 'Kode telah di input sebelumnya',
        ];
    }

    public function cari()
    {
        $pembelianMaterial = POPembelianMaterial::where('kode_material', $this->kode_material)->first();

        if ($pembelianMaterial) {
            $this->nama_material = $pembelianMaterial->nama_material;
            $this->kode_supplier = $pembelianMaterial->kode_supplier;
            $this->harga_material = $pembelianMaterial->harga_material;
        } else {
            $this->addError('kode_material', 'Kode tidak ditemukan');
        }
    }

    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $validatedData = $this->validate();

        // 1. Cari atau buat data di pb__warehouses berdasarkan kode_material
        $warehouse = WHModel::firstOrCreate(
            ['kode_material' => $validatedData['kode_material']],
            [
                'nama_material' => $validatedData['nama_material'],
                'satuan' => $validatedData['satuan'],
                // Isi kolom lain yang diperlukan di pb__warehouses jika belum ada
            ]
        );

        // 2. Update stok_material dan satuan di pb__warehouses
        $warehouse->stok_material += $validatedData['qty'];
        $warehouse->satuan = $validatedData['satuan'];
        $warehouse->harga_material = $this->harga_material ?? 0;

        $warehouse->save();

        $validatedData['kode_material'] = $validatedData['kode_material']['value'];

        PKMModel::create($validatedData);

        $this->reset();
        session()->flash('suksesinput', 'Material berhasil ditambahkan.');
    }



    public function showData(int $id)
    {
        $validatedData = PKMModel::find($id);
        $this->fill($validatedData->toArray());
        $this->PKM_id = $id;
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate();
            // Ambil ulang data model setelah update
            $PbWH = PKMModel::findOrFail($this->PKM_id);

            $original_stok = $PbWH->qty;

            // 2. Cari data di pb__warehouses berdasarkan kode_material
            $warehouse = WHModel::where('kode_material', $validatedData['kode_material'])->first();

            if ($warehouse) {
                // 3. Update stok_material di pb__warehouses jika data ditemukan
                $warehouse->stok_material -= $original_stok;

                // Hitung stok baru setelah update PoFG
                $new_stok = $warehouse->stok_material + $validatedData['qty'];

                // Periksa apakah ada perubahan data sebelum melakukan update
                if ($warehouse->fill($validatedData)->isDirty()) {
                    $warehouse->update([
                        'stok_material' => $new_stok,
                        'satuan' => $validatedData['satuan'],
                    ]);

                    $namaProduk = $validatedData['nama_material'];
                    session()->flash('suksesupdate', 'Material ' . $namaProduk . ' berhasil diupdate.');
                } else {
                    session()->flash('suksesupdate', 'Update berhasil, data tidak ada yang berubah.');
                }
            } else {
                session()->flash('error', 'Stok tidak ditemukan untuk kode barang ini.');
            }

            if ($PbWH->fill($validatedData)->isDirty()) {
                $PbWH = PKMModel::findOrFail($this->PKM_id)->update($validatedData);
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data kedatangan material tidak ditemukan.');
        } catch (\Exception $e) {
            // Log error untuk debugging lebih lanjut
            Log::error($e);
            session()->flash('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $kedatanganMaterial = PKMModel::find($id);
        $kedatanganmaterial = $kedatanganMaterial->nama_material;
        $kedatanganMaterial->delete();

        $this->dispatch('toastify', 'Material ' . $kedatanganmaterial . ' berhasil dihapus.');
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

        $poKedatanganMaterial = PKMModel::where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        // $warehouse = WHModel::all();
        $pembelianMaterial = POPembelianMaterial::all();

        return view('livewire.po_costumer.tabel.tabel-kedatangan_material', [
            'poKedatanganMaterial' => $poKedatanganMaterial,
            // 'warehouse' => $warehouse,
            'pembelianMaterial' => $pembelianMaterial,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
