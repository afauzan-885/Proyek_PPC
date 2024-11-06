<?php

namespace App\Livewire\Authentication;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class LupaPassword extends Component
{
    public $email;
    public $newPassword;
    public $confirmNewPassword;
    public $showEmailForm = true; 
    public $showResetPasswordForm = false; 

    public function render()
    {
        return view('livewire.lupa-password');
    }

    public function requestReset()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email'
        ]);
    
        $user = User::where('email', $this->email)->first();
    
        // Cek apakah user sudah di-approve dan masih dalam batas waktu
        if ($user->reset_request_status === 'approved' && $user->reset_request_expiry > now()) {
            $this->showEmailForm = false;
            $this->showResetPasswordForm = true;
            return; // Langsung tampilkan form reset password
        }
    
        if ($user->reset_request_status === 'pending') {
            $this->addError('email', 'Permintaan reset password Anda sedang diproses.');
            return;
        } elseif ($user->reset_request_status === 'rejected') {
            $this->addError('email', 'Permintaan Reset password Anda ditolak. Mohon request kembali dalam 1 menit.');
            return;
        }
    
        // Jika belum di-approve atau sudah expired, baru set ke pending
        $user->reset_request_status = 'pending';
        $user->save();
        $this->dispatch('toastify_sukses', 'Permintaan Reset berhasil dikirim');
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required|same:newPassword',
        ], [
            'confirmNewPassword.same' => 'Password baru tidak sama',
        ]);

        $user = User::where('email', $this->email)->first();

        if ($user->reset_request_status !== 'approved') {
            $this->addError('newPassword', 'Password tidak valid!.'); 
            return;
        }

        $user->password = Hash::make($this->newPassword);
        $user->reset_request_status = null; 
        $user->save();
        $this->dispatch('toastify_sukses', 'Reset Password berhasil!');

        $this->reset(['newPassword', 'confirmNewPassword', 'showResetPasswordForm']);
        $this->showEmailForm = true;
        // Redirect ke halaman login atau tampilkan pesan sukses
    }

    public function mount()
    {
        $this->email = request()->query('email');
        if ($this->email) {
            $user = User::where('email', $this->email)->first();
            if ($user && $user->reset_request_status === 'approved') {
                if ($user->reset_request_expiry < now()) {
                    $user->reset_request_status = null;
                    $user->reset_request_expiry = null;
                    $user->save();
                    $this->showEmailForm = true;
                } else {
                    $this->showEmailForm = false;
                    $this->showResetPasswordForm = true;
                }
            }
        }
    }
}