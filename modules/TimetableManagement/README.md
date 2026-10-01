# Timetable Management Module

This module provides comprehensive functionality for managing both academic and sport timetables in the SMS (School Management System) backend.

## Features

### Academic Timetable Management

-   **Create Academic Timetable**: Add individual academic timetable records
-   **Update Academic Timetable**: Modify existing academic timetable records
-   **Bulk Create Academic Timetable**: Create multiple academic timetable records at once
-   **List Academic Timetable**: Retrieve academic timetable records with filtering and pagination
-   **Aggregated Reports**: Get aggregated academic timetable data for reporting purposes

### Sport Timetable Management

-   **Create Sport Timetable**: Add individual sport timetable records
-   **Update Sport Timetable**: Modify existing sport timetable records
-   **Bulk Create Sport Timetable**: Create multiple sport timetable records at once
-   **List Sport Timetable**: Retrieve sport timetable records with filtering and pagination
-   **Aggregated Reports**: Get aggregated sport timetable data for reporting purposes

## Database Schema

### Academic Timetable Table (`academic_timetable`)

-   `id` - Primary key
-   `created_by` - User who created the record (foreign key to users table)
-   `updated_by` - User who last updated the record (foreign key to users table)
-   `grade_level_class_id` - Grade level class ID (foreign key to grade_level_class table)
-   `subject_id` - Subject ID (foreign key to subject table)
-   `educator_id` - Educator ID (foreign key to educators table)
-   `day_of_week` - Day of the week (enum: monday, tuesday, wednesday, thursday, friday, saturday, sunday)
-   `start_time` - Start time of the class
-   `end_time` - End time of the class
-   `room_number` - Room number (optional)
-   `building` - Building name (optional)
-   `semester` - Semester name
-   `academic_year` - Academic year
-   `is_active` - Whether the timetable entry is active
-   `notes` - Additional notes (optional)
-   `created_at` - Record creation timestamp
-   `updated_at` - Record last update timestamp

### Sport Timetable Table (`sport_timetable`)

-   `id` - Primary key
-   `created_by` - User who created the record (foreign key to users table)
-   `updated_by` - User who last updated the record (foreign key to users table)
-   `sport_id` - Sport ID (foreign key to sport table)
-   `grade_level_class_id` - Grade level class ID (foreign key to grade_level_class table, optional)
-   `coach_id` - Coach ID (foreign key to educators table)
-   `day_of_week` - Day of the week (enum: monday, tuesday, wednesday, thursday, friday, saturday, sunday)
-   `start_time` - Start time of the sport session
-   `end_time` - End time of the sport session
-   `venue` - Venue name (optional)
-   `facility` - Facility name (optional)
-   `season` - Season (enum: spring, summer, autumn, winter, all_year)
-   `academic_year` - Academic year
-   `is_active` - Whether the timetable entry is active
-   `notes` - Additional notes (optional)
-   `team_id` - Team ID (optional)
-   `max_participants` - Maximum number of participants (optional)
-   `age_group` - Age group (optional)
-   `skill_level` - Skill level (enum: beginner, intermediate, advanced, expert, optional)
-   `created_at` - Record creation timestamp
-   `updated_at` - Record last update timestamp

## API Endpoints

### Academic Timetable Endpoints

#### Create Academic Timetable

-   **URL**: `POST /academic-timetable/create-academic-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "grade_level_class_id": 1,
        "subject_id": 1,
        "educator_id": 1,
        "day_of_week": "monday",
        "start_time": "08:00:00",
        "end_time": "09:00:00",
        "room_number": "101",
        "building": "Main Building",
        "semester": "Fall 2024",
        "academic_year": "2024-2025",
        "is_active": true,
        "notes": "Optional notes"
    }
    ```

#### Update Academic Timetable

-   **URL**: `POST /academic-timetable/update-academic-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "id": 1,
        "grade_level_class_id": 1,
        "subject_id": 1,
        "educator_id": 1,
        "day_of_week": "monday",
        "start_time": "08:00:00",
        "end_time": "09:00:00",
        "room_number": "102",
        "building": "Main Building",
        "semester": "Fall 2024",
        "academic_year": "2024-2025",
        "is_active": true,
        "notes": "Updated notes"
    }
    ```

#### Get Academic Timetable List

-   **URL**: `POST /academic-timetable/get-academic-timetable-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "grade_level_class_id": 1,
        "subject_id": 1,
        "educator_id": 1,
        "day_of_week": "monday",
        "semester": "Fall 2024",
        "academic_year": "2024-2025",
        "is_active": true,
        "building": "Main Building",
        "room_number": "101",
        "per_page": 15
    }
    ```

#### Get Aggregated Academic Timetable Data

-   **URL**: `POST /academic-timetable/get-academic-timetable-aggregated-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "grade_level_class_id": 1,
        "educator_id": 1,
        "semester": "Fall 2024",
        "academic_year": "2024-2025",
        "per_page": 15
    }
    ```

#### Bulk Create Academic Timetable

-   **URL**: `POST /academic-timetable/bulk-create-academic-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "academic_timetables": [
            {
                "grade_level_class_id": 1,
                "subject_id": 1,
                "educator_id": 1,
                "day_of_week": "monday",
                "start_time": "08:00:00",
                "end_time": "09:00:00",
                "room_number": "101",
                "building": "Main Building",
                "semester": "Fall 2024",
                "academic_year": "2024-2025",
                "notes": "Notes for class 1"
            },
            {
                "grade_level_class_id": 1,
                "subject_id": 2,
                "educator_id": 2,
                "day_of_week": "monday",
                "start_time": "09:00:00",
                "end_time": "10:00:00",
                "room_number": "102",
                "building": "Main Building",
                "semester": "Fall 2024",
                "academic_year": "2024-2025",
                "notes": "Notes for class 2"
            }
        ]
    }
    ```

### Sport Timetable Endpoints

#### Create Sport Timetable

-   **URL**: `POST /sport-timetable/create-sport-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "sport_id": 1,
        "grade_level_class_id": 1,
        "coach_id": 1,
        "day_of_week": "monday",
        "start_time": "14:00:00",
        "end_time": "15:30:00",
        "venue": "Sports Complex",
        "facility": "Football Field",
        "season": "all_year",
        "academic_year": "2024-2025",
        "is_active": true,
        "notes": "Optional notes",
        "team_id": 1,
        "max_participants": 20,
        "age_group": "14-16 years",
        "skill_level": "intermediate"
    }
    ```

#### Update Sport Timetable

-   **URL**: `POST /sport-timetable/update-sport-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "id": 1,
        "sport_id": 1,
        "grade_level_class_id": 1,
        "coach_id": 1,
        "day_of_week": "monday",
        "start_time": "14:00:00",
        "end_time": "15:30:00",
        "venue": "Sports Complex",
        "facility": "Football Field",
        "season": "all_year",
        "academic_year": "2024-2025",
        "is_active": true,
        "notes": "Updated notes",
        "team_id": 1,
        "max_participants": 25,
        "age_group": "14-16 years",
        "skill_level": "advanced"
    }
    ```

#### Get Sport Timetable List

-   **URL**: `POST /sport-timetable/get-sport-timetable-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "sport_id": 1,
        "grade_level_class_id": 1,
        "coach_id": 1,
        "day_of_week": "monday",
        "season": "all_year",
        "academic_year": "2024-2025",
        "is_active": true,
        "venue": "Sports Complex",
        "facility": "Football Field",
        "skill_level": "intermediate",
        "age_group": "14-16 years",
        "team_id": 1,
        "per_page": 15
    }
    ```

#### Get Aggregated Sport Timetable Data

-   **URL**: `POST /sport-timetable/get-sport-timetable-aggregated-list-data`
-   **Authentication**: Required
-   **Body** (optional filters):
    ```json
    {
        "sport_id": 1,
        "coach_id": 1,
        "season": "all_year",
        "academic_year": "2024-2025",
        "per_page": 15
    }
    ```

#### Bulk Create Sport Timetable

-   **URL**: `POST /sport-timetable/bulk-create-sport-timetable`
-   **Authentication**: Required
-   **Body**:
    ```json
    {
        "sport_timetables": [
            {
                "sport_id": 1,
                "grade_level_class_id": 1,
                "coach_id": 1,
                "day_of_week": "monday",
                "start_time": "14:00:00",
                "end_time": "15:30:00",
                "venue": "Sports Complex",
                "facility": "Football Field",
                "season": "all_year",
                "academic_year": "2024-2025",
                "notes": "Notes for session 1",
                "team_id": 1,
                "max_participants": 20,
                "age_group": "14-16 years",
                "skill_level": "intermediate"
            },
            {
                "sport_id": 2,
                "grade_level_class_id": 2,
                "coach_id": 2,
                "day_of_week": "tuesday",
                "start_time": "15:00:00",
                "end_time": "16:30:00",
                "venue": "Sports Complex",
                "facility": "Basketball Court",
                "season": "all_year",
                "academic_year": "2024-2025",
                "notes": "Notes for session 2",
                "team_id": 2,
                "max_participants": 15,
                "age_group": "16-18 years",
                "skill_level": "advanced"
            }
        ]
    }
    ```

## Model Relationships

### AcademicTimetable Model

-   `grade_level_class()` - Belongs to GradeLevelClass
-   `subject()` - Belongs to Subject
-   `educator()` - Belongs to Educator
-   `user()` - Belongs to User (created_by)

### SportTimetable Model

-   `sport()` - Belongs to Sport
-   `grade_level_class()` - Belongs to GradeLevelClass
-   `coach()` - Belongs to Educator
-   `user()` - Belongs to User (created_by)

## Validation Rules

### Academic Timetable Required Fields

-   `grade_level_class_id` - Must exist in grade_level_class table
-   `subject_id` - Must exist in subject table
-   `educator_id` - Must exist in educators table
-   `day_of_week` - Must be a valid day of week
-   `start_time` - Must be in HH:MM:SS format
-   `end_time` - Must be in HH:MM:SS format and after start_time
-   `semester` - String, max 50 characters
-   `academic_year` - String, max 20 characters

### Academic Timetable Optional Fields

-   `room_number` - String, max 50 characters
-   `building` - String, max 100 characters
-   `is_active` - Boolean
-   `notes` - String, max 1000 characters

### Sport Timetable Required Fields

-   `sport_id` - Must exist in sport table
-   `coach_id` - Must exist in educators table
-   `day_of_week` - Must be a valid day of week
-   `start_time` - Must be in HH:MM:SS format
-   `end_time` - Must be in HH:MM:SS format and after start_time
-   `season` - Must be a valid season
-   `academic_year` - String, max 20 characters

### Sport Timetable Optional Fields

-   `grade_level_class_id` - Must exist in grade_level_class table if provided
-   `venue` - String, max 100 characters
-   `facility` - String, max 100 characters
-   `is_active` - Boolean
-   `notes` - String, max 1000 characters
-   `team_id` - Integer
-   `max_participants` - Integer, minimum 1
-   `age_group` - String, max 50 characters
-   `skill_level` - Must be a valid skill level

## Installation

1. Ensure the module is properly registered in your Laravel application
2. Run the migrations: `php artisan migrate`
3. The module will be available at the defined API endpoints

## Usage Examples

### Creating an Academic Timetable Record

```php
use Modules\TimetableManagement\Models\AcademicTimetable;

$academicTimetable = AcademicTimetable::create([
    'created_by' => auth()->id(),
    'grade_level_class_id' => 1,
    'subject_id' => 1,
    'educator_id' => 1,
    'day_of_week' => 'monday',
    'start_time' => '08:00:00',
    'end_time' => '09:00:00',
    'room_number' => '101',
    'building' => 'Main Building',
    'semester' => 'Fall 2024',
    'academic_year' => '2024-2025',
    'notes' => 'Regular class session'
]);
```

### Creating a Sport Timetable Record

```php
use Modules\TimetableManagement\Models\SportTimetable;

$sportTimetable = SportTimetable::create([
    'created_by' => auth()->id(),
    'sport_id' => 1,
    'grade_level_class_id' => 1,
    'coach_id' => 1,
    'day_of_week' => 'monday',
    'start_time' => '14:00:00',
    'end_time' => '15:30:00',
    'venue' => 'Sports Complex',
    'facility' => 'Football Field',
    'season' => 'all_year',
    'academic_year' => '2024-2025',
    'notes' => 'Regular training session',
    'max_participants' => 20,
    'age_group' => '14-16 years',
    'skill_level' => 'intermediate'
]);
```

### Querying Academic Timetable Records

```php
use Modules\TimetableManagement\Models\AcademicTimetable;

// Get all Monday classes for a specific grade level
$mondayClasses = AcademicTimetable::where('grade_level_class_id', 1)
    ->where('day_of_week', 'monday')
    ->with(['subject', 'educator', 'grade_level_class'])
    ->orderBy('start_time')
    ->get();

// Get all classes for a specific educator
$educatorClasses = AcademicTimetable::where('educator_id', 1)
    ->with(['subject', 'grade_level_class'])
    ->get();
```

### Querying Sport Timetable Records

```php
use Modules\TimetableManagement\Models\SportTimetable;

// Get all football sessions for a specific coach
$footballSessions = SportTimetable::where('sport_id', 1)
    ->where('coach_id', 1)
    ->with(['sport', 'coach', 'grade_level_class'])
    ->get();

// Get all intermediate level sessions
$intermediateSessions = SportTimetable::where('skill_level', 'intermediate')
    ->with(['sport', 'coach'])
    ->get();
```

## Helper Methods

### AcademicTimetable Model

-   `getDaysOfWeek()` - Returns array of valid days of week
-   `getDayOfWeekNameAttribute()` - Returns formatted day name

### SportTimetable Model

-   `getDaysOfWeek()` - Returns array of valid days of week
-   `getDayOfWeekNameAttribute()` - Returns formatted day name
-   `getSeasons()` - Returns array of valid seasons
-   `getSeasonNameAttribute()` - Returns formatted season name
-   `getSkillLevels()` - Returns array of valid skill levels
-   `getSkillLevelNameAttribute()` - Returns formatted skill level name
