<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    public function test_get_subjects(): void
    {
        $response = $this->get('/api/students/1/subjects'); //test the subject load of the student with student_id = 1
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'metadata' => [
                    "count",
                    "search",
                    "limit",
                    "offset",
                    "fields" => [],
                ],
                'students' => [
                    '*' => [
                        "id",
                        "student_id",
                        "subject_code",
                        "name",
                        "description",
                        "instructor",
                        "schedule",
                        "grades",
                        "average_grade",
                        "remarks",
                        "date_taken",
                    ]
                ]
            ])->assertJsonCount($response["metadata"]["limit"], 'students'); //test if limit is working
    }

    public function test_create_subjects()
    {
        $grades_arr = [1.0, 1.5, 1.0, 1.5];
        $avg = array_sum($grades_arr) / count($grades_arr);
        $remarks = ($avg <= 3.0) ? "PASSED" : "FAILED";

        $subjectData = [
            "student_id" => 1,
            "subject_code" => "IT302",
            "name" => "AP Cycle",
            "description" => "Some Description",
            "instructor" => "Sir Cy",
            "schedule" => "T TH",
            "grades" => '{
                "prelims" : 1.0,
                "midterms" : 1.0,
                "prefinals" : 1.0,
                "finals" : 1.0
            }',
            "average_grade" => $avg,
            "remarks" => $remarks,
            "date_taken" => '2001-02-02',
        ];

        $response = $this->postJson('/api/students/1/subjects', $subjectData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'student_id' => $subjectData['student_id'] //Test if the Json response has the firstname data
            ]);

        $this->assertDatabaseHas('students_info', $subjectData); //Test the DB with the rest of the field
    }

    // public function test_update_students()
    // {
    //     //Add a new student to be patched
    //     $student = StudentInfo::factory()->create();

    //     $updateData = [
    //          'firstname' => 'Updated Firstname',
    //          'lastname' => 'Updated Lastname',
    //          'birthdate' => '2001-02-02',
    //          'sex' => 'FEMALE',
    //          'address' => '456 Elm St',
    //          'year' => 4,
    //          'course' => 'BSIT',
    //          'section' => 'B',
    //      ];

    //      $response = $this->patchJson("/api/students/{$student->id}", $updateData);

    //      $response
    //          ->assertStatus(200)
    //          ->assertJson([
    //              'firstname' => $updateData['firstname']
    //          ]);

    //      $this->assertDatabaseHas('students_info', $updateData);
    //  }
}
