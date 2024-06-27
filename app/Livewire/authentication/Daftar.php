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
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role' => 'required|in:admin,member',
        'password' => 'required|string|min:8|confirmed',
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

        session()->flash('message', 'Registrasi berhasil! Silahkan login.');
    }
    public function render()
    {
        return view('livewire.daftar', [
        
        ]);
    }
}
