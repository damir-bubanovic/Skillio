<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Timed / untimed
            $table->boolean('is_timed')->default(true);
            $table->unsignedInteger('duration_minutes')->nullable(); // null = untimed

            // Attempts
            $table->unsignedInteger('attempt_limit')->nullable(); // null = unlimited

            // Behaviour
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('shuffle_options')->default(true);

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
