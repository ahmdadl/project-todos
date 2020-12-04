<?php

namespace App\Models;

use App\Events\RefreshCachedCategoryList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(fn() => event(new RefreshCachedCategoryList));

        self::deleted(fn() => event(new RefreshCachedCategoryList));
    }
}
