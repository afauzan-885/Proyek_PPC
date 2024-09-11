<?php

namespace App\Livewire\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    public $email;
    public $title = 'Login';
    public $password;
    public $remember = false; // Default untuk 'remember me' adalah false

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $credentials = $this->validate();

        $user = User::where('email', $this->email)->first();

        if ($user) {
            // Periksa apakah akun sudah aktif
            if (!$user->is_active) {
                return back()->with('error', 'Sepertinya akun ini belum diaktifkan.');
            }

            if (Hash::check($this->password, $user->password)) {
                Auth::login($user, $this->remember);

                session()->regenerate();
                sleep(2);

                return redirect()->to('/main_app');
            } else {
                // Jika user ada tapi password salah
                return back()->with('error', 'Email atau kata sandi salah.'); 
            }
        } else {
            // Jika user tidak ditemukan
            return back()->with('error', 'Email ini belum di daftarkan, coba daftarkan terlebih dahulu.'); 
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.login', [
            'user' => Auth::user(), // Meneruskan pengguna yang diautentikasi atau null jika belum login
        ]); 
    }
}