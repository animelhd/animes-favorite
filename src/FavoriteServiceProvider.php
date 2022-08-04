<?php

namespace Animelhd\AnimesFavorite;

use Illuminate\Support\ServiceProvider;

class FavoriteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            \dirname(__DIR__) . '/config/animesfavorite.php' => config_path('animesfavorite.php'),
        ], 'favorite-config');

        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'favorite-migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            \dirname(__DIR__) . '/config/animesfavorite.php',
            'favorite'
        );
    }
}
