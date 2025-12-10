<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentExamFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    protected function createStudent(): User
    {
        return User::factory()->create(['role' => 'student']);
    }

    protected function createExamWithQuestions(): Exam
    {
        $admin = $this->createAdmin();

        $q1 = Question::create([
            'question_text'  => 'Q1?',
            'option_a'       => 'A1',
            'option_b'       => 'B1',
            'option_c'       => 'C1',
            'option_d'       => 'D1',
            'option_e'       => null,
            'correct_option' => 'a',
            'explanation'    => null,
            'category'       => 'Cat1',
            'difficulty'     => 'easy',
            'created_by'     => $admin->id,
        ]);

        $q2 = Question::create([
            'question_text'  => 'Q2?',
            'option_a'       => 'A2',
            'option_b'       => 'B2',
            'option_c'       => 'C2',
            'option_d'       => 'D2',
            'option_e'       => null,
            'correct_option' => 'b',
            'explanation'    => null,
            'category'       => 'Cat2',
            'difficulty'     => 'medium',
            'created_by'     => $admin->id,
        ]);

        $exam = Exam::create([
            'title'            => 'Demo Exam',
            'description'      => null,
            'is_timed'         => false,
            'duration_minutes' => null,
            'attempt_limit'    => null,
            'shuffle_questions'=> false,
            'shuffle_options'  => false,
            'is_active'        => true,
            'created_by'       => $admin->id,
        ]);

        $exam->questions()->sync([
            $q1->id => ['question_order' => 1],
            $q2->id => ['question_order' => 2],
        ]);

        return $exam;
    }

    public function test_student_can_take_exam_and_get_score(): void
    {
        $student = $this->createStudent();
        $exam = $this->createExamWithQuestions();

        // Start exam
        $this->actingAs($student)
            ->post(route('student.exams.start', $exam))
            ->assertRedirect();

        $attempt = $student->examAttempts()->where('exam_id', $exam->id)->first();
        $this->assertNotNull($attempt);

        $this->assertDatabaseCount('user_exam_answers', 2);

        $answersPayload = [
            'answers' => [
                $exam->questions[0]->id => 'a', // correct
                $exam->questions[1]->id => 'c', // incorrect
            ],
        ];

        $this->actingAs($student)
            ->post(route('student.exams.submit', [$exam, $attempt]), $answersPayload)
            ->assertRedirect(route('student.exams.result', [$exam, $attempt]));

        $attempt->refresh();

        $this->assertEquals(2, $attempt->total_questions);
        $this->assertEquals(1, $attempt->correct_count);
        $this->assertEquals(1, $attempt->incorrect_count);
        $this->assertEquals(0, $attempt->skipped_count);
        $this->assertEquals(50.00, $attempt->percentage);
    }
}
