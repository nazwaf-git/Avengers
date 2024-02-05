<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        Blade::withoutDoubleEncoding();
        view()->composer(['dashboard.sidebar'], function ($view){
            
            $access_token = Auth::user()->access_token;
            $listmenu = Controller::menulistSatria($access_token);
            $data = array(
                'listmenu' => $listmenu,
            );

            $view->with('data', $data);
        });
    }
}
