<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelConfig extends Model
{
    use HasFactory;

    protected $table = 'duels_settings';

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
            ->where('permission_type','=','duelsConfig')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','duels-header')
            ->orderBy('id','desc');
    }

    public function editions() {
        return $this->hasMany(ActivityEdition::class, 'activity_id', 'id')
            ->orderBy('created_at','desc');
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('duels_settings.*, DATEDIFF(duels_settings.active_to,NOW()) AS time_left');
        #$query->selectRaw('duels_settings.*, DATE_PART(\'day\',duels_settings.active_to::timestamp - NOW::timestamp) AS time_left');
    }

}
