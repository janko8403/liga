<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['*'];
    protected $table ='quiz_questions';

    public function edition() {
        return $this->hasOne(ActivitySpecialTasks::class, 'id','special_task_id');
    }

    protected $casts = [
        'status' => 'boolean',
    ];

    public function options() {
        return $this->hasMany(QuizQuestionsOption::class,'question_id','id');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class,'id','activity_id')->where('permission_type','=','quiz_question');
    }
}
