<div class="p-6 bg-zinc-900 text-[#D8D3C3] min-h-screen">
    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded-xl bg-green-800 text-green-100 shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-end mb-6">
        <button wire:click="$set('showFormModal', true)"
                class="bg-[#7B5E1F] px-4 py-2 rounded-xl hover:bg-[#A9842C] transition">
            + Ajouter un artefact
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($allArtifacts as $artifact)
            <div class="p-4 bg-[#1A1A1A] border border-[#433611] rounded-xl shadow">
                <h3 class="text-lg font-bold">{{ $artifact->title }}</h3>
                <p class="text-sm">{{ $artifact->civilization->name ?? 'Sans civilisation' }}</p>
                <p class="text-sm">€ {{ number_format($artifact->price, 2, ',', ' ') }}</p>
                <div class="flex gap-2 mt-2">
                    <button wire:click="view({{ $artifact->id }})" 
                            class="text-green-400 hover:underline">👁️</button>
                    <button wire:click="edit({{ $artifact->id }})"
                            class="text-blue-400 hover:underline">✏️</button>
                    <button wire:click="confirmDelete({{ $artifact->id }})"
                            class="text-red-400 hover:underline">🗑️</button>
                </div>
            </div>
        @endforeach
    </div>

    @if($showFormModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-[#0c0c0c] p-6 rounded-xl w-full max-w-2xl border border-[#433611] overflow-y-auto max-h-[90vh]">
                <h2 class="text-xl font-bold mb-4">{{ $artifactId ? 'Modifier' : 'Ajouter' }} un artefact</h2>
                <form wire:submit.prevent="save" class="space-y-4">
                    <input type="text" wire:model.defer="title" placeholder="Titre" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611]">
                    <textarea wire:model.defer="description" placeholder="Description" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611]"></textarea>
                    <select wire:model.defer="civilization_id" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611]">
                        <option value="">Civilisation</option>
                        @foreach($allCivilizations as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.defer="source_id" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611]">
                        <option value="">Source</option>
                        @foreach($allSources as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" wire:model.defer="price" placeholder="Prix" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611]">
                    <div class="flex gap-2">
                        <label><input type="checkbox" wire:model.defer="has_restoration"> Restauration</label>
                        <label><input type="checkbox" wire:model.defer="authenticated"> Authentifié</label>
                        <label><input type="checkbox" wire:model.defer="featured"> En avant</label>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($allTags as $tag)
                            <label><input type="checkbox" wire:model="tags" value="{{ $tag->id }}"> {{ $tag->name }}</label>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-4 pt-4">
                        <button type="button" wire:click="resetForm" class="px-4 py-2 bg-[#7B5E1F] rounded">Annuler</button>
                        <button type="submit" class="px-4 py-2 bg-green-700 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($confirmingDeleteId)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl text-center text-black">
                <p>Supprimer cet artefact ?</p>
                <div class="flex justify-center gap-4 mt-4">
                    <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 bg-[#7B5E1F] rounded">Non</button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-700 text-white rounded">Oui</button>
                </div>
            </div>
        </div>
    @endif

    @if($showViewModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 overflow-y-auto">
            <div class="bg-[#0c0c0c] p-6 rounded-xl w-full max-w-3xl border border-[#433611] max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-bold mb-4 border-b border-[#7B5E1F]/40 pb-2">{{ $viewArtifact->title }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($viewArtifact->images && count($viewArtifact->images) > 0)
                        <div>
                            <img src="{{ $viewArtifact->images[0] }}" alt="{{ $viewArtifact->title }}"
                                class="w-full rounded-xl border border-[#433611]">
                        </div>
                    @endif
                    <div class="space-y-2 text-sm">
                        <p><span class="text-amber-600">Prix :</span> €{{ number_format($viewArtifact->price, 2, ',', ' ') }}</p>
                        <p><span class="text-amber-600">Civilisation :</span> {{ $viewArtifact->civilization->name ?? '—' }}</p>
                        <p><span class="text-amber-600">Source :</span> {{ $viewArtifact->source->name ?? '—' }}</p>
                        <p><span class="text-amber-600">Site :</span> {{ $viewArtifact->discovery_site ?? '—' }}</p>
                        <p><span class="text-amber-600">Année :</span> {{ $viewArtifact->discovery_year ?? '—' }}</p>
                        <p><span class="text-amber-600">Archéologue :</span> {{ $viewArtifact->archaeologist ?? '—' }}</p>
                        <p><span class="text-amber-600">Authentifié :</span> {{ $viewArtifact->authenticated ? 'Oui' : 'Non' }}</p>
                        <p><span class="text-amber-600">Restauration :</span> {{ $viewArtifact->has_restoration ? 'Oui' : 'Non' }}</p>
                        <p><span class="text-amber-600">Statut :</span> {{ ucfirst($viewArtifact->status) }}</p>
                        <p><span class="text-amber-600">Type :</span> {{ ucfirst($viewArtifact->sale_type) }}</p>
                        <div>
                            <span class="text-amber-600">Tags :</span>
                            @foreach($viewArtifact->tags as $tag)
                                <span class="inline-block bg-[#433611] text-[#D8D3C3] px-2 py-1 rounded text-xs mr-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-2 text-amber-600">Description</h3>
                    <p class="text-gray-300">{{ $viewArtifact->description ?? '—' }}</p>
                </div>

                @if($viewArtifact->legend)
                    <div class="mt-4 p-4 bg-[#1A1A1A] rounded-xl border border-[#433611]">
                        <h4 class="text-lg font-semibold text-amber-600 mb-2">Légende</h4>
                        <p>{{ $viewArtifact->legend }}</p>
                    </div>
                @endif

                <div class="flex justify-end mt-6">
                    <button wire:click="$set('showViewModal', false)"
                        class="px-4 py-2 bg-[#7B5E1F] rounded hover:bg-[#A9842C] transition">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>