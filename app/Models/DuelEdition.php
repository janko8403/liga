<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelEdition extends Model
{
    use HasFactory;

    protected $table = 'duels_editions';

    protected $fillable = [
        'activity_id',
        'name',
        'category',
        'status',
        'active_from',
        'active_to',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function header() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','duel-edition-header')
            ->orderBy('id','desc');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'activity_id','id')
            ->where('permission_type','=','duelEdition')
            ->leftJoin('user_permissions', 'user_permission_id', 'user_permissions.id');
    }
    public function teams()
    {
        return $this->hasMany(DuelData::class, 'edition_id', 'edition_id');
    }

    public function teamsCount(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return Attribute::make(
            get: fn ($value) =>$this->teams()->distinct('dsk')->count()
        );
    }

    public function scopeWithTimeLeft($query)
    {
        $query->selectRaw('duels_editions.*, DATEDIFF(duels_editions.active_to,NOW()) AS time_left');
        #postgre
        #$query->selectRaw('duels_editions.*, DATE_PART(\'day\',duels_editions.active_to::timestamp - NOW::timestamp) AS time_left');
    }
}
