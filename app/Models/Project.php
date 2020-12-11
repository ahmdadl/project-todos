<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        "completed" => "boolean",
        "cost" => "float",
    ];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name",
            ],
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
