<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Label extends Model
{
    use SoftDeletes;

    public $table = 'labels';
    public $timestamps = true;

    protected $guarded = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany('App\Models\Ticket');
    }
}
