<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='duels';

    public function edition() {
        return $this->hasOne(DuelEdition::class, 'id','edition_id');
    }

    public function firstContender()
    {
        return $this->hasOne(DuelData::class,'nepu_msk','first_nepu' );
    }

    public function secondContender()
    {
        return $this->hasOne(DuelData::class,'nepu_msk','second_nepu' );
    }

    protected $casts = [
        'status' => 'boolean',
    ];
    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','duel')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('duels.*, DATEDIFF(duels.active_to,NOW()) AS time_left');
        #$query->selectRaw('duels.*, DATE_PART(\'day\',duels.active_to::timestamp - NOW::timestamp) AS time_left');
    }

}
