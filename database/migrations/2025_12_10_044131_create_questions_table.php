<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('option_e')->nullable(); // optional 5th option
            $table->string('correct_option'); // store 'a', 'b', 'c', 'd', 'e'
            $table->text('explanation')->nullable();
            $table->string('category')->nullable(); // later we may replace with categories table
            $table->string('difficulty')->default('medium'); // easy, medium, hard
            $table->string('image_path')->nullable(); // optional image file
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
