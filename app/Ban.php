<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    /**
     * @var string
     */
    protected $table = 'bans';

    /**
     * @var array
     */
    protected $fillable = [
        'social_club_id',
        'banned_by',
        'reason'
    ];
}
