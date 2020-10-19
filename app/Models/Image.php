<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'position', 'mimetype'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'public_url',
    ];

    /**
     * Retrieve the PublicUrl attribute.
     *
     * @return. string
     */
    public function getPublicUrlAttribute()
    {
        return url()->isValidUrl($this->url) ? $this->url : app('filesystem')->cloud()->temporaryUrl(
            $this->url, now()->addMinutes(30)
        );
    }

    /**
     * Relationships morphing to this image model.
     *
     * @return. Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

}
