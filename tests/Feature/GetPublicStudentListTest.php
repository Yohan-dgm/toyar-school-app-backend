<?php

namespace Tests\Feature;

use Tests\TestCase;
use Modules\UserManagement\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class GetPublicStudentListTest extends TestCase
{
    /**
     * Test the public student list endpoint existence and accessibility.
     */
    public function test_public_student_list_endpoint_exists()
    {
        // Try to access the endpoint
        $response = $this->postJson('/api/user-management/user/public-student-list', []);

        // It should NOT be a 404 (Not Found) or 405 (Method Not Allowed)
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(405, $response->getStatusCode());
        
        // It should return 422 because user_id is required
        $this->assertEquals(422, $response->getStatusCode());
    }

    /**
     * Test that validation works for user_id.
     */
    public function test_public_student_list_validation()
    {
        $response = $this->postJson('/api/user-management/user/public-student-list', [
            'user_id' => 'not-an-id'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['user_id']);
    }

    /**
     * Test that the endpoint is public (no AuthGuard).
     */
    public function test_public_student_list_is_public()
    {
        // Even without authentication, it should reach the validation layer, not the auth layer.
        $response = $this->postJson('/api/user-management/user/public-student-list', [
            'user_id' => 999999999 // Non-existent user
        ]);

        // If it was private, it would return 401. 
        // If public, it returns 422 because 'exists:user,id' validation fails.
        $this->assertEquals(422, $response->getStatusCode());
    }
}
