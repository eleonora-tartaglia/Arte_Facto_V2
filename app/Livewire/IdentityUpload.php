<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdentityUpload extends Component
{
    use WithFileUploads;

    public $identityFile;

    public function submit()
    {
        $this->validate([
            'identityFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3000',
        ]);

        // Stocke dans storage/app/private/identities
        $path = $this->identityFile->store('private/identities');

        // Update user
        Auth::user()->update([
            'identity_verified' => 'pending',
            'identity_file' => basename($path),
        ]);

        session()->flash('message', 'Votre pièce a été soumise pour vérification.');

        $this->dispatch('identityUploaded');
    }

    public function render()
    {
        return view('livewire.identity-upload');
    }
}
