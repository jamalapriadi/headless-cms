<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
