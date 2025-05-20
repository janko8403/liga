<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestData extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='contests_data';

}
