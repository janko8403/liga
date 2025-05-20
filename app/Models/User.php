<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'validated',
        'deleted_at',
        'last_verification_email',
        'network',
        'phone',
        'position',
        'nepu',
        'njs',
        'region',
        'lastname',
        'last_comment'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function photo() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','user-avatar')
            ->orderBy('created_at','desc')
            ->limit(1);
    }
    public function new_photo() {
        return $this->hasOne(File::class,'activity_id','id')
            ->where('type','user-new-avatar')
            ->orderBy('created_at','desc')
            ->limit(1);
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
