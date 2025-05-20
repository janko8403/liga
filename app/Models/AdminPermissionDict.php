<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermissionDict extends Model
{
    use HasFactory;

    protected $table = 'admin_permissions';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [];
    protected $casts = [];
}
