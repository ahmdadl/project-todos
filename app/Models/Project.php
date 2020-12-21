<?php

namespace App\Models;

use App\Events\ProjectUpdated;
use App\Events\ProjectEvent;
use App\Events\RefreshCachedCategoryList;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'completed' => 'boolean',
        'cost' => 'float',
        'user_id' => 'int',
    ];

    protected $guarded = [];

    protected $appends = ['img_path'];

    protected $dispatchesEvents = [
        'created' => RefreshCachedCategoryList::class,
        'updated' => ProjectUpdated::class,
        'deleted' => RefreshCachedCategoryList::class,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImgPathAttribute(): string
    {
        return Storage::disk('public')->url($this->image);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
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

    public function isTeamMember(int $id): bool
    {
        return DB::table('project_user')
            ->where('project_id', $this->id)
            ->where('user_id', $id)
            ->exists();
    }
}
