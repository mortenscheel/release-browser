<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repo extends Model
{
    use HasFactory;

    protected $fillable = ['owner', 'repository'];

    public function releases(): HasMany
    {
        return $this->hasMany(Release::class);
    }

    public function name(): Attribute
    {
        return Attribute::get(fn() => $this->owner . '/' . $this->repository);
    }
}
