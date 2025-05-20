<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionsOption extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='quiz_questions_options';

    public function quiz() {
        return $this->belongsTo(QuizQuestion::class, 'id','question_id');
    }

    protected $casts = [
        'is_correct' => 'boolean',
    ];
}
