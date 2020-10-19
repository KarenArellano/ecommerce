<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'tags',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'collection',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'slugify_tags',
    ];

    /**
     * Retrieve the slugifyTags attribute.
     *
     * @return array
     */
    public function getSlugifyTagsAttribute()
    {
        return !$this->tags ? collect() : $this->tags->map(function ($tag) {
            return Str::slug($tag);
        });
    }

    /**
     * Relationship with the image model.
     *
     * @return. Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
