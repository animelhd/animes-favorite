<?php

return [
    /**
     * Use uuid as primary key.
     */
    'uuids' => false,

    /*
     * User tables foreign key name.
     */
    'user_foreign_key' => 'user_id',
	
    /*
     * Anime tables foreign key name.
     */
    'anime_foreign_key' => 'anime_id',	

    /*
     * Table name for favorites records.
     */
    'favorites_table' => 'favorites',

    /*
     * Model name for favorite record.
     */
    'favorite_model' => Animelhd\AnimesFavorite\Favorite::class,

	/*
     * Model name for favoriteable record.
     */
    'favoriteable_model' => App\Models\Anime::class,

     /*
     * Model name for favoriter model.
     */
    'favoriter_model' => App\Models\User::class,
];
