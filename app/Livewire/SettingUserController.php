<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingUserController extends Component
{
    use WithFileUploads;

    public $newPhoto, $name, $kontak, $email, $tanggal_lahir, $tentang_saya, $currentPassword, $newPassword, $confirmNewPassword;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updateBiodata()
    {
        $validateData = $this->validate([
            'name' => 'nullable',
            'kontak' => 'nullable',
            'email' => 'nullable|email',
            'tanggal_lahir' => 'nullable|date',
            'tentang_saya' => 'nullable',
        ]);

        // Hapus field yang nilainya null agar tidak ikut ter-update
        $filteredData = array_filter($validateData, function ($value) {
            return !is_null($value);
        });

        // Update data user yang sedang login
        User::find(Auth::id())->update($filteredData);

        $this->dispatch('toastify_sukses', 'Sukses update data');
    }

    public function updatedNewPhoto()
    {
        try {
            $this->validate([
                'newPhoto' => 'image|max:5024|mimes:jpg,jpeg,png,webp',
            ]);

            $user = User::find(Auth::id());

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $this->newPhoto->store('photos', 'public');

            $user->photo = $photoPath;
            $user->save();
            $this->dispatch('refreshComponent');
            $this->dispatch('toastify_sukses', 'Foto profil berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('toastify_gagal', 'Format gambar tidak sesuai atau size terlalu besar');
        }
    }

    public function deletePhoto()
    {
        $user = User::find(Auth::id());

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
            $user->save();

            $this->dispatch('refreshComponent');
            $this->dispatch('toastify_sukses', 'Foto profil berhasil dihapus!');
        }
    }

    public function changePassword()
    {
        // Validasi data input
        $this->validate(
            [
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8',
                'confirmNewPassword' => 'required|same:newPassword',
            ],
            [
                'confirmNewPassword.same' => 'Password baru tidak sama',
            ],
        );

        $user = User::find(Auth::id());

        if (Hash::check($this->currentPassword, $user->password) == false) {
            $this->dispatch('toastify_gagal', 'Password sebelumnya salah');
            return;
        }

        $user->password = Hash::make($this->newPassword);
        $user->save();

        $this->reset(['currentPassword', 'newPassword', 'confirmNewPassword']);
        $this->dispatch('toastify_sukses', 'Password berhasil diubah!');
    }

    public function render()
    {
        // Mengirimkan data pengguna yang sedang login ke view sebagai variabel user
        return view('livewire.setting-user', [
            'user' => Auth::user(),
        ]);
    }
}
