<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status', // 'published', 'draft'
        'featured_image',
        'featured_image_caption',
        'author_id',
        'category_id',
        'subtitle',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'read_time',
        'word_count',
        'custom_schema',
        'content_type',
        'published_at',
        'views',
        'meta_schema',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
        'read_time' => 'integer',
        'word_count' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }
}
