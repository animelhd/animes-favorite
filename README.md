## Laravel Favorite

❤️ User favorite feature for Laravel Application.

[![CI](https://github.com/overtrue/laravel-favorite/workflows/CI/badge.svg)](https://github.com/overtrue/laravel-favorite/actions)
[![Latest Stable Version](https://poser.pugx.org/overtrue/laravel-favorite/v/stable.svg)](https://packagist.org/packages/overtrue/laravel-favorite)
[![Latest Unstable Version](https://poser.pugx.org/overtrue/laravel-favorite/v/unstable.svg)](https://packagist.org/packages/overtrue/laravel-favorite)
[![Total Downloads](https://poser.pugx.org/overtrue/laravel-favorite/downloads)](https://packagist.org/packages/overtrue/laravel-favorite)
[![License](https://poser.pugx.org/overtrue/laravel-favorite/license)](https://packagist.org/packages/overtrue/laravel-favorite)

[![Sponsor me](https://github.com/overtrue/overtrue/blob/master/sponsor-me-button-s.svg?raw=true)](https://github.com/sponsors/overtrue)

## Installing

```shell
composer require animelhd/animes-favorite -vvv
```

### Configuration & Migrations

```php
php artisan vendor:publish --provider="Animelhd\AnimesFavorite\FavoriteServiceProvider"
```

## Usage

### Traits

#### `Animelhd\AnimesFavorite\Traits\Favoriter`

```php

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Animelhd\AnimesFavorite\Traits\Favoriter;

class User extends Authenticatable
{
    use Favoriter;

    <...>
}
```

#### `Animelhd\AnimesFavorite\Traits\Favoriteable`

```php
use Illuminate\Database\Eloquent\Model;
use Animelhd\AnimesFavorite\Traits\Favoriteable;

class Post extends Model
{
    use Favoriteable;

    <...>
}
```

### API

```php
$user = User::find(1);
$post = Post::find(2);

$user->favorite($post);
$user->unfavorite($post);
$user->toggleFavorite($post);
$user->getFavoriteItems(Post::class)

$user->hasFavorited($post);
$post->hasBeenFavoritedBy($user);
```

#### Get object favoriters:

```php
foreach($post->favoriters as $user) {
    // echo $user->name;
}
```

#### Get Favorite Model from User.

Used Favoriter Trait Model can easy to get Favoriteable Models to do what you want.
_note: this method will return a `Illuminate\Database\Eloquent\Builder` _

```php
$user->getFavoriteItems(Post::class);

// Do more
$favoritePosts = $user->getFavoriteItems(Post::class)->get();
$favoritePosts = $user->getFavoriteItems(Post::class)->paginate();
$favoritePosts = $user->getFavoriteItems(Post::class)->where('title', 'Laravel-Favorite')->get();
```

### Aggregations

```php
// all
$user->favorites()->count();

// with type
$user->favorites()->withType(Post::class)->count();

// favoriters count
$post->favoriters()->count();
```

List with `*_count` attribute:

```php
$users = User::withCount('favorites')->get();

foreach($users as $user) {
    echo $user->favorites_count;
}


// for Favoriteable models:
$posts = Post::withCount('favoriters')->get();

foreach($posts as $post) {
    echo $post->favorites_count;
}
```

### Attach user favorite status to favoriteable collection

You can use `Favoriter::attachFavoriteStatus($favoriteables)` to attach the user favorite status, it will set `has_favorited` attribute to each model of `$favoriteables`:

#### For model

```php
$post = Post::find(1);

$post = $user->attachFavoriteStatus($post);

// result
[
    "id" => 1
    "title" => "Add socialite login support."
    "created_at" => "2021-05-20T03:26:16.000000Z"
    "updated_at" => "2021-05-20T03:26:16.000000Z"
    "has_favorited" => true
 ],
```

#### For `Collection | Paginator | CursorPaginator | array`:

```php
$posts = Post::oldest('id')->get();

$posts = $user->attachFavoriteStatus($posts);

$posts = $posts->toArray();

// result
[
  [
    "id" => 1
    "title" => "Post title1"
    "created_at" => "2021-05-20T03:26:16.000000Z"
    "updated_at" => "2021-05-20T03:26:16.000000Z"
    "has_favorited" => true
  ],
  [
    "id" => 2
    "title" => "Post title2"
    "created_at" => "2021-05-20T03:26:16.000000Z"
    "updated_at" => "2021-05-20T03:26:16.000000Z"
    "has_favorited" => false
  ],
  [
    "id" => 3
    "title" => "Post title3"
    "created_at" => "2021-05-20T03:26:16.000000Z"
    "updated_at" => "2021-05-20T03:26:16.000000Z"
    "has_favorited" => true
  ],
]
```

#### For pagination

```php
$posts = Post::paginate(20);

$user->attachFavoriteStatus($posts);
```

### N+1 issue

To avoid the N+1 issue, you can use eager loading to reduce this operation to just 2 queries. When querying, you may specify which relationships should be eager loaded using the `with` method:

```php
// Favoriter
$users = User::with('favorites')->get();

foreach($users as $user) {
    $user->hasFavorited($post);
}

// with favoriteable object
$users = User::with('favorites.favoriteable')->get();

foreach($users as $user) {
    $user->hasFavorited($post);
}

// Favoriteable
$posts = Post::with('favorites')->get();
// or
$posts = Post::with('favoriters')->get();

foreach($posts as $post) {
    $post->isFavoritedBy($user);
}
```

### Events

| **Event**                                     | **Description**                             |
| --------------------------------------------- | ------------------------------------------- |
| `Animelhd\AnimesFavorite\Events\Favorited`   | Triggered when the relationship is created. |
| `Animelhd\AnimesFavorite\Events\Unfavorited` | Triggered when the relationship is deleted. |

## License

MIT
