<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLeagueMSKData extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='activities_league_data_msk';
}
