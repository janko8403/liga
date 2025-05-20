<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSSection extends Model
{
    use HasFactory;

    protected $table = 'cms_sections';

    protected $fillable = [
        'menu_id',
        'order_id',
        'columns',
        'published',
        'component_id'
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function component() {
        return $this->hasOne(CMSComponents::class,'id','component_id');
    }

    public function data() {

        return $this->hasMany(CMSComponentData::class, 'section_id','id');
        #->where('id','component_id');
    }

    public function page() {
        return $this->hasOne(CMSMenu::class,'id','menu_id');
    }
}
