<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use MeiliSearch\Client;
use MeiliSearch\MeiliSearch;

class Release extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['version', 'body', 'github_url', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }

    public function toSearchableArray()
    {
        return $this->only(['version', 'body', 'repo_id']);
    }

    public static function updateMeiliConfig()
    {
        if (class_exists(MeiliSearch::class)) {
            $client = app(Client::class);
            $index = $client->index((new self)->searchableAs());
            $index->updateFilterableAttributes(['repo_id']);
            $index->updateSortableAttributes(['version']);
            $index->updateRankingRules([
                'words',
                'sort',
                'typo',
                'proximity',
                'attribute',
                'exactness',
            ]);
        }
    }
}
