<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'activity_id',
        'user_permission_id',
        'permission_type',
    ];

    public function permission() {
        return $this->hasOne(UserPermissionDict::class, 'id', 'user_permission_id');
    }

    public function permissionName() {
        $permission = $this->permission();
        return $permission->name;
    }

    protected $hidden = [];
    protected $casts = [];
}
