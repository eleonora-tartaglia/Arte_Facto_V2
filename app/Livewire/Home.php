<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Artifact;
use App\Models\Civilization;

class Home extends Component
{
    public $featuredArtifacts;
    public $civilizations;

    public function mount()
    {
        $this->featuredArtifacts = Artifact::with(['civilization'])
            ->where('featured', true)
            ->where('status', '!=', 'sold')
            ->get();
            
        $this->civilizations = Civilization::withCount('artifacts')
            ->orderBy('artifacts_count', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.home')->layout('components.layouts.app');
    }
}