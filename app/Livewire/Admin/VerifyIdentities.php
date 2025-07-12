<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class VerifyIdentities extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::whereNotNull('identity_file')->get();
    }

    public function verify($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['identity_verified' => 'verified']);
        $this->mount(); // recharge la liste
        session()->flash('message', 'Utilisateur vérifié.');
    }

    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['identity_verified' => 'rejected']);
        $this->mount(); // recharge la liste
        session()->flash('message', 'Vérification rejetée.');
    }

    public function render()
    {
        return view('livewire.admin.verify-identities');
    }
}
