<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-950">
    <flux:header container class="flex items-center justify-between border-b border-[rgba(67,54,17,0.4)] bg-zinc-50 dark:bg-zinc-950">
        <!-- Brand -->
        <div class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <span class="text-sm lg:text-xl font-bold text-zinc-900 dark:text-white">ARTE FACTO</span>
            </a>
        </div>

        <!-- Navbar centrée -->
        <div class="hidden lg:flex space-x-8">

            <flux:navbar class="-mb-px">

                <flux:navbar.item icon="home" :href="route('home')" wire:navigate>
                    Accueil
                </flux:navbar.item>

                <flux:navbar.item icon="cog" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                    Tableau de bord
                </flux:navbar.item>

                <flux:navbar.item icon="chart-bar-square" :href="route('admin.stats')" :current="request()->routeIs('admin.stats')" wire:navigate>
                    Statistiques
                </flux:navbar.item>

                <flux:dropdown>
                    <flux:navbar.item icon="book-open" as="button" icon-trailing="chevron-down" :current="request()->routeIs('admin.artifacts.*') || request()->routeIs('admin.civilizations.*') || request()->routeIs('admin.tags.*') || request()->routeIs('admin.sources.*')">
                        Catalogue
                    </flux:navbar.item>

                    <flux:menu class="w-48">
                        <flux:menu.item icon="cube" :href="route('admin.artifacts.index')" wire:navigate>Artefacts</flux:menu.item>
                        <flux:menu.item icon="globe-europe-africa" :href="route('admin.civilizations.index')" wire:navigate>Civilisations</flux:menu.item>
                        <flux:menu.item icon="hashtag" :href="route('admin.tags.index')" wire:navigate>Tags</flux:menu.item>
                        <flux:menu.item icon="building-library" :href="route('admin.sources.index')" wire:navigate>Sources</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>

                <flux:dropdown>
                    <flux:navbar.item icon="currency-euro" as="button" icon-trailing="chevron-down" :current="request()->routeIs('admin.auctions.*') || request()->routeIs('admin.orders.*') || request()->routeIs('admin.transactions.*')">
                        Ventes & Enchères
                    </flux:navbar.item>
                    <flux:menu class="w-48">
                        <flux:menu.item icon="scale" :href="route('admin.auctions.index')" wire:navigate>Enchères</flux:menu.item>
                        <flux:menu.item icon="shopping-cart" :href="route('admin.orders.index')" wire:navigate>Commandes</flux:menu.item>
                        <flux:menu.item icon="credit-card" :href="route('admin.transactions.index')" wire:navigate>Transactions</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>

                <flux:dropdown>
                    <flux:navbar.item icon="user" as="button" icon-trailing="chevron-down" :current="request()->routeIs('admin.users.*') || request()->routeIs('admin.verifications.*')">
                        Utilisateurs
                    </flux:navbar.item>
                    <flux:menu class="w-48">
                        <flux:menu.item icon="user-group" :href="route('admin.users.index')" wire:navigate>Clients</flux:menu.item>
                        <flux:menu.item icon="shield-check" :href="route('admin.verifications.index')" wire:navigate>Vérifications</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:navbar>
        </div>

        <!-- NAVBAR MOBILE ICONS -->
        <div class="flex items-center space-x-3 lg:hidden">
            <a href="{{ route('home') }}" wire:navigate><flux:icon name="home" class="w-6 h-6" /></a>
            <a href="{{ route('admin.dashboard') }}" wire:navigate><flux:icon name="cog" class="w-6 h-6" /></a>
            <a href="{{ route('admin.stats') }}" wire:navigate><flux:icon name="chart-bar-square" class="w-6 h-6" /></a>
            <a href="{{ route('admin.artifacts.index') }}" wire:navigate><flux:icon name="cube" class="w-6 h-6" /></a>
            <a href="{{ route('admin.auctions.index') }}" wire:navigate><flux:icon name="scale" class="w-6 h-6" /></a>
            <a href="{{ route('admin.users.index') }}" wire:navigate><flux:icon name="user-group" class="w-6 h-6" /></a>
        </div>

        <!-- Profil -->
        <div class="flex items-center space-x-2 rtl:space-x-reverse me-1.5">
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
                                    <span class="truncate text-xs text-amber-600 dark:text-amber-400">Administrateur</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>Paramètres</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            Se déconnecter
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>

    </flux:header>

    <!-- Contenu -->
    <main class="p-6 font-sans">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>
