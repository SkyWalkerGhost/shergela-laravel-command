<?php

namespace Shergela\LaravelCommand;

use Illuminate\Support\ServiceProvider;
use Shergela\LaravelCommand\Commands\CreateFile;
use Shergela\LaravelCommand\Commands\CreateView;
use Shergela\LaravelCommand\Commands\MiddlewareList;

class ShergelaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            CreateFile::class,
            CreateView::class,
            MiddlewareList::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ...
    }
}
