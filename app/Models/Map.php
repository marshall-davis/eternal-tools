<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Map extends Model
{
    protected $table = 'maps';
    protected $guarded = [
        'id',
    ];

    use SoftDeletes;
}
