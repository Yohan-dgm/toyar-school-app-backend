# Sport Attendance Management Module

This module provides comprehensive functionality for managing sport attendance records in the SMS (School Management System) backend.

## Features

-   **Create Sport Attendance**: Add individual sport attendance records
-   **Update Sport Attendance**: Modify existing sport attendance records
-   **Bulk Create Sport Attendance**: Create multiple sport attendance records at once
-   **List Sport Attendance**: Retrieve sport attendance records with filtering and pagination
-   **Aggregated Reports**: Get aggregated sport attendance data for reporting purposes

## Database Schema

The `sport_attendance` table includes the following fields:

-   `id` - Primary key
-   `created_by` - User who created the record (foreign key to users table)
-   `updated_by` - User who last updated the record (foreign key to users table)
-   `student_id` - Student ID (foreign key to students table)
-   `date` - Attendance date
-   `time` - Attendance time
-   `attendance_type_id` - Type of attendance (foreign key to attendance_types table)
-   `notes` - Additional notes (optional)
-   `sport_activity` - Name of the sport activity
-   `team_id` - Team ID (optional)
-   `coach_id` - Coach ID (foreign key to users table, optional)
-   `created_at` - Record creation timestamp
-   `updated_at` - Record last update timestamp

## API Endpoints

### Create Sport Attendance

-   **URL**: `POST /sport-attendance/create-sport-attendance`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "student_id": 1,
        "date": "2024-01-15",
        "time": "14:30:00",
        "attendance_type_id": 1,
        "notes": "Optional notes",
        "sport_activity": "Football",
        "team_id": 1,
        "coach_id": 5
    }
    ```

### Update Sport Attendance

-   **URL**: `POST /sport-attendance/update-sport-attendance`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "id": 1,
        "student_id": 1,
        "date": "2024-01-15",
        "time": "14:30:00",
        "attendance_type_id": 1,
        "notes": "Updated notes",
        "sport_activity": "Football",
        "team_id": 1,
        "coach_id": 5
    }
    ```

### Get Sport Attendance List

-   **URL**: `POST /sport-attendance/get-sport-attendance-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "student_id": 1,
        "date": "2024-01-15",
        "sport_activity": "Football",
        "attendance_type_id": 1,
        "coach_id": 5,
        "date_from": "2024-01-01",
        "date_to": "2024-01-31",
        "per_page": 15
    }
    ```

### Get Aggregated Sport Attendance Data

-   **URL**: `POST /sport-attendance/get-sport-attendance-aggregated-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "student_id": 1,
        "sport_activity": "Football",
        "coach_id": 5,
        "date_from": "2024-01-01",
        "date_to": "2024-01-31",
        "per_page": 15
    }
    ```

### Bulk Create Sport Attendance

-   **URL**: `POST /sport-attendance/bulk-create-sport-attendance`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "sport_attendances": [
            {
                "student_id": 1,
                "date": "2024-01-15",
                "time": "14:30:00",
                "attendance_type_id": 1,
                "notes": "Notes for student 1",
                "sport_activity": "Football",
                "team_id": 1,
                "coach_id": 5
            },
            {
                "student_id": 2,
                "date": "2024-01-15",
                "time": "14:30:00",
                "attendance_type_id": 1,
                "notes": "Notes for student 2",
                "sport_activity": "Football",
                "team_id": 1,
                "coach_id": 5
            }
        ]
    }
    ```

## Model Relationships

The `SportAttendance` model has the following relationships:

-   `student()` - Belongs to Student
-   `attendance_type()` - Belongs to AttendanceType
-   `user()` - Belongs to User (created_by)
-   `coach()` - Belongs to User (coach_id)

## Validation Rules

### Required Fields

-   `student_id` - Must exist in students table
-   `date` - Must be a valid date
-   `time` - Must be in HH:MM:SS format
-   `attendance_type_id` - Must exist in attendance_types table
-   `sport_activity` - String, max 255 characters

### Optional Fields

-   `notes` - String, max 1000 characters
-   `team_id` - Integer
-   `coach_id` - Must exist in users table if provided

## Installation

1. Ensure the module is properly registered in your Laravel application
2. Run the migration: `php artisan migrate`
3. The module will be available at the defined API endpoints

## Usage Examples

### Creating a Sport Attendance Record

```php
use Modules\SportAttendanceManagement\Models\SportAttendance;

$sportAttendance = SportAttendance::create([
    'created_by' => auth()->id(),
    'student_id' => 1,
    'date' => '2024-01-15',
    'time' => '14:30:00',
    'attendance_type_id' => 1,
    'sport_activity' => 'Football',
    'notes' => 'Regular training session',
    'coach_id' => 5
]);
```

### Querying Sport Attendance Records

```php
use Modules\SportAttendanceManagement\Models\SportAttendance;

// Get all football attendance records for a specific student
$footballAttendance = SportAttendance::where('student_id', 1)
    ->where('sport_activity', 'Football')
    ->with(['student', 'attendance_type', 'coach'])
    ->get();

// Get attendance records for a specific date range
$dateRangeAttendance = SportAttendance::whereBetween('date', ['2024-01-01', '2024-01-31'])
    ->with(['student', 'attendance_type'])
    ->get();
```
