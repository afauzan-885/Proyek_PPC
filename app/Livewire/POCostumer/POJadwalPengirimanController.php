<?php

namespace App\Livewire\POCostumer;

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
        $nama_customer,
        $no_po,
        $permintaan_po,
        $pengeluaran_barang,
        $tanggal_keluar_pt,
        $surat_jalan;

    public $PJP_id, $lastPage, $searchTerm = '', $page, $query;

    protected $rules = [
        'nama_customer' => 'required',
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
            $this->nama_customer = $pomasuk->nama_customer;
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
                'nama_customer' => $validatedData['nama_customer'],
            ]
        );

        if ($pomasuk) {
            // Validasi pengeluaran_barang
            if ($validatedData['pengeluaran_barang'] > $pomasuk->qty) {
                session()->flash('error', 'Jumlah pengiriman melebihi batas PO.');
                return; // Hentikan proses penyimpanan data
            }

            $pomasuk->qty -= $validatedData['pengeluaran_barang'];
            $pomasuk->save();
            $validatedData['no_po'] = $validatedData['no_po']['value'];

            PJPModel::create($validatedData);

            $this->dispatch('poMasukUpdated');
            $this->reset(
                'nama_customer',
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

            // Cari data WIP saat ini
            $poMasuk = PMModel::where('no_po', $validatedData['no_po'])->first();

            if ($poMasuk) {
                // Kembalikan stok ke kondisi semula (sebelum update PoWIP ini)
                $poMasuk->qty += $original_stok;

                // Hitung stok baru setelah update PoWIP
                $new_stok = $poMasuk->qty - $validatedData['pengeluaran_barang'];

                // Memastikan stok tidak negatif
                if ($new_stok < 0) {
                    session()->flash('error', 'Pengiriman PO tidak boleh membuat PO Awal menjadi negatif.');
                    return redirect()->back()->withInput();
                }

                // Periksa apakah ada perubahan data sebelum melakukan update
                if ($poMasuk->fill($validatedData)->isDirty()) {
                    $poMasuk->update([
                        'qty' => $new_stok,
                    ]);

                    $namaCustomer = $validatedData['nama_customer'];
                    session()->flash('suksesupdate', 'Jadwal ' . $namaCustomer . ' berhasil diupdate.');
                } else {
                    session()->flash('suksesupdate', 'Update berhasil, data tidak ada yang berubah.');
                }
            } else {
                // Tangani kasus di mana WIP tidak ditemukan
                session()->flash('error', 'Data WIP tidak ditemukan untuk kode barang ini.');
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
        $namaCustomer = $customer->nama_customer;
        $noPo = $customer->no_po;
        $customer->delete();
        $this->dispatch('toastify',  $namaCustomer . ' (No.PO: ' . $noPo . ') berhasil dihapus.');
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

        $poJadwalPengiriman = PJPModel::with('pomasuk.finishgoods')->where(function ($query) use ($searchTerm) {
            $query->whereRaw('LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(no_po, " ", ""), ".", "")) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(REPLACE(REPLACE(surat_jalan, " ", ""), ".", "")) LIKE ?', [$searchTerm]);
        })
            ->orderByRaw('INSTR(LOWER(REPLACE(REPLACE(nama_customer, " ", ""), ".", "")), ?) ASC', [strtolower(str_replace([' ', '.'], '', $this->searchTerm))])
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
