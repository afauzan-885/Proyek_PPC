<?php
namespace App\Livewire;

use App\Models\CostumerSupplier as CSModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Livewire\WithPagination;

class CSController extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $nama_costumer, $kode_costumer, $no_telepon_pt, $alamat_costumer,  $kontak_costumer, $email_costumer;
    public $cs_id;
    protected $rules = [
        'nama_costumer' => 'required',
        'kode_costumer' => 'required|unique:costumer_suppliers',
        'no_telepon_pt' => 'required',
        'alamat_costumer' => 'required',
        'kontak_costumer'=>'required',
        'email_costumer' => 'required',
    ];

    public function messages()
    {
        return [
            'kode_costumer.unique' => 'Kode yang sama telah ada',
             '*' => 'Form ini tidak boleh kosong'
        ];
    }
    public function storeData()
{
    $validatedData = $this->validate();
    CSModel::create($validatedData);

    $namaCustomer = $validatedData['nama_costumer'];

    $this->reset('nama_costumer','kode_costumer','no_telepon_pt','alamat_costumer','kontak_costumer','email_costumer');
    session()->flash('suksesinput', 'Data ' . $namaCustomer . ' berhasil ditambahkan.');
}

     public function showData(int $id) 
    {
        $validatedData = CSModel::find($id);
        $this->fill($validatedData->toArray());
    }

    public function updateData()
    {
        try {
            $validatedData = $this->validate([
            'nama_costumer' => 'required',
            'kode_costumer' => 'required',
            'no_telepon_pt' => 'required',
            'alamat_costumer' => 'required',
            'kontak_costumer'=> 'required',
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
        $customer = CSModel::find($id);
        $namaCustomer = $customer->nama_costumer;
        $customer->delete();

        $this->dispatch('toastify',  $namaCustomer . ' berhasil dihapus.');
        // Tampilkan pesan flash dengan nama customer
    }

    public function render()
    {
        $CostumerSuppliers = CSModel::paginate(10);
        return view('livewire.costumer-supplier', [
            'CostumerSupplier'=>$CostumerSuppliers]);
    }
}
