<?php

namespace Animelhd\AnimesFavorite;

use Illuminate\Database\Eloquent\Model;
use Animelhd\AnimesFavorite\Events\Favorited;
use Animelhd\AnimesFavorite\Events\Unfavorited;
use App\Models\Anime;

class Favorite extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => Favorited::class,
        'deleted' => Unfavorited::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('animesfavorite.favorites_table');
        parent::__construct($attributes);
    }

    public function anime()
    {
        return $this->belongsTo(config('animesfavorite.favoriteable_model'), config('animesfavorite.anime_foreign_key'));
    }

    public function user()
    {
        return $this->belongsTo(config('animesfavorite.user_model'), config('animesfavorite.user_foreign_key'));
    }
}