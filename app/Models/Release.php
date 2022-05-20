<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Release extends Model
{
    use HasFactory;

    protected $fillable = ['version', 'body'];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }
}
