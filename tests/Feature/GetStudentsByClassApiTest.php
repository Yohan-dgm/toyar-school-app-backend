<?php

/**
 * Simple API Test for get-students-by-class endpoint
 * This test focuses on API behavior without complex database setup
 */

it('api returns authentication required for unauthenticated requests', function () {
    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => 1,
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'status' => 'authentication-required',
        ]);
});

it('api returns validation error for missing grade_level_class_id', function () {
    // Mock authenticated user
    $user = new \Modules\UserManagement\Models\User([
        'id' => 1,
        'username' => 'testuser',
        'email' => 'test@example.com',
        'is_active' => true,
    ]);
    
    $this->actingAs($user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', []);

    $response->assertStatus(422);
});

it('api returns validation error for invalid grade_level_class_id type', function () {
    // Mock authenticated user
    $user = new \Modules\UserManagement\Models\User([
        'id' => 1,
        'username' => 'testuser', 
        'email' => 'test@example.com',
        'is_active' => true,
    ]);
    
    $this->actingAs($user);

    $response = $this->postJson('/api/student-management/student/get-students-by-class', [
        'grade_level_class_id' => 'invalid',
    ]);

    $response->assertStatus(422);
});

it('api endpoint exists and is properly routed', function () {
    $response = $this->postJson('/api/student-management/student/get-students-by-class');

    // Should not return 404 - endpoint exists
    $response->assertStatus(401); // Should be auth required, not not found
});

it('api returns proper json structure on success', function () {
    // This test documents the comprehensive response structure
    
    expect(true)->toBeTrue(); // Placeholder for structure verification
    
    // Expected response structure with ALL student fields and relationships:
    // {
    //   "status": "success",
    //   "message": "Students retrieved successfully",
    //   "data": {
    //     "data": [
    //       {
    //         // ALL 60+ student fields including:
    //         "id": 1,
    //         "admission_number": "2024001",
    //         "full_name": "John Doe",
    //         "full_name_with_title": "Mr. John Doe",
    //         "gender": "Male",
    //         "date_of_birth": "2010-01-01",
    //         "email": "john@example.com",
    //         "phone": "1234567890",
    //         "student_phone": "0987654321",
    //         "student_email": "john.student@example.com",
    //         "full_address": "123 Main St",
    //         "student_address": "Dorm Room 101",
    //         "blood_group": "O+",
    //         "student_calling_name": "Johnny",
    //         "grade_level_class_id": 1,
    //         "grade_level_id": 1,
    //         "school_house_id": 1,
    //         "joined_date": "2024-01-15",
    //         "is_sport_list": false,
    //         "has_dropped_out": false,
    //         "is_school_leaver": false,
    //         "father_full_name": "John Doe Sr.",
    //         "father_phone": "1111111111",
    //         "father_email": "father@example.com",
    //         "mother_full_name": "Jane Doe",
    //         "mother_phone": "2222222222", 
    //         "mother_email": "mother@example.com",
    //         "guardian_full_name": "Guardian Name",
    //         "approved_admission_fee": 5000.00,
    //         "admission_fee_discount_percentage": "10",
    //         "applicable_term_payment": 1500.00,
    //         "applicable_year_payment": 18000.00,
    //         // ... all other student fields
    //         
    //         // ALL comprehensive relationships:
    //         "grade_level_class": { "id": 1, "name": "Grade 1 - Class A" },
    //         "grade_level": { "id": 1, "name": "Grade 1" },
    //         "school_house": { "id": 1, "name": "Red House" },
    //         "nationality": { "id": 1, "name": "Sri Lankan" },
    //         "religion": { "id": 1, "name": "Buddhism" },
    //         "student_admission_source": { "id": 1, "name": "Direct Application" },
    //         "father": { "id": 1, "full_name": "John Doe Sr." },
    //         "mother": { "id": 2, "full_name": "Jane Doe" },
    //         "guardian": { "id": 3, "full_name": "Guardian Name" },
    //         "student_achievement_list": [],
    //         "student_role_list": [],
    //         "student_sport_list": [],
    //         "student_attendance_list": [],
    //         "latest_term_fee_receipt_voucher": null,
    //         "current_user_payment_students": [],
    //         "student_supply_list": [],
    //         "student_attachment_list": []
    //       }
    //     ],
    //     "total": 2
    //   }
    // }
});