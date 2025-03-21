<?php

namespace Animelhd\AnimesFavorite\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Database\Eloquent\Collection $favoriters
 * @property \Illuminate\Database\Eloquent\Collection $favorites
 */
trait Favoriteable
{
    /**
     * @deprecated renamed to `hasBeenFavoritedBy`, will be removed at 5.0
     */
    public function isFavoritedBy(Model $user): bool
    {
        return $this->hasBeenFavoritedBy($user);
    }

    public function hasFavoriter(Model $user): bool
    {
        return $this->hasBeenFavoritedBy($user);
    }

    public function hasBeenFavoritedBy(Model $user): bool
    {
        if (! \is_a($user, config('animesfavorite.favoriter_model'))) {
            return false;
        }

        if ($this->relationLoaded('favoriters')) {
            return $this->favoriters->contains($user);
        }

        return ($this->relationLoaded('favorites') ? $this->favorites : $this->favorites())
            ->where(\config('animesfavorite.user_foreign_key'), $user->getKey())->count() > 0;
    }

    public function favorites(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(config('animesfavorite.favorite_model'), 'favoriteable');
    }

    public function favoriters(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            config('animesfavorite.favoriter_model'),
            config('animesfavorite.favorites_table'),
            'favoriteable_id',
            config('animesfavorite.user_foreign_key')
        )
            ->where('favoriteable_type', $this->getMorphClass());
    }
}
