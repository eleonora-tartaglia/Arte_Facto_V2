<div>
    {{-- Hero Section avec Parallaxe --}}
    <section class="parallax-container" id="hero-section">
        {{-- Image de fond avec effet parallax --}}
        <div class="parallax-bg" id="parallax-element">
            <img src="{{ asset('images/hero/hero.png') }}" alt="Ancient artifacts" class="w-full h-full object-cover">
            <div class="hero-overlay"></div>
        </div>
        
        {{-- Contenu du hero --}}
        <div class="relative z-10 h-full flex items-center justify-center">
            <div class="text-center px-4 max-w-xl mx-auto">
                <h1 class="hero-title animate-fadeInUp">
                    ARTE FACTO
                </h1>
                <p class="hero-subtitle mt-6 animate-fadeInUp animate-delay-1">
                    Chaque pièce murmure un passé endormi...
                </p>
                <a href="{{ route('artifacts.index') }}" class="btn-explore mt-8 animate-fadeInUp animate-delay-2">
                    Explorer la galerie
                </a>
            </div>
        </div>
        
        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 scroll-indicator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Section Civilisations --}}
    @php
        $icons = [
            'Égypte Ancienne' => '/images/civilizations/egypt.png',
            'Grèce Antique' => '/images/civilizations/greece.png',
            'Empire Romain' => '/images/civilizations/rome.png',
            'Étrusques' => '/images/civilizations/etruscan.png',

            'Royaume du Bénin' => '/images/civilizations/benin.png',
            'Empire du Ghana' => '/images/civilizations/ghana.png',
            'Civilisation Nok' => '/images/civilizations/nok.png',
            'Royaume de Koush' => '/images/civilizations/kush.png',

            'Maya' => '/images/civilizations/maya.png',
            'Inca' => '/images/civilizations/inca.png',
            'Olmèques' => '/images/civilizations/olmec.png',
            'Moche' => '/images/civilizations/moche.png',

            'Mésopotamie' => '/images/civilizations/mesopotamia.png',
            'Empire Perse' => '/images/civilizations/persia.png',
            'Phénicie' => '/images/civilizations/phoenicia.png',

            'Dynastie Shang' => '/images/civilizations/shang.png',
            'Empire Khmer' => '/images/civilizations/khmer.png',
            'Civilisation de l\'Indus' => '/images/civilizations/indus.png',

            'default' => '/images/civilizations/default.png'
        ];
    @endphp

    <section class="py-20 bg-zinc-950">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-white mb-16">
                Civilisations Anciennes
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                @foreach($civilizations as $civilization)
                    <a href="{{ route('artifacts.index') }}?civilizationFilter={{ $civilization->slug }}"
                        class="civilization-card group">

                        <div class="aspect-square bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 flex flex-col justify-between">
                            <div class="flex-1 flex items-center justify-center mb-4">
                                <img src="{{ $icons[$civilization->name] ?? $icons['default'] }}" 
                                    alt="{{ $civilization->name }}"
                                    class="max-h-16 mx-auto object-contain">
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-2 price-gold">
                                    {{ $civilization->name }}
                                </h3>
                                <p class="text-xs text-gray-400 mb-1 italic">
                                    {{ $civilization->period }}
                                </p>
                                <p class="text-xs text-gray-500 line-clamp-3">
                                    {{ $civilization->description }}
                                </p>
                            </div>
                            <div class="text-xs mt-2" style="color: rgba(67, 54, 17, 0.7);">
                                {{ $civilization->artifacts_count }} artefacts
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </section>

    {{-- Section Artefacts en vedette --}}
    <section class="py-20 bg-black">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-white mb-16">
                Pièces d'Exception
            </h2>

            <div class="relative">
                <div class="flex space-x-6 overflow-x-auto scrollbar-hide pb-4">
                    @foreach($featuredArtifacts as $artifact)
                        <a href="{{ route('artifacts.show', $artifact->id) }}" class="flex-shrink-0 w-48 block group">
                            <div class="aspect-square relative overflow-hidden bg-zinc-900">
                                <img src="{{ $artifact->images[0] ?? '/images/placeholder.jpg' }}" 
                                    alt="{{ $artifact->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                            </div>
                            <div class="p-3 bg-zinc-900 text-white">
                                <h3 class="text-sm font-semibold mb-1 truncate">
                                    {{ $artifact->title }}
                                </h3>
                                <p class="text-xs text-gray-400 line-clamp-2 mb-1">
                                    {{ Str::limit($artifact->description, 60) }}
                                </p>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-[rgb(188,164,98)] font-bold">
                                        {{ number_format($artifact->price, 0, ',', ' ') }} €
                                    </span>
                                    <span class="text-gray-400">
                                        {{ $artifact->civilization->name }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Petite flèche indicatrice -->
                <div class="absolute right-0 top-1/2 transform -translate-y-1/2 pr-4 pointer-events-none">
                    <svg class="w-6 h-6 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>

            </div>

            <div class="text-center mt-12">
                <a href="{{ route('artifacts.index') }}" class="btn-explore">
                    Voir toute la collection
                </a>
            </div>
        </div>
    </section>


    {{-- Section CTA --}}
    <section class="py-20 cta-section border-y">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Enchères en Direct
            </h2>
            <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                Participez à nos enchères exclusives et acquérez des pièces uniques. 
                Nouvelles sessions toutes les semaines.
            </p>
            <a href="{{ route('auctions.index') }}" class="btn-cta">
                Découvrir les enchères
            </a>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Effet Parallax
    (function() {
        const parallaxElement = document.getElementById('parallax-element');
        let ticking = false;
        
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const speed = 0.5;
            const yPos = scrolled * speed;
            
            if (parallaxElement) {
                parallaxElement.style.transform = `translateY(${yPos}px)`;
            }
            
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                window.requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }
        
        // Écouteur d'événement pour le scroll
        window.addEventListener('scroll', requestTick);
        
        // Animation d'apparition au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Forcer les animations
            const animatedElements = document.querySelectorAll('.animate-fadeInUp');
            animatedElements.forEach(function(el) {
                el.style.animationPlayState = 'running';
            });
            
            // Initialiser le parallax
            updateParallax();
        });
    })();
</script>
@endpush