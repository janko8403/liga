<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'active_from',
        'active_to',
        'description_before',
        'description_after',
        'type'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','contest-header')
            ->orderBy('id','desc');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','contest')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function scopeWithTimeLeft($query)
    {
        #sql
        $query->selectRaw('contests.*, DATEDIFF(contests.active_to,NOW()) AS time_left');
        #postgres
        #$query->selectRaw('contest.*, DATE_PART(\'day\',contest.active_to::timestamp - NOW::timestamp) AS time_left');
    }

    public function scopeWithScore($query,$nepu) {
        $query->selectRaw('(select wartosc from activities_sales_contests_data where edition_id=contests.id and nepu="'.$nepu.'" limit 1) as wartosc');
    }

    public function scopeWithAward($query,$nepu) {
        $query->selectRaw('(select nagroda from activities_sales_contests_data where edition_id=contests.id and nepu="'.$nepu.'" limit 1) as nagroda');
    }
}
