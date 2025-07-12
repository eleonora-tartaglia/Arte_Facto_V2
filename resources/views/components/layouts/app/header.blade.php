<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        <flux:header container class="relative flex items-center justify-between border-b border-[rgba(67,54,17,0.4)] bg-zinc-50 dark:bg-zinc-950">
            <!-- Brand à gauche -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                    <span class="text-xl font-bold text-zinc-900 dark:text-white">ARTE FACTO</span>
                </a>
            </div>

            <!-- Navbar centrée (absolue) -->
            <div class="absolute left-1/2 transform -translate-x-1/2 hidden lg:flex">
                <flux:navbar class="-mb-px">
                    <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        Accueil
                    </flux:navbar.item>

                    <flux:dropdown>
                        <flux:navbar.item icon="book-open" as="button" icon-trailing="chevron-down" :current="request()->routeIs('artifacts.*')">
                            Catalogue
                        </flux:navbar.item>

                        <flux:menu class="w-64">
                            <flux:menu.item :href="route('artifacts.index')" class="text-amber-600 hover:underline">
                                Tous les artefacts
                            </flux:menu.item>

                            <flux:menu.separator />

                            @foreach($civilizationsByRegion as $region => $civilizations)
                                <flux:menu.heading class="text-amber-500">{{ $region }}</flux:menu.heading>
                                @foreach($civilizations as $civ)
                                    <flux:menu.item :href="route('artifacts.index') . '?civilizationFilter=' . $civ->slug">
                                        {{ $civ->name }}
                                    </flux:menu.item>
                                @endforeach
                                @if(!$loop->last)
                                    <flux:menu.separator />
                                @endif
                            @endforeach
                        </flux:menu>
                    </flux:dropdown>


                    <flux:navbar.item icon="scale" :href="route('auctions.index')" :current="request()->routeIs('auctions.*')" wire:navigate>
                        Enchères
                        @if(($activeAuctionsCount ?? 0) > 0)
                            <flux:badge size="sm" variant="danger" class="ms-1">{{ $activeAuctionsCount }}</flux:badge>
                        @endif
                    </flux:navbar.item>

                    <flux:navbar.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                        À propos
                    </flux:navbar.item>
                </flux:navbar>
            </div>

            <!-- Actions à droite -->
            <div class="flex items-center justify-end flex-1 space-x-2 rtl:space-x-reverse me-1.5">
                @auth
                    <flux:tooltip content="Panier" position="bottom">
                        <livewire:cart-indicator/>
                    </flux:tooltip>
                    <flux:tooltip content="Favoris" position="bottom">
                        <flux:navbar.item icon="heart" :href="route('wishlist')" wire:navigate />
                    </flux:tooltip>

                    <flux:dropdown position="top" align="end">
                        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
                        <flux:menu>
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>
                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>
                            <flux:menu.separator />
                            <flux:menu.item icon="user" :href="route('profile')" wire:navigate>Mon profil</flux:menu.item>
                            <flux:menu.item icon="cube" :href="route('orders')" wire:navigate>Mes commandes</flux:menu.item>
                            <flux:menu.item icon="heart" :href="route('wishlist')" wire:navigate>Mes favoris</flux:menu.item>
                            @if(auth()->user()->isAdmin())
                                <flux:menu.separator />
                                <flux:menu.item icon="shield-check" :href="route('admin.dashboard')" wire:navigate>Administration</flux:menu.item>
                            @endif
                            <flux:menu.separator />
                            <flux:menu.item icon="cog" :href="route('settings.profile')" wire:navigate>Paramètres</flux:menu.item>
                            <flux:menu.separator />
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                    Se déconnecter
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                @else
                    <div class="flex items-center gap-2">
                        <flux:button variant="ghost" size="sm" :href="route('login')" wire:navigate>
                            Connexion
                        </flux:button>
                        <flux:button variant="primary" size="sm" :href="route('register')" wire:navigate>
                            Inscription
                        </flux:button>
                    </div>
                @endauth
            </div>
        </flux:header>


        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
                <span class="text-lg font-bold">Arte-Facto</span>
            </a>

            {{-- Recherche mobile --}}
            <div class="px-4 py-2">
                <flux:input.group size="sm" class="w-full">
                    <flux:input icon="magnifying-glass" placeholder="Rechercher..." />
                </flux:input.group>
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    Accueil
                </flux:navlist.item>
                
                <flux:navlist.group heading="Catalogue" expandable>
                    <flux:navlist.item :href="route('artifacts.index')" wire:navigate>
                        Tous les artefacts
                    </flux:navlist.item>
                    
                    @php
                        $civilizationsByRegion = \App\Models\Civilization::all()->groupBy('region');
                    @endphp
                    
                    @foreach($civilizationsByRegion as $region => $civilizations)
                        <flux:navlist.item class="font-semibold text-amber-600 mt-2">
                            {{ $region }}
                        </flux:navlist.item>
                        @foreach($civilizations as $civ)
                            <flux:navlist.item :href="route('artifacts.index', ['civilization' => $civ->slug])" wire:navigate class="pl-6">
                                {{ $civ->name }}
                            </flux:navlist.item>
                        @endforeach
                    @endforeach
                </flux:navlist.group>

                <flux:navlist.item :href="route('auctions.index')" :current="request()->routeIs('auctions.*')" wire:navigate>
                    <div class="flex items-center justify-between w-full">
                        <span>Enchères</span>
                        @if(($activeAuctionsCount ?? 0) > 0)
                            <flux:badge size="sm" variant="danger">{{ $activeAuctionsCount }}</flux:badge>
                        @endif
                    </div>
                </flux:navlist.item>

                <flux:navlist.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                    À propos
                </flux:navlist.item>
            </flux:navlist>

            @auth
                <flux:spacer />
                
                <flux:navlist variant="outline">
                    <flux:navlist.item icon="shopping-cart" :href="route('cart.index')" wire:navigate>
                        <div class="flex items-center justify-between w-full">
                            <span>Panier</span>
                            @if(($cartItemsCount ?? 0) > 0)
                                <flux:badge size="sm" variant="primary">{{ $cartItemsCount }}</flux:badge>
                            @endif
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="heart" :href="route('wishlist')" wire:navigate>
                        Favoris
                    </flux:navlist.item>
                </flux:navlist>
            @else
                <flux:spacer />
                
                <div class="p-4 space-y-2">
                    <flux:button variant="ghost" class="w-full" :href="route('login')" wire:navigate>
                        Connexion
                    </flux:button>
                    <flux:button variant="primary" class="w-full" :href="route('register')" wire:navigate>
                        Inscription
                    </flux:button>
                </div>
            @endauth
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>