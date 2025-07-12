<div class="p-6 bg-black text-[#D8D3C3] min-h-screen" style="font-family: 'Cinzel', serif;">
    <h2 class="text-3xl font-bold mb-10 text-center" style="color: #b87333;">
        Gestion du Catalogue - Artefacts
    </h2>

    @if (session()->has('message'))
        <div class="mb-8 p-4 text-center border border-[#7B5E1F] bg-[#1A1A1A]">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-end mb-8">
        <button wire:click="$set('showFormModal', true)"
            class="px-6 py-2 border border-[#7B5E1F] bg-[#1A1A1A] hover:bg-[#2a2a2a] transition">
            + Ajouter un artefact
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($allArtifacts as $artifact)
            <div class="border border-[#b87333] p-4 hover:shadow-lg transition"
                style="aspect-ratio: 1 / 1;">
                
                @if($artifact->images && count($artifact->images))
                    <div class="flex justify-center items-center h-2/3 mb-3">
                        <img src="{{ $this->getImageUrl($artifact->images[0]) }}"
                             alt="{{ $artifact->title }}"
                             class="max-h-40 object-contain border border-[#433611]">
                    </div>
                @endif

                <h3 class="text-xl font-bold mb-1 text-[#b87333]">{{ $artifact->title }}</h3>
                <p class="text-sm mb-1">{{ $artifact->civilization->name ?? '—' }}</p>
                <p class="text-xs italic mb-3 text-[#d1c7b8]">{{ number_format($artifact->price, 2, ',', ' ') }} €</p>

                <div class="flex justify-between gap-2 mt-4">
                    <button wire:click="view({{ $artifact->id }})"
                        class="flex-1 px-2 py-1 text-xs border border-[#7B5E1F] hover:bg-[#2a2a2a] transition">
                        👁️ Voir
                    </button>
                    <button wire:click="edit({{ $artifact->id }})"
                        class="flex-1 px-2 py-1 text-xs border border-[#C77624] hover:bg-[#2a2a2a] transition">
                        ✏️ Modifier
                    </button>
                    <button wire:click="confirmDelete({{ $artifact->id }})"
                        class="flex-1 px-2 py-1 text-xs border border-[#A01E1E] hover:bg-[#2a2a2a] transition">
                        🗑️ Supprimer
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal ajout / édition --}}
    @if($showFormModal)
    <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 overflow-y-auto">
        <div class="bg-[#0c0c0c] p-8 w-full max-w-3xl border border-[#433611] shadow-xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6 text-center text-[#b87333]">
                {{ $artifactId ? 'Modifier' : 'Ajouter' }} un artefact
            </h2>

            <form wire:submit.prevent="save" class="space-y-5">

                <input type="text" wire:model.defer="title" placeholder="Titre"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <textarea wire:model.defer="description" placeholder="Description"
                    class="w-full p-3 bg-black border border-[#433611] text-sm"></textarea>

                <div class="grid grid-cols-2 gap-4">
                    <select wire:model.defer="civilization_id"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                        <option value="">Civilisation</option>
                        @foreach($allCivilizations as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.defer="source_id"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                        <option value="">Source</option>
                        @foreach($allSources as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" wire:model.defer="discovery_site" placeholder="Site de découverte"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                    <input type="text" wire:model.defer="discovery_year" placeholder="Année"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                </div>

                <input type="text" wire:model.defer="archaeologist" placeholder="Archéologue"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <textarea wire:model.defer="discovery_context" placeholder="Contexte de découverte"
                    class="w-full p-3 bg-black border border-[#433611] text-sm"></textarea>

                <input type="text" wire:model.defer="materials" placeholder="Matériaux"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">
                <input type="text" wire:model.defer="dimensions" placeholder="Dimensions"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <select wire:model.defer="condition_grade"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">
                    <option value="">État</option>
                    <option value="Perfect">Perfect</option>
                    <option value="Excellent">Excellent</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                </select>
                <input type="text" wire:model.defer="condition_notes" placeholder="Notes sur l'état"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <div class="flex gap-3">
                    <label><input type="checkbox" wire:model.defer="has_restoration"> Restauration</label>
                    <label><input type="checkbox" wire:model.defer="authenticated"> Authentifié</label>
                    <label><input type="checkbox" wire:model.defer="featured"> En avant</label>
                </div>

                <input type="text" wire:model.defer="authentication_certificate" placeholder="Certificat"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <textarea wire:model.defer="legend" placeholder="Légende"
                    class="w-full p-3 bg-black border border-[#433611] text-sm"></textarea>

                <input type="number" wire:model.defer="price" placeholder="Prix"
                    class="w-full p-3 bg-black border border-[#433611] text-sm">

                <div class="flex gap-4">
                    <select wire:model.defer="sale_type"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                        <option value="immediate">Vente immédiate</option>
                        <option value="auction">Enchère</option>
                    </select>
                    <select wire:model.defer="status"
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                        <option value="available">Disponible</option>
                        <option value="in_cart">Dans un panier</option>
                        <option value="sold">Vendu</option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-3">
                    @foreach($allTags as $tag)
                        <label class="flex items-center gap-1">
                            <input type="checkbox" wire:model="tags" value="{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>

                <div>
                    <label class="block mb-2">Téléverser des images :</label>
                    <input type="file" wire:model="newImages" multiple
                        class="w-full p-3 bg-black border border-[#433611] text-sm">
                    @if ($newImages)
                        <div class="flex gap-2 mt-3">
                            @foreach ($newImages as $photo)
                                <div class="border border-[#433611] p-1">
                                    <img src="{{ $photo->temporaryUrl() }}" class="h-20 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <button type="button" wire:click="resetForm"
                        class="px-6 py-2 border border-[#7B5E1F] hover:bg-[#2a2a2a] transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-6 py-2 border border-[#18b4a0] hover:bg-[#2a2a2a] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if ($errors->any())
        <div class="text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Modal vue --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 overflow-y-auto">
        <div class="bg-[#0c0c0c] p-8 w-full max-w-3xl border border-[#433611] shadow-xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6 text-center text-[#b87333]">
                {{ $viewArtifact->title }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($viewArtifact && $viewArtifact->images && count($viewArtifact->images))
                    <div>
                        <img src="{{ $this->getImageUrl($viewArtifact->images[0]) }}"
                            alt="{{ $viewArtifact->title }}"
                            class="w-full border border-[#433611]">
                    </div>
                @endif

                <div class="space-y-2 text-sm">
                    <p><span class="text-[#b87333]">Prix :</span> {{ number_format($viewArtifact->price, 2, ',', ' ') }} €</p>
                    <p><span class="text-[#b87333]">Civilisation :</span> {{ $viewArtifact->civilization->name ?? '—' }}</p>
                    <p><span class="text-[#b87333]">Source :</span> {{ $viewArtifact->source->name ?? '—' }}</p>
                    <p><span class="text-[#b87333]">Site :</span> {{ $viewArtifact->discovery_site ?? '—' }}</p>
                    <p><span class="text-[#b87333]">Année :</span> {{ $viewArtifact->discovery_year ?? '—' }}</p>
                    <p><span class="text-[#b87333]">Archéologue :</span> {{ $viewArtifact->archaeologist ?? '—' }}</p>
                    <p><span class="text-[#b87333]">Authentifié :</span> {{ $viewArtifact->authenticated ? 'Oui' : 'Non' }}</p>
                    <p><span class="text-[#b87333]">Restauration :</span> {{ $viewArtifact->has_restoration ? 'Oui' : 'Non' }}</p>
                    <p><span class="text-[#b87333]">Statut :</span> {{ ucfirst($viewArtifact->status) }}</p>
                    <p><span class="text-[#b87333]">Type :</span> {{ ucfirst($viewArtifact->sale_type) }}</p>
                    <div>
                        <span class="text-[#b87333]">Tags :</span>
                        @foreach($viewArtifact->tags as $tag)
                            <span class="inline-block bg-[#433611] px-2 py-1 text-xs mr-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @if($viewArtifact->legend)
                <div class="mt-6 p-4 bg-[#1A1A1A] border border-[#433611]">
                    <h4 class="text-lg font-semibold mb-2 text-[#b87333]">Légende</h4>
                    <p>{{ $viewArtifact->legend }}</p>
                </div>
            @endif
            <div class="flex justify-end mt-8">
                <button wire:click="$set('showViewModal', false)"
                    class="px-6 py-2 border border-[#7B5E1F] hover:bg-[#2a2a2a] transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal suppression --}}
    @if($confirmingDeleteId)
    <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50">
        <div class="bg-[#0c0c0c] p-6 border border-[#433611] text-center">
            <p class="mb-4">Supprimer cet artefact ?</p>
            <div class="flex justify-center gap-4">
                <button wire:click="$set('confirmingDeleteId', null)"
                    class="px-6 py-2 border border-[#7B5E1F] hover:bg-[#2a2a2a] transition">
                    Non
                </button>
                <button wire:click="delete"
                    class="px-6 py-2 border border-[#A01E1E] hover:bg-[#2a2a2a] transition">
                    Oui
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
