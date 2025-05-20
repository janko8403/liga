<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'active_from',
        'active_to',
        'status',
        'content',
    ];

    protected $table = 'notifications';

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','notification')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    protected $casts = [
        'status' => 'boolean',
    ];
}
