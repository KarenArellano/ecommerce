<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'title',
        'excerpt',
        'content',
        'is_published',
        'published_at',
        'cover',
        'tags',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'tags' => 'collection',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cover_url',
        'slugify_tags',
    ];

    /**
     * Retrieve the coverUrl attribute.
     *
     * @return    string
     */
    public function getCoverUrlAttribute()
    {
        if ($coverPath = $this->attributes['cover']) {
            return url()->isValidUrl($this->attributes['cover']) ? $this->attributes['cover'] : app('filesystem')->disk('s3')->url($this->attributes['cover']);
        }

        return null;
    }

    /**
     * Retrieve the slugifyTags attribute.
     *
     * @return array
     */
    public function getSlugifyTagsAttribute()
    {
        return $this->tags->map(function ($tag) {
            return Str::slug($tag);
        });
    }

    /**
     * Relationship with the User model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Query scope "published".
     *
     * @param    Illuminate\Database\Query\Builder    $query
     * @return    Illuminate\Database\Query\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    /**
     * Query scope "drafts".
     *
     * @param    Illuminate\Database\Query\Builder    $query
     * @return    Illuminate\Database\Query\Builder
     */
    public function scopeDrafts($query)
    {
        return $query->where('is_published', false)->whereNull('published_at');
    }

    /**
     * Query scope "firstOrFailBySlug".
     *
     * @param. Illuminate\Database\Query\Builder. $query
     * @param. string. $value
     *
     * @return. Illuminate\Database\Query\Builder
     */
    public function scopeFirstOrFailBySlug($query, $slug)
    {
        return $query->where(compact('slug'))->firstOrFail();
    }

    /**
     * Renders the post content as HTML
     *
     * @return string
     */
    public function renderContentAsHtml()
    {
        $blocks = collect(json_decode($this->attributes['content'], true));

        return $blocks->map(function ($block) {
            $content = '';

            $content .= view("dashboard.posts.components.{$block['type']}", compact('block'))->render();

            return $content;
        })->join('');
    }

    /**
     * Query scope "searchByTag".
     *
     * @param  Illuminate\Database\Query\Builder  $query
     * @param  string. $tag
     * @return. Illuminate\Database\Query\Builder
     */
    public function scopeSearchByTag($query, $tag)
    {
        if (!is_null($tag)) {
            $query->where('tags', 'like', "%{$tag}%");
        }
    }

}
