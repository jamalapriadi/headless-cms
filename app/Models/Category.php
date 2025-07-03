<?php

namespace App\Models;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }
}
