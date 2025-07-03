<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = "languages";
    protected $primaryKey = "locale";
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'locale',
        'name',
        'is_default'
    ];
}
