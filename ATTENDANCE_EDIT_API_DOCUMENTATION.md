# Attendance Edit API Documentation

## Overview
This document describes the updated attendance edit functionality that allows frontend applications to update student attendance records using a **delete and recreate** approach. The system now accepts date and student_id parameters instead of attendance_id, and handles different attendance statuses (present, absent, late) appropriately.

## API Endpoint
```
POST /api/attendance-management/student-attendance/update-student-attendance
```

## Key Changes from Previous Version

### Previous Approach
- Required `attendance_id` parameter to update specific record
- Only modified existing attendance records
- Limited flexibility for complex attendance scenarios

### New Approach
- Uses `date` and `student_id` parameters to identify records
- **Deletes ALL existing attendance records** for the given date and student
- **Recreates new attendance records** based on attendance status
- Handles attendance reasons properly
- Supports multiple record creation for in/out times

## Request Structure

### Headers
```http
Content-Type: application/json
Authorization: Bearer {your-auth-token}
```

### Request Body Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `student_id` | integer | ✅ Yes | ID of the student |
| `grade_level_class_id` | integer | ✅ Yes | ID of the student's class |
| `date` | string | ✅ Yes | Date in YYYY-MM-DD format |
| `attendance_status` | string | ✅ Yes | One of: `present`, `absent`, `late` |
| `in_time` | string | ❌ Optional | Time in HH:MM:SS format (required for present/late) |
| `out_time` | string | ❌ Optional | Time in HH:MM:SS format (optional for present/late) |
| `notes` | string | ❌ Optional | Additional notes (max 1000 characters) |
| `reason` | string | ❌ Optional | Reason for attendance status (max 500 characters) |

### Request Examples

#### 1. Present Attendance
```json
{
    "student_id": 1,
    "grade_level_class_id": 1,
    "date": "2024-12-15",
    "attendance_status": "present",
    "in_time": "08:30:00",
    "out_time": "15:30:00",
    "notes": "Regular attendance",
    "reason": null
}
```

#### 2. Absent Attendance
```json
{
    "student_id": 1,
    "grade_level_class_id": 1,
    "date": "2024-12-16",
    "attendance_status": "absent",
    "in_time": null,
    "out_time": null,
    "notes": "Student was sick",
    "reason": "Fever and flu symptoms"
}
```

#### 3. Late Attendance
```json
{
    "student_id": 1,
    "grade_level_class_id": 1,
    "date": "2024-12-17",
    "attendance_status": "late",
    "in_time": "09:15:00",
    "out_time": "15:30:00",
    "notes": "Late due to traffic",
    "reason": "Heavy traffic on main road"
}
```

## Response Structure

### Success Response (200 OK)
```json
{
    "attendance_records": [
        {
            "id": 123,
            "student_id": 1,
            "grade_level_class_id": 1,
            "date": "2024-12-15",
            "time": "08:30:00",
            "attendance_type_id": 1,
            "notes": "Regular attendance",
            "created_by": 1,
            "updated_by": 1,
            "created_at": "2024-12-15T08:00:00.000000Z",
            "updated_at": "2024-12-15T08:00:00.000000Z",
            "attendance_type": {
                "id": 1,
                "name": "In"
            },
            "attendance_reason": {
                "id": 45,
                "attendance_id": 123,
                "reason": "Doctor appointment in the morning"
            }
        },
        {
            "id": 124,
            "student_id": 1,
            "grade_level_class_id": 1,
            "date": "2024-12-15",
            "time": "15:30:00",
            "attendance_type_id": 2,
            "notes": "Regular attendance",
            "created_by": 1,
            "updated_by": 1,
            "created_at": "2024-12-15T08:00:00.000000Z",
            "updated_at": "2024-12-15T08:00:00.000000Z",
            "attendance_type": {
                "id": 2,
                "name": "Out"
            },
            "attendance_reason": null
        }
    ],
    "total_records": 2,
    "status": "present",
    "message": "Attendance updated successfully"
}
```

### Error Response (422 Unprocessable Entity)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "student_id": ["The student id field is required."],
        "date": ["The date field is required."],
        "attendance_status": ["The attendance status field must be one of: present, absent, late."]
    }
}
```

## Attendance Type Mappings

| Attendance Status | Records Created | Type IDs | Description |
|-------------------|-----------------|----------|-------------|
| `present` | 2 records | 1 (In), 2 (Out) | Creates in-time and out-time records |
| `absent` | 1 record | 4 (Absent) | Creates single absent record with no time |
| `late` | 2 records | 1 (In), 2 (Out) | Creates late in-time and regular out-time records |

## Database Changes

### Records Creation Logic

1. **Delete Phase**: All existing attendance records for the specified date and student_id are deleted
2. **Reason Cleanup**: All associated attendance reasons are also deleted
3. **Recreation Phase**: New records are created based on attendance_status:

#### Present Status
- Creates 2 records: one for in_time (type=1) and one for out_time (type=2)
- Both records share the same base data but have different times and types

#### Absent Status  
- Creates 1 record: absent type (type=4) with no time value
- If reason is provided, creates attendance_reason record

#### Late Status
- Creates 2 records: late in_time (type=1) and regular out_time (type=2)
- The in_time record will have the late arrival time
- If reason is provided, creates attendance_reason record linked to the in_time record

### Attendance Reasons
- Reasons are stored in the `attendance_reasons` table
- Linked to attendance records via `attendance_id`
- For multiple records (present/late), reason is attached to the first/primary record
- Reasons are optional and can be null

## Validation Rules

### Required Fields
- `student_id`: Must be a valid integer
- `grade_level_class_id`: Must be a valid integer  
- `date`: Must be in YYYY-MM-DD format
- `attendance_status`: Must be one of: present, absent, late

### Conditional Requirements
- `in_time`: Required for `present` and `late` status
- `out_time`: Optional for `present` and `late` status
- Time format: HH:MM:SS (24-hour format)

### String Limits
- `notes`: Maximum 1000 characters
- `reason`: Maximum 500 characters

## Important Notes for Frontend Developers

### 🔴 Critical Warning: Data Deletion
**This API performs DESTRUCTIVE operations!** All existing attendance records for the specified date and student will be permanently deleted before creating new ones. Ensure users understand this behavior.

### 🔄 Transaction Safety
All database operations are wrapped in a transaction, ensuring data consistency. If any step fails, all changes are rolled back.

### 📝 Reason Handling  
- Reasons are optional for all attendance types
- Only one reason record is created per update operation
- For multiple attendance records (present/late), the reason is linked to the primary record

### 🕒 Time Format Requirements
- All times must be in 24-hour format: HH:MM:SS
- Examples: "08:30:00", "15:45:30", "09:00:00"
- Invalid formats will result in validation errors

### 📊 Response Data
- The response includes all created attendance records with full relationship data
- Each record includes attendance_type and attendance_reason relationships loaded
- Use `total_records` to verify expected number of records were created

## Testing Scenarios

### Frontend Testing Checklist

1. **Present Attendance**
   - ✅ Verify 2 records created (in + out)
   - ✅ Check both records have correct times
   - ✅ Validate attendance_type_id values (1, 2)

2. **Absent Attendance** 
   - ✅ Verify 1 record created
   - ✅ Check time field is null
   - ✅ Validate attendance_type_id is 4
   - ✅ Confirm reason is properly linked

3. **Late Attendance**
   - ✅ Verify 2 records created (late in + regular out)
   - ✅ Check in_time reflects late arrival
   - ✅ Validate reason is linked to in_time record

4. **Update Existing**
   - ✅ Confirm old records are deleted
   - ✅ Verify new records match new status
   - ✅ Check no orphaned data remains

5. **Error Handling**
   - ✅ Test invalid date formats
   - ✅ Test invalid attendance_status values
   - ✅ Test missing required fields
   - ✅ Test oversized string fields

## Troubleshooting

### Common Issues

1. **"Target class [config] does not exist"**
   - Ensure Laravel application is properly bootstrapped
   - Check all dependencies are installed

2. **"Attendance record not found"**
   - This error should not occur with the new implementation
   - Previous version's error message - may indicate old code is still running

3. **Validation Errors**
   - Check all required fields are provided
   - Verify date format is YYYY-MM-DD
   - Ensure attendance_status is exactly: "present", "absent", or "late" (lowercase)

4. **Time Format Errors**
   - Use 24-hour format: HH:MM:SS
   - Include leading zeros: "08:30:00" not "8:30:00"
   - Include seconds: "15:30:00" not "15:30"

### Database Verification

To verify attendance records were created correctly:
```sql
-- Check attendance records
SELECT sa.id, sa.student_id, sa.date, sa.time, at.name as type, sa.notes
FROM student_attendance sa
JOIN attendance_type at ON sa.attendance_type_id = at.id
WHERE sa.student_id = {student_id} AND sa.date = '{date}'
ORDER BY sa.attendance_type_id;

-- Check attendance reasons
SELECT ar.*, sa.date, sa.time
FROM attendance_reasons ar
JOIN student_attendance sa ON ar.attendance_id = sa.id
WHERE sa.student_id = {student_id} AND sa.date = '{date}';
```

This documentation should provide your frontend team with all the information needed to successfully integrate with the updated attendance edit functionality.