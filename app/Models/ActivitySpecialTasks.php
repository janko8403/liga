<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitySpecialTasks extends Model
{
    use HasFactory;

    protected $table ='activities_special_tasks';

    public function rules()
    {
        return [
            'active_from' => ['required','date'],
            'active_to' => ['required','date','after:active_from'],
        ];
    }

    public function messages()
    {
        return [
            'active_from.required' => 'Data początkowa jest wymagana',
            'active_to.required' => 'Data końcowa aktywności jest wymagana',
            'active_to.after' => 'Data końcowa nie może być wcześniejsza niż początkowa',
        ];
    }

    protected $fillable = [
        'name',
        'status',
        'active_from',
        'active_to',
        'quiz_percentage_points',
        'quiz_time',
        'quiz_ranking_points',
        'quiz_locked',
        'description',
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
            ->where('permission_type','=','task')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','special-task-header')
            ->orderBy('id','desc');
    }

    public function miniheader() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','miniheader')
            ->orderBy('id','desc');
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('activities_special_tasks.*, DATEDIFF(activities_special_tasks.active_to,NOW()) AS time_left');
        #$query->selectRaw('activities_special_tasks.*, DATE_PART(\'day\',activities_special_tasks.active_to::timestamp - NOW::timestamp) AS time_left');
    }

}
