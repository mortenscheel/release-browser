<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
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

    public function scopeOrderByVersion(Builder $query, string $direction = 'asc')
    {
        $query->orderByRaw($this->inetAtonString() . " $direction");
    }

    public function scopeConstrainVersion(Builder $query, string $from, string $to = null)
    {
        $query->whereRaw(sprintf(
            "%s >= %s",
            $this->inetAtonString(),
            $this->inetAtonString(\Str::normalizeVersion($from))
        ));
        if ($to) {
            $query->whereRaw(sprintf(
                "%s <= %s",
                $this->inetAtonString(),
                $this->inetAtonString(\Str::normalizeVersion($to))
            ));
        }
    }

    private function inetAtonString(string $value = null): string
    {
        $value = $value ? "'$value'" : '`version`';

        return sprintf("INET_ATON(SUBSTRING_INDEX(CONCAT(%s,'.0.0.0'),'.',4))", $value);
    }
}
