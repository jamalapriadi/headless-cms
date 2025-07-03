<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }
}
