<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\StudentManagement\Models\Student;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\UserManagement\Models\User;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create test user
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'username' => 'testuser',
        'is_active' => true,
    ]);

    // Create grade levels
    $this->gradeLevel1 = GradeLevel::create([
        'name' => 'Grade 1',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $this->gradeLevel2 = GradeLevel::create([
        'name' => 'Grade 2', 
        'sort_order' => 2,
        'is_active' => true,
    ]);

    // Create grade level classes
    $this->class1 = GradeLevelClass::create([
        'name' => 'Grade 1 - Class A',
        'grade_level_id' => $this->gradeLevel1->id,
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $this->class2 = GradeLevelClass::create([
        'name' => 'Grade 1 - Class B',
        'grade_level_id' => $this->gradeLevel1->id,
        'sort_order' => 2,
        'is_active' => true,
    ]);

    $this->class3 = GradeLevelClass::create([
        'name' => 'Grade 2 - Class A',
        'grade_level_id' => $this->gradeLevel2->id,
        'sort_order' => 1,
        'is_active' => true,
    ]);

    // Create test students
    $this->students = collect([
        Student::create([
            'admission_number' => '2024001',
            'full_name' => 'John Doe',
            'full_name_with_title' => 'Mr. John Doe',
            'grade_level_class_id' => $this->class1->id,
            'grade_level_id' => $this->gradeLevel1->id,
            'has_dropped_out' => false,
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'student_phone' => '0987654321',
            'student_email' => 'john.student@example.com',
        ]),
        Student::create([
            'admission_number' => '2024002',
            'full_name' => 'Jane Smith',
            'full_name_with_title' => 'Ms. Jane Smith',
            'grade_level_class_id' => $this->class1->id,
            'grade_level_id' => $this->gradeLevel1->id,
            'has_dropped_out' => false,
            'email' => 'jane@example.com',
            'phone' => '1234567891',
        ]),
        Student::create([
            'admission_number' => '2024003',
            'full_name' => 'Bob Wilson',
            'full_name_with_title' => 'Mr. Bob Wilson',
            'grade_level_class_id' => $this->class2->id,
            'grade_level_id' => $this->gradeLevel1->id,
            'has_dropped_out' => false,
            'email' => 'bob@example.com',
        ]),
        Student::create([
            'admission_number' => '2024004',
            'full_name' => 'Alice Brown',
            'full_name_with_title' => 'Ms. Alice Brown',
            'grade_level_class_id' => $this->class2->id,
            'grade_level_id' => $this->gradeLevel1->id,
            'has_dropped_out' => true, // This student dropped out
            'email' => 'alice@example.com',
        ]),
        Student::create([
            'admission_number' => '2024005',
            'full_name' => 'Charlie Davis',
            'full_name_with_title' => 'Mr. Charlie Davis',
            'grade_level_class_id' => $this->class3->id,
            'grade_level_id' => $this->gradeLevel2->id,
            'has_dropped_out' => false,
            'email' => 'charlie@example.com',
        ]),
    ]);
});

it('returns students by class successfully', function () {
    // Authenticate user
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class1->id,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Students retrieved successfully',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'admission_number',
                        'full_name',
                        'full_name_with_title',
                        'grade_level_class_id',
                        'grade_level_id',
                        'email',
                        'phone',
                        'student_phone',
                        'student_email',
                        'grade_level_class',
                        'grade_level',
                        'school_house',
                    ],
                ],
                'total',
            ],
        ]);

    $responseData = $response->json('data');
    expect($responseData['total'])->toBe(2); // Only 2 active students in class 1
    expect($responseData['data'])->toHaveCount(2);

    // Verify students are ordered by admission number
    expect($responseData['data'][0]['admission_number'])->toBe('2024001');
    expect($responseData['data'][1]['admission_number'])->toBe('2024002');

    // Verify only active students are returned (no dropped out students)
    $admissionNumbers = collect($responseData['data'])->pluck('admission_number');
    expect($admissionNumbers)->not->toContain('2024004'); // Dropped out student
});

it('filters out dropped out students', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class2->id,
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    expect($responseData['total'])->toBe(1); // Only 1 active student in class 2 (Alice dropped out)
    expect($responseData['data'][0]['admission_number'])->toBe('2024003'); // Only Bob Wilson
});

it('returns empty result for class with no students', function () {
    Sanctum::actingAs($this->user);

    // Create a new class with no students
    $emptyClass = GradeLevelClass::create([
        'name' => 'Empty Class',
        'grade_level_id' => $this->gradeLevel1->id,
        'sort_order' => 3,
        'is_active' => true,
    ]);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $emptyClass->id,
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    expect($responseData['total'])->toBe(0);
    expect($responseData['data'])->toBeEmpty();
});

it('returns students from different class correctly', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class3->id,
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    expect($responseData['total'])->toBe(1);
    expect($responseData['data'][0]['admission_number'])->toBe('2024005');
    expect($responseData['data'][0]['full_name'])->toBe('Charlie Davis');
});

it('requires authentication', function () {
    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class1->id,
    ]);

    $response->assertStatus(401);
});

it('validates required grade_level_class_id parameter', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['grade_level_class_id']);
});

it('validates grade_level_class_id is integer', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => 'invalid',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['grade_level_class_id']);
});

it('handles non-existent class id gracefully', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => 99999, // Non-existent class
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    expect($responseData['total'])->toBe(0);
    expect($responseData['data'])->toBeEmpty();
});

it('includes relationships in response', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class1->id,
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    $student = $responseData['data'][0];

    // Verify relationships are loaded
    expect($student)->toHaveKey('grade_level_class');
    expect($student)->toHaveKey('grade_level');
    expect($student)->toHaveKey('school_house');

    // Verify grade_level_class relationship data
    expect($student['grade_level_class'])->not->toBeNull();
    expect($student['grade_level_class']['id'])->toBe($this->class1->id);
});

it('orders students by admission number', function () {
    Sanctum::actingAs($this->user);

    // Create additional students with different admission numbers to test ordering
    Student::create([
        'admission_number' => '2024000', // Should come first
        'full_name' => 'Early Student',
        'grade_level_class_id' => $this->class1->id,
        'grade_level_id' => $this->gradeLevel1->id,
        'has_dropped_out' => false,
    ]);

    Student::create([
        'admission_number' => '2024010', // Should come last
        'full_name' => 'Late Student',
        'grade_level_class_id' => $this->class1->id,
        'grade_level_id' => $this->gradeLevel1->id,
        'has_dropped_out' => false,
    ]);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => $this->class1->id,
    ]);

    $response->assertStatus(200);
    
    $responseData = $response->json('data');
    $admissionNumbers = collect($responseData['data'])->pluck('admission_number')->all();

    expect($admissionNumbers)->toBe(['2024000', '2024001', '2024002', '2024010']);
});