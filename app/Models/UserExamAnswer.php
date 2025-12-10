<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserExamAttempt;
use App\Models\Question;

class UserExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_exam_attempt_id',
        'question_id',
        'selected_option',
        'is_correct',
        'time_spent_seconds',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function attempt()
    {
        return $this->belongsTo(UserExamAttempt::class, 'user_exam_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
