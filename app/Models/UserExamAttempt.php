<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Exam;
use App\Models\UserExamAnswer;

class UserExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'attempt_number',
        'started_at',
        'completed_at',
        'status',
        'total_questions',
        'correct_count',
        'incorrect_count',
        'skipped_count',
        'score',
        'percentage',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(UserExamAnswer::class);
    }
}
