<div class="min-h-screen bg-black text-white py-12">
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Tableau du panier --}}
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold mb-8" style="font-family: 'Cinzel', serif;">
                Votre Panier
            </h1>

            @if($cartItems->count() > 0)
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between border-b border-[rgba(67,54,17,0.3)] pb-4">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->artifact->images[0] ?? '/images/placeholder.jpg' }}" 
                                     alt="{{ $item->artifact->title }}"
                                     class="w-16 h-16 object-cover border border-[rgba(67,54,17,0.3)]">
                                <div>
                                    <h2 class="text-lg font-semibold" style="font-family: 'Cinzel', serif;">
                                        {{ $item->artifact->title }}
                                    </h2>
                                    <p class="text-sm text-gray-400">
                                        {{ number_format($item->artifact->price, 0, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>
                            <button wire:click="remove({{ $item->id }})"
                                class="text-red-500 hover:text-red-400 text-sm">
                                ✕ Retirer
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-20">
                    <p class="text-2xl text-gray-400 italic">
                        🧺 Votre panier est vide...  
                    </p>
                </div>
            @endif
        </div>

        {{-- Mini carte récapitulative façon ticket --}}
        @if($cartItems->count() > 0)
            <div class="bg-zinc-900 border border-[rgba(67,54,17,0.3)] p-6 sticky top-20 h-fit">
                <h2 class="text-xl font-semibold mb-6" style="font-family: 'Cinzel', serif;">
                    Récapitulatif
                </h2>

                <div class="space-y-2 mb-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm border-b border-zinc-800 pb-1">
                            <span>{{ $item->artifact->title }}</span>
                            <span class="text-[rgb(188,164,98)] font-semibold">
                                {{ number_format($item->artifact->price, 0, ',', ' ') }} €
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between border-t border-[rgba(67,54,17,0.5)] pt-4 mt-4">
                    <span class="font-semibold">Total :</span>
                    <span class="text-[rgb(188,164,98)] font-bold">
                        {{ number_format($total, 0, ',', ' ') }} €
                    </span>
                </div>

                <a href="{{ route('orders') }}"
                class="block w-full text-center mt-6 py-3 bg-[rgb(67,54,17)] text-white rounded hover:scale-105 transition"
                style="font-family: 'Cinzel', serif;">
                    Procéder au paiement
                </a>
            </div>
        @endif

    </div>
</div>
