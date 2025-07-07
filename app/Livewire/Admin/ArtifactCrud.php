<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Artifact;
use App\Models\Civilization;
use App\Models\ArtifactSource;
use App\Models\ArtifactTag;

class ArtifactCrud extends Component
{
    public $artifactId = null;

    public $showViewModal = false;
    public $viewArtifact = null;

    public $title, $description, $civilization_id, $source_id, $discovery_site, $discovery_year,
           $archaeologist, $discovery_context, $materials = [], $dimensions = [],
           $condition_grade, $condition_notes, $has_restoration = false, $authenticated = false,
           $authentication_certificate, $provenance_history = [], $legend, $price,
           $sale_type = 'immediate', $status = 'available', $images = [], $featured = false;

    public $tags = [];

    public $allArtifacts;
    public $allCivilizations, $allSources, $allTags;

    public $showFormModal = false;
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->loadRelations();
        $this->loadArtifacts();
    }

    public function loadRelations()
    {
        $this->allCivilizations = Civilization::all();
        $this->allSources = ArtifactSource::all();
        $this->allTags = ArtifactTag::all();
    }

    public function loadArtifacts()
    {
        $this->allArtifacts = Artifact::with(['civilization', 'source', 'tags'])->get();
    }

    public function view($id)
    {
        $this->viewArtifact = Artifact::with(['civilization', 'source', 'tags'])->findOrFail($id);
        $this->showViewModal = true;
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'civilization_id' => 'nullable|exists:civilizations,id',
            'source_id' => 'nullable|exists:artifact_sources,id',
            'discovery_site' => 'nullable|string|max:255',
            'discovery_year' => 'nullable|integer',
            'archaeologist' => 'nullable|string|max:255',
            'discovery_context' => 'nullable|string',
            'materials' => 'nullable|array',
            'dimensions' => 'nullable|array',
            'condition_grade' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'has_restoration' => 'boolean',
            'authenticated' => 'boolean',
            'authentication_certificate' => 'nullable|string|max:255',
            'provenance_history' => 'nullable|array',
            'legend' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_type' => 'required|in:immediate,auction',
            'status' => 'required|in:available,sold,in_cart',
            'images' => 'nullable|array',
            'featured' => 'boolean',
            'tags' => 'nullable|array',
        ];
    }

    public function resetForm()
    {
        $this->reset([
            'artifactId', 'title', 'description', 'civilization_id', 'source_id', 'discovery_site', 'discovery_year',
            'archaeologist', 'discovery_context', 'materials', 'dimensions', 'condition_grade', 'condition_notes',
            'has_restoration', 'authenticated', 'authentication_certificate', 'provenance_history', 'legend',
            'price', 'sale_type', 'status', 'images', 'featured', 'tags', 'showFormModal'
        ]);
    }

    public function edit($id)
    {
        $artifact = Artifact::with('tags')->findOrFail($id);

        $this->artifactId = $artifact->id;
        $this->title = $artifact->title;
        $this->description = $artifact->description;
        $this->civilization_id = $artifact->civilization_id;
        $this->source_id = $artifact->source_id;
        $this->discovery_site = $artifact->discovery_site;
        $this->discovery_year = $artifact->discovery_year;
        $this->archaeologist = $artifact->archaeologist;
        $this->discovery_context = $artifact->discovery_context;
        $this->materials = $artifact->materials ?? [];
        $this->dimensions = $artifact->dimensions ?? [];
        $this->condition_grade = $artifact->condition_grade;
        $this->condition_notes = $artifact->condition_notes;
        $this->has_restoration = $artifact->has_restoration;
        $this->authenticated = $artifact->authenticated;
        $this->authentication_certificate = $artifact->authentication_certificate;
        $this->provenance_history = $artifact->provenance_history ?? [];
        $this->legend = $artifact->legend;
        $this->price = $artifact->price;
        $this->sale_type = $artifact->sale_type;
        $this->status = $artifact->status;
        $this->images = $artifact->images ?? [];
        $this->featured = $artifact->featured;
        $this->tags = $artifact->tags->pluck('id')->toArray();

        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();

        $artifact = Artifact::updateOrCreate(
            ['id' => $this->artifactId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'civilization_id' => $this->civilization_id,
                'source_id' => $this->source_id,
                'discovery_site' => $this->discovery_site,
                'discovery_year' => $this->discovery_year,
                'archaeologist' => $this->archaeologist,
                'discovery_context' => $this->discovery_context,
                'materials' => $this->materials,
                'dimensions' => $this->dimensions,
                'condition_grade' => $this->condition_grade,
                'condition_notes' => $this->condition_notes,
                'has_restoration' => $this->has_restoration,
                'authenticated' => $this->authenticated,
                'authentication_certificate' => $this->authentication_certificate,
                'provenance_history' => $this->provenance_history,
                'legend' => $this->legend,
                'price' => $this->price,
                'sale_type' => $this->sale_type,
                'status' => $this->status,
                'images' => $this->images,
                'featured' => $this->featured,
            ]
        );

        $artifact->tags()->sync($this->tags);

        session()->flash('message', $this->artifactId ? 'Artefact mis à jour' : 'Artefact créé');
        $this->resetForm();
        $this->loadArtifacts();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function delete()
    {
        Artifact::destroy($this->confirmingDeleteId);
        session()->flash('message', 'Artefact supprimé');
        $this->confirmingDeleteId = null;
        $this->loadArtifacts();
    }

    public function render()
    {
        return view('livewire.admin.artifact-crud');
    }
}
