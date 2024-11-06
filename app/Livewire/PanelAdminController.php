<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PanelAdminController extends Component
{
    public $totalAccounts;
    public $userIdToActivate;

    protected $listeners = ['showModal'];

    public function showModal($userId)
    {
        $this->userIdToActivate = $userId;
    }

    public function mount()
    {
        $this->totalAccounts = User::count(); // Hitung total akun saat komponen dimuat
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->is_active = true;
            $user->reset_request_status = 'approved';
            $user->reset_request_expiry = now()->addMinutes(1); 
            $user->save();

            // Hapus cache sebelumnya
            Cache::forget('user_status' . $userId);

            // Buat cache baru selama 60 detik
            Cache::remember('user_status' . $userId, 60, function () use ($user) {
                return response()->json([
                    'is_active' => $user->is_active,
                ]);
            });

            // Mengambil nama pengguna
            $userName = $user->name;

            // Mengirim notifikasi dengan nama pengguna
            $this->dispatch('toastify', "$userName Berhasil Diaktifkan.");
        } else {
            session()->flash('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function rejectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->reset_request_status = 'rejected';
            $user->reset_request_expiry = now()->addMinutes(1); // Contoh: waktu tunggu 10 menit
            $user->save();
        }
    }

    public function deactivateUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->is_active = false;
            $user->save();

            // Hapus cache sebelumnya
            Cache::forget('user_status' . $userId);

            // Buat cache baru selama 60 detik
            Cache::remember('user_status' . $userId, 60, function () use ($user) {
                return response()->json([
                    'is_active' => $user->is_active,
                ]);
            });

            $this->dispatch('toastify_sukses', 'User Berhasil Dinonaktifkan.');
        } else {
            session()->flash('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function delete($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            $this->dispatch('toastify_sukses', 'User Berhasil Dihapus.');
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
            'user' => $user,
        ]);
    }
}
