<?php

namespace App\Models;

use App\Models\Card;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\LoginSession;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'is_customer',
        'is_administrator',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_customer',
        'is_administrator',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_customer' => 'boolean',
        'is_administrator' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'gravatar',
    ];

    /**
     * Bootstrap any model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::saving(function ($user) {
            $user->name = "$user->first_name $user->last_name";
        });
    }

    /**
     * Relationship with the address model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Relationship with the loginSession model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginSessions()
    {
        return $this->hasMany(LoginSession::class);
    }

    /**
     * Relationship with the order model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship with the product model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
    }

    /**
     * Relationship with the cart model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship with the card model.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * generates a new gravatar url
     *
     * @param int $size
     * @param string $default
     *
     * @return string
     */
    public function getGravatarAttribute($size = 120, $default = 'identicon')
    {
        $hashedEmail = md5(strtolower(trim($this->email)));

        return "https://gravatar.com/avatar/$hashedEmail?s=$size&d=$default";
    }
}
