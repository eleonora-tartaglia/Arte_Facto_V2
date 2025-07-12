<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserCrud extends Component
{
    public $users;

    // Champs d'édition
    public $editId;
    public $editName;
    public $editEmail;

    public function mount()
    {
        $this->reloadUsers();
    }

    public function reloadUsers()
    {
        $this->users = User::with(['cartArtifacts'])->where('role', 'user')->get();
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->editId = $user->id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
    }

    public function update()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255',
        ]);

        $user = User::findOrFail($this->editId);
        $user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
        ]);

        session()->flash('message', 'Utilisateur mis à jour avec succès.');
        $this->reset(['editId', 'editName', 'editEmail']);
        $this->reloadUsers();
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'Utilisateur supprimé.');
        $this->reloadUsers();
    }

    public function render()
    {
        return view('livewire.admin.user-crud');
    }
}
