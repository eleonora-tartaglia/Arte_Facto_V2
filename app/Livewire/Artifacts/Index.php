<?php

namespace App\Livewire\Artifacts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Artifact;
use App\Models\Civilization;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $civilizationFilter = '';
    public $regionFilter = '';
    public $priceRange = 'all';
    public $sortBy = 'created_at';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'civilizationFilter' => ['except' => ''],
        'regionFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $artifacts = Artifact::with(['civilization', 'tags'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->civilizationFilter, function ($query) {
                $query->whereHas('civilization', function ($q) {
                    $q->where('slug', $this->civilizationFilter);
                });
            })
            ->when($this->regionFilter, function ($query) {
                $query->whereHas('civilization', function ($q) {
                    $q->where('region', $this->regionFilter);
                });
            })
            ->when($this->priceRange !== 'all', function ($query) {
                match($this->priceRange) {
                    'low' => $query->where('price', '<', 10000),
                    'medium' => $query->whereBetween('price', [10000, 50000]),
                    'high' => $query->where('price', '>', 50000),
                };
            })
            ->orderBy($this->sortBy, 'desc')
            ->paginate(10);

        $civilizations = Civilization::all();
        $regions = Civilization::distinct()->pluck('region');

        return view('livewire.artifacts.index', [
            'artifacts' => $artifacts,
            'civilizations' => $civilizations,
            'regions' => $regions,
        ])->layout('components.layouts.app');
    }
}
