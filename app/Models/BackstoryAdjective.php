<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackstoryAdjective extends Model
{
    protected $table = 'backstory_adjectives';
    protected $guarded = [
        'id',
    ];

    use SoftDeletes;
}
