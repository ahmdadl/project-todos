<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        "completed" => "boolean",
        "cost" => "float",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
