<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSComponents extends Model
{
    use HasFactory;

    protected $table = 'cms_components';

    protected $fillable = [
        'name',
        'description',
        'component_path',
        'parameters',
    ];

    protected $hidden = [];

    protected $casts = [];

    protected function parameters(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

}
