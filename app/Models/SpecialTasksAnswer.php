<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialTasksAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table= 'special_tasks_answers';
}
