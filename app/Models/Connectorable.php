<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Connectorable extends MorphPivot
{
//    public $timestamps = false;

    protected $fillable = [
        'connector_id',
        'connectorable_id',
        'connectorable_type',
    ];

    protected $casts = [
        'connector_id'        => 'string',
        'connectorable_id'    => 'string',
        'connectorable_type'  => 'string',
    ];
}
