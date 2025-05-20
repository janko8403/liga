<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'active_from',
        'active_to',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','activity')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','header')
            ->orderBy('id','desc');
    }

    public function editions() {
        return $this->hasMany(ActivityEdition::class, 'activity_id', 'id')
            ->orderBy('created_at','desc');
    }

    public function getAllPermissions()
    {
        return UserPermission::get();
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('activities.*, DATEDIFF(activities.active_to,NOW()) AS time_left');
        #$query->selectRaw('activities.*, DATE_PART(\'day\',activities.active_to::timestamp - NOW::timestamp) AS time_left');
    }
}
