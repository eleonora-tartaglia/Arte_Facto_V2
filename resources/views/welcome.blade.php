<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Arte-Facto - Artefacts Archéologiques d'Exception</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-white dark:bg-zinc-900">
            {{-- Navigation simple pour la page d'accueil --}}
            <header class="absolute inset-x-0 top-0 z-50">
                <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                    <div class="flex lg:flex-1">
                        <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                            <span class="text-xl font-bold text-zinc-900 dark:text-white">Arte-Facto</span>
                        </a>
                    </div>
                    <div class="flex lg:hidden">
                        <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-zinc-700 dark:text-zinc-300">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="hidden lg:flex lg:gap-x-12">
                        <a href="{{ route('artifacts.index') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">Catalogue</a>
                        <a href="{{ route('auctions.index') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">Enchères</a>
                        <a href="{{ route('about') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">À propos</a>
                    </div>
                    <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-4">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('profile') }}" 
                               class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">
                                {{ auth()->user()->name }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">
                                    Déconnexion <span aria-hidden="true">&rarr;</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">
                                Inscription <span aria-hidden="true">&rarr;</span>
                            </a>
                        @endauth
                    </div>
                </nav>
            </header>

            {{-- Hero Section --}}
            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
                </div>
                
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">
                            Découvrez des trésors archéologiques authentiques
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-300">
                            Arte-Facto réunit collectionneurs passionnés et artefacts d'exception. 
                            Explorez des pièces uniques issues des plus grandes civilisations de l'histoire.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('artifacts.index') }}" class="rounded-md bg-zinc-900 dark:bg-white px-3.5 py-2.5 text-sm font-semibold text-white dark:text-zinc-900 shadow-sm hover:bg-zinc-700 dark:hover:bg-zinc-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900 dark:focus-visible:outline-white">
                                Explorer le catalogue
                            </a>
                            <a href="{{ route('auctions.index') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white">
                                Voir les enchères en cours <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="mx-auto max-w-7xl px-6 lg:px-8 pb-24">
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                            <dt class="text-base leading-7 text-zinc-600 dark:text-zinc-400">Artefacts authentifiés</dt>
                            <dd class="order-first text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                                {{ \App\Models\Artifact::count() }}+
                            </dd>
                        </div>
                        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                            <dt class="text-base leading-7 text-zinc-600 dark:text-zinc-400">Civilisations représentées</dt>
                            <dd class="order-first text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                                {{ \App\Models\Civilization::count() }}
                            </dd>
                        </div>
                        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                            <dt class="text-base leading-7 text-zinc-600 dark:text-zinc-400">Enchères actives</dt>
                            <dd class="order-first text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                                {{ \App\Models\Auction::where('status', 'active')->count() }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
                </div>
            </div>
        </div>
    </body>
</html>