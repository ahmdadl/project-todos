<?php

namespace App\Models;

use App\Events\RefreshCachedCategoryList;
use App\Events\TodoAdded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(function(Todo $todo) {
            event(new RefreshCachedCategoryList);
            TodoAdded::dispatch($todo);
        });

        self::deleted(fn() => event(new RefreshCachedCategoryList));
    }
}
