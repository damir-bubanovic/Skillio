<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuestionCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_create_question(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/questions', [
            'question_text'  => 'What is 2 + 2?',
            'option_a'       => '3',
            'option_b'       => '4',
            'option_c'       => '5',
            'option_d'       => '6',
            'option_e'       => null,
            'correct_option' => 'b',
            'explanation'    => '2 + 2 = 4',
            'category'       => 'Math',
            'difficulty'     => 'easy',
        ]);

        $response->assertRedirect(route('admin.questions.index'));

        $this->assertDatabaseHas('questions', [
            'question_text'  => 'What is 2 + 2?',
            'correct_option' => 'b',
            'category'       => 'Math',
            'difficulty'     => 'easy',
        ]);
    }

    public function test_admin_can_update_question(): void
    {
        $admin = $this->createAdmin();

        $question = Question::create([
            'question_text'  => 'Old text',
            'option_a'       => 'A1',
            'option_b'       => 'B1',
            'option_c'       => 'C1',
            'option_d'       => 'D1',
            'option_e'       => null,
            'correct_option' => 'a',
            'explanation'    => null,
            'category'       => 'General',
            'difficulty'     => 'medium',
            'created_by'     => $admin->id,
        ]);

        $response = $this->actingAs($admin)->put("/admin/questions/{$question->id}", [
            'question_text'  => 'Updated text',
            'option_a'       => 'A2',
            'option_b'       => 'B2',
            'option_c'       => 'C2',
            'option_d'       => 'D2',
            'option_e'       => null,
            'correct_option' => 'b',
            'explanation'    => 'Updated explanation',
            'category'       => 'Updated',
            'difficulty'     => 'hard',
        ]);

        $response->assertRedirect(route('admin.questions.index'));

        $this->assertDatabaseHas('questions', [
            'id'             => $question->id,
            'question_text'  => 'Updated text',
            'correct_option' => 'b',
            'category'       => 'Updated',
            'difficulty'     => 'hard',
        ]);
    }
}
