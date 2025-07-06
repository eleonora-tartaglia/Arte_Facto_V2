<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900" style="font-family: 'Marcellus', serif;">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            
            {{-- COLONNE GAUCHE : PANEL VISUEL --}}
            <div class="relative hidden h-full flex-col items-center justify-center text-white lg:flex dark:border-e dark:border-neutral-800 p-12">
                <!-- <div class="absolute inset-0 bg-neutral-900"></div> -->
                 <div class="absolute inset-0">
                    <img src="{{ asset('images/connexion/connexion.png') }}" alt="Fond historique" class="h-full w-full object-cover opacity-70" />
                    <div class="absolute inset-0 bg-black/50"></div>
                </div>

                <div class="relative z-20 text-center space-y-8">
                    {{-- TITRE PRINCIPAL --}}
                    <h1 class="text-4xl font-bold tracking-tight text-white font-title">
                        ARTE FACTO
                    </h1>

                    {{-- LOGO --}}
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center mx-auto" wire:navigate>
                        <x-app-logo-icon class="h-35 w-35 fill-current text-white" />
                    </a>

                    {{-- CITATION --}}
                    @php
                        [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                    @endphp

                <blockquote class="mt-8 space-y-2 text-sm italic font-body">
                    <p class="text-white">&ldquo;{{ trim($message) }}&rdquo;</p>
                    <footer class="text-neutral-400">— {{ trim($author) }}</footer>
                </blockquote>

                </div>
            </div>

            {{-- COLONNE DROITE : FORMULAIRE --}}
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>