<?php

namespace App\Models;

use App\Events\RefreshCachedCategoryList;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'completed' => 'boolean',
        'cost' => 'float',
    ];

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => RefreshCachedCategoryList::class,
        'deleted' => RefreshCachedCategoryList::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }
}
