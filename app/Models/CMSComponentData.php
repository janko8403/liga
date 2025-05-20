<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSComponentData extends Model
{
    use HasFactory;

    protected $table = 'cms_components_data';

    protected $fillable = [
        'section_id',
        'component_id',
        'name',
        'value',
    ];

    protected $hidden = [];

    protected $casts = [];

}
