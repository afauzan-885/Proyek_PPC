<?php

namespace App\Livewire\POCostumer\POProsesMaterial;

use App\Models\POCostumer\PO_PM_Pemakaian_Material as PoPM;
use App\Models\PersediaanBarang\PBWarehouse as WHModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class POPemakaianMaterialController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // #[Locked]
    public
        $kode_material,
        $jumlah_pengeluaran_material,
        $tgl_pemakaian_mtrial,
        $satuan,
        $no_po;

    public $PoPM_id, $lastPage, $searchTerm = '', $page, $query;

    protected $rules = [
        'kode_material' => 'required',
        'jumlah_pengeluaran_material' => 'required|numeric',
        'tgl_pemakaian_mtrial' => 'required',
        'satuan' => 'required',
        'no_po' => 'required',
    ];

    public function messages()
    {
        return [
            'jumlah_pengeluaran_material.numeric' => 'Hanya angka yang diperbolehkan',
            '*' => 'Form ini tidak boleh kosong'
        ];
    }

    public function validateKodeMaterial()
    {
        $this->validateOnly('kode_material'); // Hanya validasi field 'kode_material'
    }

    public function cari()
    {
        // Validasi apakah kode_material sudah dipilih
        if (!$this->kode_material) {
            if ($this->jumlah_pengeluaran_material) { // Cek apakah user sudah input jumlah_pengeluaran_material
                $this->addError('jumlah_pengeluaran_material', 'Silakan masukkan kode material terlebih dahulu');
            } else {
                $this->resetErrorBag('jumlah_pengeluaran_material');
            }
            return; // Hentikan proses jika kode_material belum dipilih
        }

        // Validasi stok berdasarkan qty
        if ($this->jumlah_pengeluaran_material) {
            // Jika warehouse belum terdefinisi, cari berdasarkan kode_material
            if (!isset($warehouse)) {
                $warehouse = WHModel::where('kode_material', $this->kode_material)->first();
            }

            if (!$warehouse || $this->jumlah_pengeluaran_material > $warehouse->stok_material) {
                $this->addError('stok', 'Stok tidak mencukupi, saat ini tersisa ' . $warehouse->stok_material . ' ' . $warehouse->satuan);
            } else {
                $this->resetErrorBag('jumlah_pengeluaran_material');
                $this->satuan = $warehouse->satuan;
            }
        }
    }


    public function storeData()
    {
        if (!Auth::user()->is_active) {
            Auth::logout();
            // Berikan pesan error dan arahkan ke halaman login
            session()->flash('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
            return redirect()->route('login');
        }
        $validatedData = $this->validate();

        $warehouse = WHModel::firstOrCreate(
            ['kode_material' => $validatedData['kode_material']],
            [
                'satuan' => $validatedData['satuan'],
                // Isi kolom lain yang diperlukan di pb__warehouses jika belum ada
            ]
        );

        if ($warehouse) {
            // 1. Periksa apakah stok mencukupi sebelum mengurangi
            if ($warehouse->stok_material < $validatedData['jumlah_pengeluaran_material']) {
                // Tampilkan pesan error jika stok tidak mencukupi
                session()->flash('error', 'Stok tidak mencukupi.');
                return; // Hentikan proses penyimpanan data
            }

            // 2. Kurangi stok_material dengan jumlah_pengeluaran_material
            $warehouse->stok_material -= $validatedData['jumlah_pengeluaran_material'];

            // 3. Pastikan stok_material tidak bernilai negatif (opsional, jika logika bisnis Anda mengharuskan)
            if ($warehouse->stok_material < 0) {
                $warehouse->stok_material = 0;
            }
            $warehouse->save();

            // ... (kode lainnya untuk menyimpan data ke PoPM, reset form, dll.) 
        } else {
            // Tampilkan pesan error jika data warehouse tidak ditemukan
            session()->flash('error', 'Data warehouse tidak ditemukan.');
        }

        PoPM::create($validatedData);
        sleep(1);

        $namaMaterial = $validatedData['kode_material'];

        $this->reset(
            'kode_material',
            'jumlah_pengeluaran_material',
            'tgl_pemakaian_mtrial',
            'no_po',
            'satuan'
        );
        session()->flash('suksesinput', 'Material ' . $namaMaterial . ' berhasil ditambahkan.');
    }

    public function showData(int $id)
    {
        $validatedData = PoPM::find($id);
        $this->fill($validatedData->toArray());
        $this->PoPM_id = $id;
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate();

            $poPM = PoPM::findOrFail($this->PoPM_id);
            $original_stok = $poPM->jumlah_pengeluaran_material;

            // Ambil data warehouse
            $warehouse = WHModel::where('kode_material', $validatedData['kode_material'])->first();

            if ($warehouse) {
                // Kembalikan stok ke kondisi semula
                $warehouse->stok_material += $original_stok;

                // Validasi langsung pada input user
                if ($validatedData['jumlah_pengeluaran_material'] > $warehouse->stok_material) {
                    // Jika input melebihi stok, tampilkan pesan error dan hentikan proses update
                    session()->flash('error', 'Jumlah pengeluaran material tidak boleh melebihi stok yang tersedia (' . $original_stok . ').');
                    return redirect()->back()->withInput();
                }

                // Lanjutkan update jika input valid
                $warehouse->stok_material -= $validatedData['jumlah_pengeluaran_material'];
                $warehouse->save();

                // Periksa apakah ada perubahan data sebelum melakukan update
                if ($poPM->fill($validatedData)->isDirty()) {
                    PoPM::findOrFail($this->PoPM_id)->update($validatedData);
                    $namaMaterial = $validatedData['kode_material'];
                    session()->flash('suksesupdate', 'Material ' . $namaMaterial . ' berhasil diupdate.');
                } else {
                    session()->flash('suksesupdate', 'Update berhasil, data tidak ada yang berubah.');
                }
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Data kedatangan material tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('error', 'Terjadi kesalahan saat mengupdate data.');
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $pemakaianMaterial = PoPM::findOrFail($id);
        $pemakaianmaterial = $pemakaianMaterial->kode_material;
        $pemakaianMaterial->delete();

        $this->dispatch('toastify', 'Material ' . $pemakaianmaterial . ' berhasil dihapus.');
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

        $pemakaianMaterial = PoPM::with('warehouse')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(REPLACE(REPLACE(tgl_pemakaian_mtrial, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
            })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_material, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(tgl_pemakaian_mtrial, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->paginate(9);

        $warehouse = WHModel::all();

        return view('livewire.po_costumer.tabel.tabel-proses_material.tabel-pemakaian_material', [
            'pemakaianMaterial' => $pemakaianMaterial,
            'warehouse' => $warehouse,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
