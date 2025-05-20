<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ActivityEdition extends Model
{
    use HasFactory;

    protected $table = 'activities_editions';

    protected $fillable = [
        'name',
        'status',
        'slug',
        'activity_id',
        'active_from',
        'active_to',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','activityEdition')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

    public function tasks()
    {
        return $this->hasMany(ActivitySpecialTasks::class, 'edition_id','id')->withTimeLeft();
    }
    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','activity-edition-header')
            ->orderBy('id','desc');
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('activities_editions.*, DATEDIFF(activities_editions.active_to,NOW()) AS time_left');
        #$query->selectRaw('activities_editions.*, DATE_PART(\'day\',activities_editions.active_to::timestamp - NOW::timestamp) AS time_left');
    }
}
