<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'color'
    ];

    public function connectors(): MorphToMany
    {
        return $this->morphedByMany(Connector::class, 'taggable');
    }
}
