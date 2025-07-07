<div class="min-h-screen bg-black">
    {{-- Breadcrumb --}}
    <div class="bg-zinc-950 border-b border-amber-900/30 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-amber-600">Accueil</a>
                <span class="text-gray-600">/</span>
                <a href="{{ route('artifacts.index') }}" class="text-gray-400 hover:text-amber-600">Galerie</a>
                <span class="text-gray-600">/</span>
                <span class="text-amber-600">{{ $artifact->title }}</span>
            </nav>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Images + Détails Archéologiques --}}
            <div class="space-y-8 max-w-[400px] mx-auto lg:mx-0">
                <div class="aspect-square bg-zinc-900 border border-amber-900/30 overflow-hidden">
                    <img src="{{ $artifact->images[0] ?? '/images/placeholder.jpg' }}" 
                        alt="{{ $artifact->title }}"
                        class="w-full h-full object-cover">
                </div>
                
                {{-- Galerie d'images supplémentaires --}}
                @if(count($artifact->images ?? []) > 1)
                    <div class="grid grid-cols-5 gap-1">
                        @foreach(array_slice($artifact->images, 1, 4) as $image)
                            <div class="aspect-square bg-zinc-900 border border-amber-900/30 overflow-hidden cursor-pointer hover:border-amber-600 transition-colors">
                                <img src="{{ $image }}" alt="Vue {{ $loop->iteration + 1 }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Détails Archéologiques COMPLETS --}}
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-white mb-4" style="font-family: 'Cinzel', serif;">
                        Détails Archéologiques
                    </h2>

                    @if($artifact->discovery_year)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Année :</span>
                            <span class="text-white">{{ $artifact->discovery_year }}</span>
                        </div>
                    @endif

                    @if($artifact->archaeologist)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Archéologue :</span>
                            <span class="text-white">{{ $artifact->archaeologist }}</span>
                        </div>
                    @endif

                    @if($artifact->discovery_context)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Contexte :</span>
                            <span class="text-white">{{ $artifact->discovery_context }}</span>
                        </div>
                    @endif

                    @if($artifact->materials)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Matériaux :</span>
                            <span class="text-white">{{ implode(', ', $artifact->materials) }}</span>
                        </div>
                    @endif

                    @if($artifact->dimensions)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Dimensions :</span>
                            <span class="text-white">
                                @foreach($artifact->dimensions as $key => $value)
                                    {{ ucfirst($key) }}: {{ $value }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif

                    @php
                        $conditionTranslations = [
                            'Perfect' => 'Parfait',
                            'Excellent' => 'Excellent',
                            'Very Good' => 'Très bon',
                            'Good' => 'Bon',
                            'Fair' => 'Moyen',
                        ];
                    @endphp

                    <div class="flex justify-between py-2 border-b border-zinc-800">
                        <span class="text-gray-400">État :</span>
                        <span class="text-white">
                            {{ $artifact->condition_grade 
                                ? $conditionTranslations[$artifact->condition_grade] ?? $artifact->condition_grade 
                                : 'Non spécifié' }}
                        </span>
                    </div>

                    @if($artifact->condition_notes)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Notes état :</span>
                            <span class="text-white">{{ $artifact->condition_notes }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between py-2 border-b border-zinc-800">
                        <span class="text-gray-400">Restauration :</span>
                        <span class="text-white">{{ $artifact->has_restoration ? 'Oui' : 'Non' }}</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-zinc-800">
                        <span class="text-gray-400">Authentifié :</span>
                        <span class="text-white">{{ $artifact->authenticated ? 'Oui' : 'Non' }}</span>
                    </div>

                    @if($artifact->authentication_certificate)
                        <div class="flex justify-between py-2 border-b border-zinc-800">
                            <span class="text-gray-400">Certificat :</span>
                            <span class="text-white">{{ $artifact->authentication_certificate }}</span>
                        </div>
                    @endif

                    @if($artifact->provenance_history)
                        <div class="py-2 border-b border-zinc-800">
                            <span class="text-gray-400 block mb-1">Provenance :</span>
                            <ul class="list-disc list-inside text-white text-sm space-y-1">
                                @foreach($artifact->provenance_history as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Informations et description --}}
            <div class="bg-zinc-950 border border-amber-900/30 p-8">
                <h1 class="text-3xl font-bold text-white mb-6" style="font-family: 'Cinzel', serif;">
                    {{ $artifact->title }}
                </h1>

                {{-- Prix et statut --}}
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-amber-900/30">
                    <div>
                        <p class="text-sm text-gray-400">Prix :</p>
                        <p class="text-2xl font-bold text-amber-600">{{ number_format($artifact->price, 0, ',', ' ') }} €</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Lieu :</p>
                        <p class="text-white">{{ $artifact->discovery_site ?? 'Non spécifié' }}</p>
                    </div>
                </div>

                {{-- Catégorie et type --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-400">Catégorie :</p>
                        <p class="text-white">{{ $artifact->civilization->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Type :</p>
                        <p class="text-white">{{ $artifact->sale_type === 'auction' ? 'Enchère' : 'Vente directe' }}</p>
                    </div>
                </div>

                {{-- Statut + bouton panier --}}
                <div class="mb-8 flex items-center gap-4">
                    <p class="text-sm text-gray-400">Statut</p>

                    @if($artifact->status === 'sold')
                        <span class="px-3 py-1 text-sm bg-red-900/30 text-red-500">
                            Vendu
                        </span>
                    @elseif($inCart)
                        <span class="px-3 py-1 text-sm bg-[rgb(67,54,17)]">
                            ✓ Dans votre panier
                        </span>
                    @elseif($otherCartsCount > 0)
                        <span class="px-1 py-1 text-sm bg-yellow-900/30 text-yellow-400">
                            {{ $otherCartsCount }} {{ Str::plural('utilisateur', $otherCartsCount) }} {{ $otherCartsCount > 1 ? 'ont' : 'a' }} cet artefact dans {{ $otherCartsCount > 1 ? 'leur' : 'son' }} panier
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm bg-green-900/30 text-green-500">
                            Disponible
                        </span>
                    @endif

                    @if($artifact->status !== 'sold' && !$inCart)
                        @if($artifact->sale_type === 'immediate')
                            <button wire:click="addToCart"
                                class="px-1 py-1 text-sm"
                                style="background: rgba(118, 94, 30, 0.58); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Ajouter au panier 🧺
                            </button>

                        @elseif($artifact->sale_type === 'auction')
                            <button wire:click="participateAuction"
                                class="px-1 py-1 text-sm"
                                style="background: rgba(24, 180, 160, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Participer à l’enchère ⚖️
                            </button>
                        @endif
                    @endif

                </div>

                {{-- Description --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-4" style="font-family: 'Cinzel', serif;">
                        Description
                    </h2>
                    <p class="text-gray-300 leading-relaxed italic">
                        {{ $artifact->description }}
                    </p>
                </div>

                {{-- Légende sous description --}}
                @if($artifact->legend)
                    <div class="p-4 bg-amber-900/10 border border-amber-900/30">
                        <h3 class="text-lg font-semibold text-amber-600 mb-2" style="font-family: 'Cinzel', serif;">
                            Légende
                        </h3>
                        <p class="text-gray-300 italic">{{ $artifact->legend }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Artefacts similaires --}}
    @if($relatedArtifacts->count() > 0)
        <section class="py-12 border-t border-amber-900/30">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-white mb-8 text-center" style="font-family: 'Cinzel', serif;">
                    Autres pièces de {{ $artifact->civilization->name }}
                </h2>

                <div class="flex flex-wrap justify-center gap-4">
                    @foreach($relatedArtifacts as $related)
                        <a href="{{ route('artifacts.show', $related->id) }}" 
                        class="group bg-zinc-900 border border-amber-900/30 hover:border-amber-600/50 transition-all overflow-hidden w-46">
                            <div class="aspect-square relative overflow-hidden">
                                <img src="{{ $related->images[0] ?? '/images/placeholder.jpg' }}" 
                                    alt="{{ $related->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                            </div>
                            <div class="p-2">
                                <h3 class="text-xs font-semibold text-white mb-0.5 truncate">{{ $related->title }}</h3>
                                <p class="text-amber-600 font-bold text-xs">{{ number_format($related->price, 0, ',', ' ') }} €</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Modal pour upload pièce identité --}}
    @if($showIdentityModal)
        <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" wire:click="$set('showIdentityModal', false)">
            <div class="bg-zinc-900 border border-amber-800 rounded-lg p-6" style="min-width: 400px;" wire:click.stop>
                <livewire:identity-upload />
            </div>
        </div>
    @endif

</div>