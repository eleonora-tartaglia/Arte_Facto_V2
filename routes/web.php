<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Home;
use App\Livewire\Artifacts\Index as ArtifactsIndex;
use App\Livewire\Artifacts\Show as ArtifactsShow;
use App\Livewire\Cart\Index as CartIndex;

/*
|--------------------------------------------------------------------------
| Routes publiques (accessibles à tous)
|--------------------------------------------------------------------------
*/

// Page d'accueil avec Livewire
Route::get('/', Home::class)->name('home');
Route::get('/welcome', Home::class)->name('welcome');

// Pages informatives
Route::get('/about', function () {
    return view('about');
})->name('about');

// Catalogue public avec Livewire
Route::get('/artifacts', ArtifactsIndex::class)->name('artifacts.index');
Route::get('/artifacts/{id}', ArtifactsShow::class)->name('artifacts.show');

// Enchères publiques (consultation uniquement)
Route::get('/auctions', function () {
    return view('auctions.index');
})->name('auctions.index');

Route::get('/auction/{artifact}', function (\App\Models\Artifact $artifact) {
    return view('auction.show', ['artifact' => $artifact]);
})->name('auction.show');
/*
|--------------------------------------------------------------------------
| Routes authentifiées (clients connectés)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard client (redirige vers home pour les clients)
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Profil et commandes
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders');

    // Panier et favoris
    Route::get('/cart', CartIndex::class)->name('cart.index');

    Route::get('/wishlist', function () {
        return view('wishlist');
    })->name('wishlist');

    // Demo Encheres
    Route::get('/auction-demo', function () {
        return view('auction.demo');
    })->name('auction.demo');

    // Paramètres utilisateur (avec Volt)
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

/*
|--------------------------------------------------------------------------
| Routes administration (admins uniquement)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    
    // Dashboard admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/stats', function () {
        return view('admin.stats');
    })->name('admin.stats');

    // Gestion du catalogue
    Route::prefix('catalog')->group(function () {
    //     Route::get('/artifacts', function () {
    //         return view('admin.artifacts.index');
    //     })->name('admin.artifacts.index');

        Route::get('/admin/catalog/artifacts', \App\Livewire\Admin\ArtifactCrud::class)->name('admin.artifacts.index');

        Route::get('/civilizations', function () {
            return view('admin.civilizations.index');
        })->name('admin.civilizations.index');

        Route::get('/tags', function () {
            return view('admin.tags.index');
        })->name('admin.tags.index');

        Route::get('/sources', function () {
            return view('admin.sources.index');
        })->name('admin.sources.index');
    });

    // Gestion des ventes
    Route::prefix('sales')->group(function () {
        Route::get('/auctions', function () {
            return view('admin.auctions.index');
        })->name('admin.auctions.index');

        Route::get('/orders', function () {
            return view('admin.orders.index');
        })->name('admin.orders.index');

        Route::get('/transactions', function () {
            return view('admin.transactions.index');
        })->name('admin.transactions.index');
    });

    // Gestion des utilisateurs
    Route::prefix('users')->group(function () {
        Route::get('/', function () {
            return view('admin.users.index');
        })->name('admin.users.index');

        Route::get('/verifications', function () {
            return view('admin.verifications.index');
        })->name('admin.verifications.index');
    });
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';