<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissionDict extends Model
{
    use HasFactory;

    protected $table = 'user_permissions';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [];
    protected $casts = [];
}
