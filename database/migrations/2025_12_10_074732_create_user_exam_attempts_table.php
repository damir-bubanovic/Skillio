<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_exam_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');

            $table->unsignedInteger('attempt_number')->default(1);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->string('status')->default('in_progress'); // in_progress, completed

            $table->unsignedInteger('total_questions')->default(0);
            $table->unsignedInteger('correct_count')->default(0);
            $table->unsignedInteger('incorrect_count')->default(0);
            $table->unsignedInteger('skipped_count')->default(0);
            $table->unsignedInteger('score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);

            $table->timestamps();

            $table->index(['user_id', 'exam_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_exam_attempts');
    }
};
