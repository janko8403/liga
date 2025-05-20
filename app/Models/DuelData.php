<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelData extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='duels_data';

    protected $casts = [
        'status' => 'boolean',
    ];

}
