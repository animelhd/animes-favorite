<?php

namespace Animelhd\AnimesFavorite\Traits;

use Animelhd\AnimesFavorite\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Anime;

trait Favoriter
{
    public function favorite(Anime $anime): void
    {
        if (! $this->hasFavorited($anime)) {
            $this->favorites()->create([
                'anime_id' => $anime->getKey(),
            ]);
        }
    }

    public function unfavorite(Anime $anime): void
    {
        $this->favorites()
            ->where('anime_id', $anime->getKey())
            ->delete();
    }

    public function toggleFavorite(Anime $anime): void
    {
        $this->hasFavorited($anime)
            ? $this->unfavorite($anime)
            : $this->favorite($anime);
    }

    public function hasFavorited(Anime $anime): bool
    {
        return $this->favorites()
            ->where('anime_id', $anime->getKey())
            ->exists();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, config('animesfavorite.user_foreign_key'));
    }
}