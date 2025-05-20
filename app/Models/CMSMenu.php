<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSMenu extends Model
{
    use HasFactory;

    protected $table = 'cms_menu';

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'slug',
        'published',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function submenus() {
        return $this->hasMany(CMSMenu::class,'parent_id','id');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','cmsMenu')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function children() {
        return $this->hasMany(CMSMenu::class,'parent_id','id')
            ->orderBy('order_id','asc');
    }
}
