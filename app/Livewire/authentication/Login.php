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

    if ($user && Hash::check($this->password, $user->password)) {
        Auth::login($user, $this->remember);

        session()->regenerate();
        sleep(2);

        return redirect()->to('/main_app');
    }

    return back()->with('error', 'Email atau kata sandi salah.');
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
        return view('livewire.login');
    }
}
