<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackstoryNationality extends Model
{
    protected $table = 'backstory_nationalities';
    protected $guarded = [
        'id',
    ];

    use SoftDeletes;
}
