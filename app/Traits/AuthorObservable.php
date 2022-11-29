<?php
namespace App\Traits;

use App\Observers\AuthorObserver;

trait AuthorObservable
{
    public static function bootAuthorObservable()
    {
        self::observe(AuthorObserver::class);
    }
}
