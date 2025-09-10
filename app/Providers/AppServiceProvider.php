<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Share wishlist count to all views
        View::composer('*', function ($view) {
            $count = 0;
            if (Auth::check()) {
                $count = Wishlist::where('user_id', Auth::id())->sum('count');
            }
            $view->with('sharedWishlistCount', $count);
        });

        // Share cart data to all views
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->sum('qty');
            }
            $view->with('sharedCartCount', $cartCount);
        });
    }
}
