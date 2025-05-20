<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialTaskPoints extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='special_task_points';
}
