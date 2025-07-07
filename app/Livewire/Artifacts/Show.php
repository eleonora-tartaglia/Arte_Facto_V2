<?php

namespace App\Livewire\Artifacts;

use Livewire\Component;
use App\Models\Artifact;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Artifact $artifact;
    public $relatedArtifacts;

    public bool $inCart = false;
    public int $otherCartsCount = 0;

    public bool $showIdentityModal = false;

    public function mount($id)
    {
        $this->artifact = Artifact::with(['civilization', 'source', 'tags', 'usersInCart'])
            ->findOrFail($id);

        $this->checkCartStates();

        $this->relatedArtifacts = Artifact::where('civilization_id', $this->artifact->civilization_id)
            ->where('id', '!=', $this->artifact->id)
            ->where('status', 'available')
            ->take(3)
            ->get();
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->artifact->usersInCart->contains(Auth::id())) {
            CartItem::create([
                'user_id' => Auth::id(),
                'artifact_id' => $this->artifact->id,
            ]);
        }

        $this->artifact->load('usersInCart');
        $this->checkCartStates();

        // 🚀 Émet l'événement pour CartIndicator
        $this->dispatch('cartUpdated');
    }

    public function participateAuction()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->identity_verified !== 'verified') {
            $this->showIdentityModal = true;
            return;
        }

        // Ici tu pourras ensuite rediriger vers la page live de l'enchère
        session()->flash('message', 'Bienvenue à l\'enchère !');
    }

    private function checkCartStates()
    {
        if (Auth::check()) {
            $this->inCart = $this->artifact->usersInCart->contains(Auth::id());
            $this->otherCartsCount = $this->artifact->usersInCart->where('id', '!=', Auth::id())->count();
        } else {
            $this->otherCartsCount = $this->artifact->usersInCart->count();
        }
    }

    public function render()
    {
        return view('livewire.artifacts.show')
            ->layout('components.layouts.app');
    }
}
