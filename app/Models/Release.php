<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Release extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];
    protected $casts = ['published_at' => 'datetime'];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }

    public function toSearchableArray()
    {
        return $this->only(['version', 'body', 'repo_id', 'published_at']);
    }
}
