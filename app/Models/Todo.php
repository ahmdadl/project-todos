<?php

namespace App\Models;

use App\Events\RefreshCachedCategoryList;
use App\Events\TodoAdded;
use App\Events\TodoCreated;
use App\Events\TodoDeleted;
use App\Events\TodoUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => TodoCreated::class,
        'updated' => TodoUpdated::class,
        // 'deleted' => TodoDeleted::class,
    ];
}
