<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;

    protected $table = 'admins_permissions';

    protected $fillable = [
        'admin_id',
        'admin_permission_id',
        'permission_type',
    ];

    public function permission() {
        return $this->hasOne(AdminPermissionDict::class, 'id', 'admin_permission_id');
    }

    protected $hidden = [];
    protected $casts = [];
}
