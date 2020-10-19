<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'at',
        'ip',
        'from',
        'user_agent',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'at',
    ];

    /**
     * Relationship with the user model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
