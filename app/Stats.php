<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    /**
     * @var string
     */
    protected $table = 'stats';

    /**
     * @var array
     */
    protected $fillable = [
        'date',
        'min',
        'max',
        'avg',
    ];
}
