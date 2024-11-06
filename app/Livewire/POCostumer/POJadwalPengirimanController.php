<?php

namespace App\Livewire\POCostumer;

use App\Models\PersediaanBarang\PBFinishGood;
use App\Models\POCostumer\POJadwalPengiriman as PJPModel;
use App\Models\POCostumer\POMasuk as PMModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class POJadwalPengirimanController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public
        $kode_customer,
        $no_po,
        $permintaan_po,
        $pengeluaran_barang,
        $tanggal_keluar_pt,
        $surat_jalan;

    public $PJP_id, $lastPage, $searchTerm = '', $page, $query;

    protected $rules = [
        'kode_customer' => 'required',
        'no_po' => 'required',
        'permintaan_po' => 'required',
        'pengeluaran_barang' => 'required',
        'tanggal_keluar_pt' => 'required',
        'surat_jalan' => 'required',
    ];

    public function messages()
    {
        return [
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
        $pomasuk = PMModel::where('no_po', $this->no_po)->first();
        sleep(1);
        if ($pomasuk) {
            $this->permintaan_po = $pomasuk->qty;
            $this->kode_customer = $pomasuk->kode_customer;
        } else {
            $this->addError('no_po', 'No. PO tidak ditemukan.');
        }
    }

    public function storeData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $validatedData = $this->validate();

        $pomasuk = PMModel::firstOrCreate(
            ['no_po' => $validatedData['no_po']],
            [
                'kode_customer' => $validatedData['kode_customer'],
            ]
        );

        if ($pomasuk) {
            // Validasi pengeluaran_barang
            if ($validatedData['pengeluaran_barang'] > $pomasuk->qty) {
                session()->flash('error', 'Jumlah pengiriman melebihi batas PO.');
                return; // Hentikan proses penyimpanan data
            }

            // Ambil kode_barang dari $pomasuk
            $kode_barang = $pomasuk->kode_barang;

            // Ambil data finishgood berdasarkan kode_barang dari $pomasuk
            $finishgood = PBFinishGood::where('kode_barang', $kode_barang)->first();

            // Validasi stok_material
            if ($finishgood && $validatedData['pengeluaran_barang'] > $finishgood->stok_material) {
                session()->flash('error', 'Stok material tidak mencukupi.');
                return; // Hentikan proses penyimpanan data
            }

            // Kurangi stok_material di tabel finishgood
            if ($finishgood) {
                $finishgood->stok_material -= $validatedData['pengeluaran_barang'];
                $finishgood->save();
            }

            $pomasuk->qty -= $validatedData['pengeluaran_barang'];
            $pomasuk->save();
            $validatedData['no_po'] = $validatedData['no_po']['value'];

            PJPModel::create($validatedData);

            $this->dispatch('poMasukUpdated');
            $this->reset(
                'kode_customer',
                'no_po',
                'permintaan_po',
                'pengeluaran_barang',
                'tanggal_keluar_pt',
                'surat_jalan'
            );
            session()->flash('suksesinput', 'Jadwal berhasil dibuat.');
        } else {
            // Tangani kasus jika $pomasuk tidak ditemukan/dibuat
            session()->flash('error', 'Terjadi kesalahan dalam memproses data PO Masuk.');
        }
    }

    public function showData(int $id)
    {
        $validatedData = PJPModel::find($id);
        $this->fill($validatedData->toArray());
        $this->PJP_id = $id;
    }

    public function updateData()
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        try {
            $validatedData = $this->validate();
            $poPJP = PJPModel::findOrFail($this->PJP_id);

            $original_stok = $poPJP->pengeluaran_barang;

            // Cari data PMModel 
            $poMasuk = PMModel::where('no_po', $validatedData['no_po'])->first();

            if ($poMasuk) {
                // Kembalikan stok poMasuk ke kondisi semula
                $poMasuk->qty += $original_stok;

                // Hitung stok baru poMasuk setelah update 
                $new_stok_pomasuk = $poMasuk->qty - $validatedData['pengeluaran_barang'];

                // Memastikan stok poMasuk tidak negatif
                if ($new_stok_pomasuk < 0) {
                    session()->flash('error', 'Pengiriman PO tidak boleh membuat PO Awal menjadi negatif.');
                    return redirect()->back()->withInput();
                }

                // Ambil kode_barang dari $poMasuk
                $kode_barang = $poMasuk->kode_barang;

                // Ambil data finishgood berdasarkan kode_barang dari $poMasuk
                $finishgood = PBFinishGood::where('kode_barang', $kode_barang)->first();

                if ($finishgood) {
                    // Kembalikan stok finishgood ke kondisi semula
                    $finishgood->stok_material += $original_stok;

                    // Hitung stok baru finishgood setelah update
                    $new_stok_finishgood = $finishgood->stok_material - $validatedData['pengeluaran_barang'];

                    // Memastikan stok finishgood tidak negatif
                    if ($new_stok_finishgood < 0) {
                        session()->flash('error', 'Stok material tidak mencukupi.');
                        return redirect()->back()->withInput();
                    }

                    // Update stok finishgood
                    $finishgood->stok_material = $new_stok_finishgood;
                    $finishgood->save();
                } else {
                    // Tangani kasus di mana finishgood tidak ditemukan
                    session()->flash('error', 'Data tidak ditemukan untuk kode barang ini.');
                }

                // Update stok poMasuk
                $poMasuk->qty = $new_stok_pomasuk;
                $poMasuk->save();

                $namaCustomer = $validatedData['kode_customer'];
                session()->flash('suksesupdate', 'Jadwal ' . $namaCustomer . ' berhasil diupdate.');
            } else {
                // Tangani kasus di mana PMModel tidak ditemukan
                session()->flash('error', 'Data PMModel tidak ditemukan untuk kode barang ini.');
            }


            // Periksa apakah ada perubahan data sebelum melakukan update pada PoWIP
            if ($poPJP->fill($validatedData)->isDirty()) {
                PJPModel::findOrFail($this->PJP_id)->update($validatedData);
            }
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'PO tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('error', 'Terjadi kesalahan saat mengupdate data.');
        }

        $this->dispatch('poMasukUpdated');
        return redirect()->back();
    }

    public function delete($id)
    {
        $this->checkUserActive(); // Panggil fungsi pemeriksaan status
        $customer = PJPModel::find($id);
        $namaCustomer = $customer->kode_customer;
        $noPo = $customer->no_po;
        $customer->delete();
        $this->dispatch('toastify_sukses',  $namaCustomer . ' (No.PO: ' . $noPo . ') berhasil dihapus.');
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

        $poJadwalPengiriman = PJPModel::with('pomasuk.finishgoods.customer')->where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(kode_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(kode_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
            ->orderBy('no_po')->paginate(9);

        $poMasuk = PMModel::all();

        return view('livewire.po_costumer.tabel.tabel-jadwal_pengiriman', [
            'poJadwalPengiriman' => $poJadwalPengiriman,
            'pomasuk' => $poMasuk,
            'user' => Auth::user(), // Pass the authenticated user
        ]);
    }
}
