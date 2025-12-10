<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Question;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_timed',
        'duration_minutes',
        'attempt_limit',
        'shuffle_questions',
        'shuffle_options',
        'is_active',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_question')
            ->withTimestamps()
            ->withPivot('question_order')
            ->orderBy('exam_question.question_order');
    }

    public function attempts()
    {
        return $this->hasMany(\App\Models\UserExamAttempt::class);
    }


}
