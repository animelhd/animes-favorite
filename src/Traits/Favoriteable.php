<?php

namespace Animelhd\AnimesFavorite\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Animelhd\AnimesFavorite\Favorite;

trait Favoriteable
{
    public function favorites(): HasMany
    {
        return $this->hasMany(config('animesfavorite.favorite_model'), config('animesfavorite.anime_foreign_key'));
    }
}