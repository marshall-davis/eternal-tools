<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackstoryTrait extends Model
{
    protected $table = 'backstory_traits';
    protected $guarded = [
        'id',
    ];
}
