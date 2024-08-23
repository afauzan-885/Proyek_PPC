<?php

namespace App\Livewire\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Daftar')]
class Daftar extends Component
{
    public $name;

    public $email;

    public $role = 'member'; // Default role adalah member

    public $password;
     public $isSubmitting = false;

    public $password_confirmation;

    protected $rules = [
        'name' => '|string|max:255',
        'email' => '|string|email|max:255|unique:users',
        'role' => '|in:admin,member',
        'password' => '|string|min:8|confirmed',
    ];

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
        ]);

        // Tambahkan jeda waktu 3 detik
        sleep(3);

        session()->flash('message', 'Registrasi berhasil! Silahkan login.');
    }

    
    public function render()
    {
        return view('livewire.daftar', [
        
        ]);
    }
}
