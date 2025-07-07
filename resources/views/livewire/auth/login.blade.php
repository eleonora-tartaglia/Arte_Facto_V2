<?php

// Import des classes depuis Laravel
use Illuminate\Auth\Events\Lockout;                 // Sert à émettre un événement si un utilisateur est bloqué
use Illuminate\Support\Facades\Auth;                // Fournit l’accès aux fonctions d’authentification
use Illuminate\Support\Facades\RateLimiter;         // Sert à limiter le nombre de tentatives de connexion
use Illuminate\Support\Facades\Route;               // Gère les routes de l’application
use Illuminate\Support\Facades\Session;             // Gère la session utilisateur
use Illuminate\Support\Str;                         // Fournit des fonctions utiles sur les chaînes de caractères
use Illuminate\Validation\ValidationException;      // Permet de générer des erreurs de validation
use Livewire\Attributes\Layout;                     // Attribut Livewire pour définir le layout utilisé
use Livewire\Attributes\Validate;                   // Attribut Livewire pour valider des propriétés
use Livewire\Volt\Component;                        // Classe de base d’un composant Livewire Volt
use App\Providers\AppServiceProvider;

// Déclaration du composant Livewire avec un layout personnalisé pour les pages auth
new #[Layout('components.layouts.auth')] class extends Component {

    // Déclare une propriété "email" obligatoire, de type string, validée comme adresse email
    #[Validate('required|string|email')]
    public string $email = '';

    // Déclare une propriété "password" obligatoire de type string
    #[Validate('required|string')]
    public string $password = '';

    // Déclare un booléen pour savoir si l'utilisateur coche "Se souvenir de moi"
    public bool $remember = false;

    // Fonction principale appelée au moment de soumettre le form : valide les champs, vérifie le nombre de tentatives, puis tente de connecter l'utilisateur.
    public function login(): void
    {
        // Étape 1 : validation des données saisies
        $this->validate();

        // Étape 2 : vérification qu’on n’a pas dépassé la limite de tentatives
        $this->ensureIsNotRateLimited();

        // Étape 3 : Tentative d’authentification de l’utilisateur avec ses identifiants
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {

            // Si échec, on enregistre une tentative supplémentaire pour l'utilisateur
            RateLimiter::hit($this->throttleKey());

            // On lève une erreur de validation sur le champ email (message venant du fichier de langue)
            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Msg du genre : "Ces identifiants ne correspondent pas..."
            ]);
        }

        // Si tout va bien, on réinitialise le compteur de tentative
        RateLimiter::clear($this->throttleKey());

        // On régénère la session (sécurité contre les attaques de fixation de session)
        Session::regenerate();

        // On redirige vers la page souhaitée, ou par défaut vers "dashboard"
        // $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        // On se sert de RouteServiceProvider::redirectTo() piur rediriger vers dash ou / 
        // $this->redirectIntended(default: AppServiceProvider::redirectTo(), navigate: true);
        $this->redirectIntended(default: '/dashboard', navigate: true);

    }

    // Fonction qui empeche une personne de faire trop de tentatives de connexion en peu de temps : si la limite est dépassée, on génère un message d'erreur clair.
    protected function ensureIsNotRateLimited(): void
    {
        // Si le nombre de tentatives (ici 5) n’est pas dépassé, on sort de la fonction
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Sinon, on déclenche l’événement "Lockout"
        event(new Lockout(request()));

        // On récupère le nombre de secondes restantes avant de réessayer
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Et on lance une exception de validation avec un message personnalisé
        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    // Fonction qui sert a générer une "clé unique" pour identifier l'utilisateur : elle combine l'email + l'adresse IP ( pour limiter les tentatives )
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<!-- Boxe de Connexion -->

<!-- Titre & Description -->
<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('Connexion')" 
        :description="__('Veuillez renseigner vos identifiants')" 
    />

    <!-- Message de session -->
    <x-auth-session-status class="text-center" 
        :status="session('status')" 
    />
    
    <!-- Formulaire -->
    <form wire:submit="login" class="flex flex-col gap-6">

        <!-- Adresse email -->
        <flux:input
            wire:model="email"
            :label="__('Adresse Email')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Mot de passe -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Mot de passe')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('••••••••')"
                viewable
            />

            <!-- Redirection vers Mot de passe oublié -->
            @if (Route::has('password.request'))
                <flux:link 
                    class="absolute end-0 top-0 text-sm" 
                    :href="route('password.request')" 
                    wire:navigate
                >
                    Mot de passe oublié ?
                </flux:link>
            @endif
        </div>

        <!-- Ckeckbox à cocher pour se souvenir de moi-->
        <flux:checkbox 
            wire:model="remember" 
            :label="__('Se souvenir de moi')" 
        />

        <!-- Bouton de connexion -->
        <div class="flex items-center justify-end">
            <flux:button 
                variant="primary" 
                type="submit" 
                class="w-full"
            >
                Se connecter
            </flux:button>
        </div>

    </form>

    <!-- Redirection vers inscription -->
    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            Pas encore de compte ?
            <flux:link 
                :href="route('register')" 
                wire:navigate
            >
                Créer un compte
            </flux:link>
        </div>
    @endif
</div>