<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('admin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
                <span class="text-lg font-bold">Arte-Facto Admin</span>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Tableau de bord" class="grid">
                    <flux:navlist.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                        Vue d'ensemble
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-bar-square" :href="route('admin.stats')" :current="request()->routeIs('admin.stats')" wire:navigate>
                        Statistiques
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group heading="Gestion du catalogue" expandable>
                    <flux:navlist.item icon="cube" :href="route('admin.artifacts.index')" :current="request()->routeIs('admin.artifacts.*')" wire:navigate>
                        Artefacts
                    </flux:navlist.item>
                    <flux:navlist.item icon="globe-alt" :href="route('admin.civilizations.index')" :current="request()->routeIs('admin.civilizations.*')" wire:navigate>
                        Civilisations
                    </flux:navlist.item>
                    <flux:navlist.item icon="hashtag" :href="route('admin.tags.index')" :current="request()->routeIs('admin.tags.*')" wire:navigate>
                        Tags
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-library" :href="route('admin.sources.index')" :current="request()->routeIs('admin.sources.*')" wire:navigate>
                        Sources
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group heading="Ventes & Enchères" expandable>
                    <flux:navlist.item icon="scale" :href="route('admin.auctions.index')" :current="request()->routeIs('admin.auctions.*')" wire:navigate>
                        Enchères
                    </flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('admin.orders.index')" :current="request()->routeIs('admin.orders.*')" wire:navigate>
                        Commandes
                    </flux:navlist.item>
                    <flux:navlist.item icon="credit-card" :href="route('admin.transactions.index')" :current="request()->routeIs('admin.transactions.*')" wire:navigate>
                        Transactions
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group heading="Utilisateurs" expandable>
                    <flux:navlist.item icon="user-group" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                        Clients
                    </flux:navlist.item>
                    <flux:navlist.item icon="shield-check" :href="route('admin.verifications.index')" :current="request()->routeIs('admin.verifications.*')" wire:navigate>
                        Vérifications
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="arrow-left-start-on-rectangle" :href="route('home')" wire:navigate>
                    Retour au site
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
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
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <span class="text-lg font-bold">Arte-Facto Admin</span>
            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

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
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>