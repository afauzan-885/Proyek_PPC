<?php

namespace App\Livewire\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Daftar')]
class Daftar extends Component
{
    public $name, $email, $role = 'Member', $password;

    public $isSubmitting = false, $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role' => 'required|in:Admin,Member',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function messages()
    {
        return [
            'email.unique' => 'Email yang sama telah ada',
            'password.confirmed' => 'Password tidak sama', // Perbaiki pesan kesalahan untuk konfirmasi password
            '*' => 'Form ini tidak boleh kosong'
        ];
    }
    public function updated($propertyName)
    {
        
        $this->validateOnly($propertyName); 
    }

        public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password),
            'is_active' => false,
        ]);

        // Tambahkan jeda waktu 3 detik
        sleep(3);

        session()->flash('message', 'Registrasi berhasil! Silahkan hubungi admin untuk melakukan aktivasi.');
    }

    
    public function render()
    {
        return view('livewire.daftar', [
        
        ]);
    }
}
