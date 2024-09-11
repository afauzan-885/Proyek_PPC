<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PanelAdminController extends Component
{
    public $totalAccounts;

    public function mount() 
    {
        $this->totalAccounts = User::count(); // Hitung total akun saat komponen dimuat
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->is_active = true;
            $user->save();
            // Opsional kirim notifikasi ke pengguna
            $this->dispatch('toastify',  'User Berhasil Diaktifkan.');
        } else {
            session()->flash('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function delete($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            $this->dispatch('toastify', 'User Berhasil Dihapus.');
        } else {
            session()->flash('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholder.pb_po_placeholder', $params);
    }

    public function render()
    {
        $user = User::all();
        return view('livewire.panel-admin', [
            
            'user'=>$user
        ]);
    }
}