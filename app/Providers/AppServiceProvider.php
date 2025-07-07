<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Auction;
use App\Models\CartItem;
use App\Models\Civilization;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['components.layouts.app.header', 'components.layouts.app.header_admin'], function ($view) {
            $view->with([
                'civilizationsByRegion' => Civilization::all()->groupBy('region'),
                'activeAuctionsCount' => Auction::where('status', 'active')->count(),
                'cartItemsCount' => Auth::check() 
                    ? CartItem::where('user_id', Auth::id())->count() 
                    : 0,
            ]);
        });
    }
}
