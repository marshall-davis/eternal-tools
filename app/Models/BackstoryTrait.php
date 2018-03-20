<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackstoryTrait extends Model
{
    protected $table = 'backstory_traits';
    protected $guarded = [
        'id',
    ];

    use SoftDeletes;
}
