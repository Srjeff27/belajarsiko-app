<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UpdateProfileForm extends Component
{
    public $name = '';
    public $email = '';
    public $npm = '';
    public $semester = '';
    public $kelas = '';
    public $program_studi = '';
    public $fakultas = '';
    public $universitas = '';
    public $wa_number = '';
    public $alamat = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->npm = $user->npm ?? '';
        $this->semester = $user->semester ?? '';
        $this->kelas = $user->kelas ?? '';
        $this->program_studi = $user->program_studi ?? '';
        $this->fakultas = $user->fakultas ?? '';
        $this->universitas = $user->universitas ?? '';
        $this->wa_number = $user->wa_number ?? '';
        $this->alamat = $user->alamat ?? '';
    }

    public function save()
    {
        try {
            $user = Auth::user();

            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
                'npm' => ['nullable', 'string', 'max:50'],
                'semester' => ['nullable', 'integer', 'min:1', 'max:20'],
                'kelas' => ['nullable', 'string', 'max:50'],
                'program_studi' => ['nullable', 'string', 'max:100'],
                'fakultas' => ['nullable', 'string', 'max:100'],
                'universitas' => ['nullable', 'string', 'max:150'],
                'wa_number' => ['nullable', 'string', 'max:25'],
                'alamat' => ['nullable', 'string', 'max:500'],
            ]);

            // Normalize optional fields
            foreach (['npm','kelas','program_studi','fakultas','universitas','wa_number','alamat'] as $k) {
                if (isset($validated[$k])) {
                    $validated[$k] = $validated[$k] === '' ? null : $validated[$k];
                }
            }

            if (isset($validated['semester'])) {
                $validated['semester'] = ($validated['semester'] === '' || $validated['semester'] === null)
                    ? null
                    : (int) $validated['semester'];
            }

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            session()->flash('message', 'Profil berhasil diperbarui.');
            $this->dispatch('profile-updated', name: $user->name);

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan profil.');
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-form');
    }
}