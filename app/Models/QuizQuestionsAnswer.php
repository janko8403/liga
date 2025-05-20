<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionsAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='quiz_answers';

    public function question() {
        return $this->hasMany(QuizQuestionsOption::class, 'id','question_id');
    }
}
