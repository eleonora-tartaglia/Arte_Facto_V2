<div class="min-h-screen bg-black">
    {{-- Header de la page --}}
    <div class="bg-zinc-950 border-b border-amber-900/30 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white text-center mb-2" style="font-family: 'Cinzel', serif;">
                Galerie
            </h1>
            <p class="text-gray-400 text-center">
                Explorez notre collection d'artefacts authentiques
            </p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-zinc-900/50 border-b border-amber-900/30 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                {{-- Recherche --}}
                <div class="flex-1 min-w-[300px]">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Rechercher un artefact..."
                           class="w-full px-4 py-2 bg-black border border-amber-900/30 text-white placeholder-gray-500 focus:border-amber-600 focus:outline-none">
                </div>

                {{-- Filtres --}}
                <div class="flex gap-4">
                    {{-- Région --}}
                    <select wire:model.live="regionFilter" 
                            class="px-4 py-2 bg-black border border-amber-900/30 text-white focus:border-amber-600 focus:outline-none">
                        <option value="">Toutes les régions</option>
                        @foreach($regions as $region)
                            <option value="{{ $region }}">{{ $region }}</option>
                        @endforeach
                    </select>

                    {{-- Prix --}}
                    <select wire:model.live="priceRange" 
                            class="px-4 py-2 bg-black border border-amber-900/30 text-white focus:border-amber-600 focus:outline-none">
                        <option value="all">Tous les prix</option>
                        <option value="low">< 10 000 €</option>
                        <option value="medium">10 000 € - 50 000 €</option>
                        <option value="high">> 50 000 €</option>
                    </select>

                    {{-- Tri --}}
                    <select wire:model.live="sortBy" 
                            class="px-4 py-2 bg-black border border-amber-900/30 text-white focus:border-amber-600 focus:outline-none">
                        <option value="created_at">Plus récents</option>
                        <option value="price">Prix croissant</option>
                        <option value="title">Alphabétique</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    {{-- Grille d'artefacts --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse($artifacts as $artifact)
                <a href="{{ route('artifacts.show', $artifact->id) }}" 
                    class="group bg-zinc-950 overflow-hidden w-full mx-auto"
                    style="border: 1px solid rgba(197,159,91,0.3);"
                    onmouseover="this.style.borderColor='rgba(197,159,91,0.6)';"
                    onmouseout="this.style.borderColor='rgba(197,159,91,0.3)';">

                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $artifact->images[0] ?? '/images/placeholder.jpg' }}" 
                                alt="{{ $artifact->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>

                        <div class="p-4 bg-zinc-900">
                            <h3 class="text-base font-semibold text-white mb-2" style="font-family: 'Cinzel', serif;">
                                {{ $artifact->title }}
                            </h3>
                            <p class="text-xs text-gray-400 mb-3 line-clamp-2">
                                {{ Str::limit($artifact->description, 80) }}
                            </p>
                            <div class="mb-2">
                                <p class="text-sm font-bold" style="color: rgb(197, 159, 91);">
                                    {{ number_format($artifact->price, 0, ',', ' ') }} €
                                </p>
                            </div>
                            <div class="text-xs text-gray-400">
                                Statut : <span class="text-{{ $artifact->status === 'sold' ? 'red' : 'green' }}-500">
                                    {{ $artifact->status === 'sold' ? 'vendu' : 'disponible' }}
                                </span>
                            </div>
                        </div>
                    </a>

            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-lg">Aucun artefact trouvé.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $artifacts->links() }}
        </div>

    </div>