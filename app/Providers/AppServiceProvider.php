<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// ページネーション使う
use Illuminate\Pagination\Paginator;
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
        // ページネーションクラスのブートストラップ使う？？
        Paginator::useBootstrap();
    }
}
