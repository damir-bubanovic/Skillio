<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_exam_attempt_id')
                  ->constrained('user_exam_attempts')
                  ->onDelete('cascade');

            $table->foreignId('question_id')
                  ->constrained('questions')
                  ->onDelete('cascade');

            $table->string('selected_option')->nullable(); // a, b, c, d, e, or null if not answered
            $table->boolean('is_correct')->default(false);
            $table->unsignedInteger('time_spent_seconds')->nullable();

            $table->timestamps();

            $table->unique(['user_exam_attempt_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_exam_answers');
    }
};
