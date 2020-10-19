<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SheduleCart extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_days'
    ];
}
