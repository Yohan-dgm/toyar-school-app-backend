# Educator Feedback Management System - Testing Guide

## Overview
This document provides comprehensive testing instructions for the Educator Feedback Management System using Postman. The system follows Laravel backend architecture patterns with Intent-Action-DTO structure.

## Authentication Setup

### Base URL
```
http://localhost:8000/api/educator-feedback-management
```

### Headers Required
```json
{
  "Content-Type": "application/json",
  "Accept": "application/json",
  "Authorization": "Bearer YOUR_TOKEN_HERE"
}
```

### Authentication Process
1. First authenticate via the user management system
2. Use the returned token in the Authorization header for all requests
3. The system uses `AuthGuard` middleware for protection

---

## API Endpoints Testing

### 1. Get Metadata (Setup Required First)

**Endpoint:** `POST /metadata`  
**Purpose:** Get all required dropdown data for forms

**Request Body:**
```json
{}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "categories": [
      {
        "id": 1,
        "name": "Academic Performance"
      }
    ],
    "evaluation_types": [
      {
        "id": 1,
        "name": "Under Observation",
        "status_code": 1,
        "description": "Student is under observation for feedback evaluation"
      }
    ],
    "grade_levels": [],
    "students": [],
    "categories_with_questions": []
  },
  "message": "Educator feedback metadata retrieved successfully"
}
```

### 2. Get Category List

**Endpoint:** `POST /category/list`  
**Purpose:** Retrieve all active feedback categories with predefined questions

**Request Body:**
```json
{}
```

**Expected Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Academic Performance",
      "is_active": true,
      "created_by": 1,
      "created_at": "2025-01-30T10:00:00.000000Z",
      "predefined_questions": [
        {
          "id": 1,
          "question": "How is the student's class participation?",
          "edu_fb_category_id": 1,
          "edu_fb_answer_type_id": 1,
          "predefined_answers": [
            {
              "id": 1,
              "predefined_answer": "Excellent",
              "edu_fb_predefined_question_id": 1,
              "predefined_answer_weight": 5,
              "marks": 10
            }
          ]
        }
      ]
    }
  ],
  "message": "Category list retrieved successfully"
}
```

### 3. Create Category (Enhanced with Questions & Answers)

**Endpoint:** `POST /category/create`  
**Purpose:** Create a new feedback category with predefined questions and answers

**Request Body (Basic Category Only):**
```json
{
  "name": "Behavioral Assessment",
  "is_active": true
}
```

**Request Body (Category with Questions & Answers):**
```json
{
  "name": "Academic Performance",
  "is_active": true,
  "predefined_questions": [
    {
      "question": "How is the student's class participation?",
      "edu_fb_answer_type_id": 1,
      "is_active": true,
      "predefined_answers": [
        {
          "predefined_answer": "Excellent",
          "predefined_answer_weight": 5,
          "marks": 10,
          "is_active": true
        },
        {
          "predefined_answer": "Good",
          "predefined_answer_weight": 4,
          "marks": 8,
          "is_active": true
        },
        {
          "predefined_answer": "Average",
          "predefined_answer_weight": 3,
          "marks": 6,
          "is_active": true
        },
        {
          "predefined_answer": "Below Average",
          "predefined_answer_weight": 2,
          "marks": 4,
          "is_active": true
        },
        {
          "predefined_answer": "Poor",
          "predefined_answer_weight": 1,
          "marks": 2,
          "is_active": true
        }
      ]
    },
    {
      "question": "How is the student's homework completion?",
      "edu_fb_answer_type_id": 1,
      "is_active": true,
      "predefined_answers": [
        {
          "predefined_answer": "Always completed on time",
          "predefined_answer_weight": 5,
          "marks": 10,
          "is_active": true
        },
        {
          "predefined_answer": "Usually completed",
          "predefined_answer_weight": 4,
          "marks": 8,
          "is_active": true
        },
        {
          "predefined_answer": "Sometimes completed",
          "predefined_answer_weight": 3,
          "marks": 6,
          "is_active": true
        },
        {
          "predefined_answer": "Rarely completed",
          "predefined_answer_weight": 2,
          "marks": 4,
          "is_active": true
        },
        {
          "predefined_answer": "Never completed",
          "predefined_answer_weight": 1,
          "marks": 2,
          "is_active": true
        }
      ]
    }
  ]
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Academic Performance",
    "is_active": true,
    "created_by": 1,
    "updated_by": null,
    "created_at": "2025-01-30T10:00:00.000000Z",
    "updated_at": "2025-01-30T10:00:00.000000Z",
    "created_by": {
      "id": 1,
      "call_name_with_title": "Mr. Admin"
    },
    "predefined_questions": [
      {
        "id": 1,
        "question": "How is the student's class participation?",
        "edu_fb_category_id": 2,
        "edu_fb_answer_type_id": 1,
        "is_active": 1,
        "predefined_answers": [
          {
            "id": 1,
            "predefined_answer": "Excellent",
            "edu_fb_predefined_question_id": 1,
            "predefined_answer_weight": 5,
            "marks": 10,
            "is_active": 1
          },
          {
            "id": 2,
            "predefined_answer": "Good",
            "edu_fb_predefined_question_id": 1,
            "predefined_answer_weight": 4,
            "marks": 8,
            "is_active": 1
          }
        ]
      },
      {
        "id": 2,
        "question": "How is the student's homework completion?",
        "edu_fb_category_id": 2,
        "edu_fb_answer_type_id": 1,
        "is_active": 1,
        "predefined_answers": [
          {
            "id": 6,
            "predefined_answer": "Always completed on time",
            "edu_fb_predefined_question_id": 2,
            "predefined_answer_weight": 5,
            "marks": 10,
            "is_active": 1
          }
        ]
      }
    ]
  },
  "message": "Category created successfully"
}
```

### 4. Update Category

**Endpoint:** `POST /category/update`  
**Purpose:** Update an existing feedback category

**Request Body:**
```json
{
  "id": 2,
  "name": "Behavioral Assessment - Updated",
  "is_active": false
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Behavioral Assessment - Updated",
    "is_active": false,
    "created_by": 1,
    "updated_by": 1,
    "created_at": "2025-01-30T10:00:00.000000Z",
    "updated_at": "2025-01-30T10:15:00.000000Z",
    "created_by": {
      "id": 1,
      "call_name_with_title": "Mr. Admin"
    },
    "updated_by": {
      "id": 1,
      "call_name_with_title": "Mr. Admin"
    }
  },
  "message": "Category updated successfully"
}
```

### 5. Delete Category

**Endpoint:** `POST /category/delete`  
**Purpose:** Delete a feedback category (only if no associated feedback exists)

**Request Body:**
```json
{
  "id": 2
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "deleted_category": {
      "id": 2,
      "name": "Behavioral Assessment - Updated",
      "questions_deleted": 3,
      "subcategories_deleted": 1
    }
  },
  "message": "Category deleted successfully"
}
```

**Error Response (if category has feedback):**
```json
{
  "success": false,
  "message": "Cannot delete category 'Academic Performance' because it has 5 associated feedback records. Please remove all feedback records first or set the category as inactive."
}
```

### 6. Create Educator Feedback (Auto-Creates Evaluation)

**Endpoint:** `POST /feedback/create`  
**Purpose:** Create new educator feedback for a student

**⚠️ IMPORTANT:** When creating educator feedback, the system automatically creates an evaluation record with `edu_fd_evaluation_type_id = 1` (Under Observation). This evaluation tracks the feedback workflow status.

**Request Body:**
```json
{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.5,
  "created_by_designation": "Head Teacher",
  "comments": "Student shows good improvement in mathematics",
  "question_answers": [
    {
      "edu_fb_predefined_question_id": 1,
      "edu_fb_predefined_answer_id": 1,
      "selected_predefined_answer_id": 1,
      "answer_mark": 8
    }
  ],
  "subcategories": [
    {
      "subcategory_name": "Mathematics Performance"
    }
  ]
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "student_id": 1,
    "grade_level_id": 1,
    "grade_level_class_id": 1,
    "edu_fb_category_id": 1,
    "rating": 4.5,
    "status": 1,
    "created_by_designation": "Head Teacher",
    "created_by": 1,
    "created_at": "2025-01-30T10:00:00.000000Z",
    "student": {
      "id": 1,
      "full_name": "John Doe",
      "admission_number": "NY24/001"
    },
    "grade_level": {
      "id": 1,
      "name": "Grade 1"
    },
    "category": {
      "id": 1,
      "name": "Academic Performance"
    },
    "evaluations": [
      {
        "id": 1,
        "edu_fb_id": 1,
        "edu_fd_evaluation_type_id": 1,
        "reviewer_feedback": "Feedback under initial observation",
        "is_parent_visible": false,
        "is_active": true,
        "evaluation_type": {
          "id": 1,
          "name": "Under Observation",
          "status_code": 1,
          "description": "Student is under observation for feedback evaluation"
        }
      }
    ]
  },
  "message": "Educator feedback created successfully"
}
```

### 7. Update Educator Feedback

**Endpoint:** `POST /feedback/update`  
**Purpose:** Update an existing educator feedback record

**Request Body:**
```json
{
  "id": 1,
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 2,
  "rating": 3.8,
  "created_by_designation": "Senior Teacher",
  "comments": "Updated comment - Student shows consistent improvement",
  "question_answers": [
    {
      "edu_fb_predefined_question_id": 1,
      "edu_fb_predefined_answer_id": 2,
      "selected_predefined_answer_id": 2,
      "answer_mark": 7
    }
  ],
  "subcategories": [
    {
      "subcategory_name": "Updated Mathematics Performance"
    }
  ]
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "student_id": 1,
    "grade_level_id": 1,
    "edu_fb_category_id": 2,
    "rating": 3.8,
    "created_by_designation": "Senior Teacher",
    "created_by": 1,
    "updated_by": 1,
    "created_at": "2025-01-30T10:00:00.000000Z",
    "updated_at": "2025-01-30T10:30:00.000000Z",
    "student": {
      "id": 1,
      "full_name": "John Doe",
      "admission_number": "NY24/001"
    },
    "category": {
      "id": 2,
      "name": "Behavioral Assessment"
    },
    "question_answers": [
      {
        "id": 2,
        "predefined_question": {
          "id": 1,
          "question": "How is the student's class participation?"
        },
        "predefined_answer": {
          "id": 2,
          "predefined_answer": "Good"
        }
      }
    ],
    "comments": [
      {
        "id": 2,
        "comment_text": "Updated comment - Student shows consistent improvement"
      }
    ]
  },
  "message": "Educator feedback updated successfully"
}
```

### 8. Delete Educator Feedback

**Endpoint:** `POST /feedback/delete`  
**Purpose:** Delete an educator feedback record and all related data

**Request Body:**
```json
{
  "id": 1
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "deleted_feedback": {
      "id": 1,
      "student_name": "John Doe",
      "admission_number": "NY24/001",
      "category_name": "Behavioral Assessment",
      "rating": 3.8,
      "deleted_relations": {
        "question_answers": 2,
        "subcategories": 1,
        "comments": 1,
        "evaluations": 3,
        "backup_record": 1
      },
      "had_active_evaluations": true,
      "warning": "This feedback had active evaluations which have been permanently removed."
    }
  },
  "message": "Educator feedback deleted successfully"
}
```

### 9. Get Educator Feedback List

**Endpoint:** `POST /feedback/list`  
**Purpose:** Retrieve paginated list of educator feedback with filters

**Request Body (Basic):**
```json
{
  "page_size": 10,
  "page": 1
}
```

**Request Body (With Filters):**
```json
{
  "student_id": 1,
  "grade_level_id": 1,
  "edu_fb_category_id": 1,
  "evaluation_status": 1,
  "date_from": "2025-01-01",
  "date_to": "2025-01-31",
  "search_phrase": "John",
  "page_size": 10,
  "page": 1
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "student_id": 1,
        "grade_level_id": 1,
        "edu_fb_category_id": 1,
        "rating": 4.5,
        "status": 1,
        "created_by_designation": "Head Teacher",
        "created_at": "2025-01-30T10:00:00.000000Z",
        "student": {
          "id": 1,
          "full_name": "John Doe",
          "admission_number": "NY24/001"
        },
        "evaluations": [
          {
            "id": 1,
            "reviewer_feedback": "Feedback under initial observation",
            "evaluation_type": {
              "name": "Under Observation",
              "status_code": 1
            }
          }
        ]
      }
    ],
    "per_page": 10,
    "total": 1
  },
  "message": "Educator feedback list retrieved successfully"
}
```

### 10. Update Evaluation Status

**Endpoint:** `POST /evaluation/update-status`  
**Purpose:** Update the evaluation status following the workflow (1→2→3→4→5→6)

**Request Body:**
```json
{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 2,
  "reviewer_feedback": "Feedback has been reviewed and accepted",
  "is_parent_visible": true
}
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "student_id": 1,
    "edu_fb_id": 1,
    "edu_fd_evaluation_type_id": 2,
    "reviewer_feedback": "Feedback has been reviewed and accepted",
    "is_parent_visible": true,
    "is_active": true,
    "created_at": "2025-01-30T11:00:00.000000Z",
    "student": {
      "id": 1,
      "full_name": "John Doe",
      "admission_number": "NY24/001"
    },
    "evaluation_type": {
      "id": 2,
      "name": "Accept",
      "status_code": 2,
      "description": "Feedback has been accepted and approved"
    }
  },
  "message": "Evaluation status updated successfully"
}
```

---

## Testing Scenarios

### Scenario 1: Category Management Workflow
1. **Get Category List** - Retrieve existing categories
2. **Create Category** - Create new feedback category
3. **Update Category** - Modify category name and status
4. **Create Feedback with New Category** - Test integration
5. **Try Delete Category with Feedback** - Test protection logic
6. **Delete Category** - After removing associated feedback

### Scenario 2: Complete Feedback CRUD Workflow with Auto-Evaluation
1. **Get Metadata** - Retrieve dropdown data
2. **Create Category** - Create custom category if needed
3. **Create Feedback** - Create new feedback with questions/answers
4. **Verify Auto-Evaluation** - Check that evaluation was auto-created with status 1
5. **Get Feedback List** - Verify creation and evaluation presence
6. **Update Feedback** - Modify feedback details, rating, comments
7. **Update Status to Accept** - Change evaluation status from 1 to 2
8. **Update Status to Parent Aware** - Change status from 2 to 4
9. **Delete Feedback** - Test complete removal (if needed)

### Scenario 3: Feedback Edit and Update Workflow
1. **Create Feedback** - Start with basic feedback
2. **Update Feedback Content** - Change student, category, rating
3. **Update Question Answers** - Modify Q&A responses
4. **Update Comments** - Change feedback comments
5. **Verify Changes** - Check updated feedback in list

### Scenario 4: Feedback with Decline Workflow  
1. **Create Feedback** - Start with basic feedback
2. **Update Status to Decline** - Set status to 3 with decline reason
3. **Update Feedback Content** - Edit feedback after decline
4. **Update Status to Correction Required** - Set status to 6
5. **Update Status to Accept** - Final approval (6→2)

### Scenario 5: Search and Filter Testing
1. **Create Multiple Categories** - Different category types
2. **Create Multiple Feedbacks** - Different students, categories, dates
3. **Filter by Student** - Test student_id filter
4. **Filter by Category** - Test edu_fb_category_id filter
5. **Filter by Date Range** - Test date_from/date_to
6. **Search by Name** - Test search_phrase functionality
7. **Paginate Results** - Test different page sizes

### Scenario 6: Data Integrity and Deletion Testing
1. **Create Feedback with Full Relations** - Questions, comments, subcategories
2. **Create Multiple Evaluations** - Test workflow progression
3. **Delete Feedback with Active Evaluations** - Test cascading delete
4. **Verify Complete Removal** - Check all related data deleted
5. **Test Delete Protection** - Try operations on non-existent records

### Scenario 7: Auto-Evaluation Testing
1. **Create Feedback** - Create feedback and capture response
2. **Verify Evaluation Created** - Check 'evaluations' array is present
3. **Verify Initial Status** - Confirm edu_fd_evaluation_type_id = 1
4. **Verify Default Values** - Check reviewer_feedback, is_parent_visible, is_active
5. **Check Evaluation Type** - Verify evaluation_type shows "Under Observation"
6. **Test Status Progression** - Update evaluation status from 1 to 2
7. **Verify Status Change** - Confirm evaluation status updated correctly

### Scenario 8: Error Handling
1. **Invalid Status Transition** - Try invalid workflow (e.g., 1→5 directly)
2. **Missing Required Fields** - Test validation errors for create/update
3. **Non-existent Records** - Test with invalid IDs for update/delete
4. **Unauthorized Access** - Test without proper authentication
5. **Category Delete Protection** - Try deleting category with feedback
6. **Duplicate Category Names** - Test unique name validation (if implemented)
7. **Update Non-existent Feedback** - Test feedback update with invalid ID

---

## Auto-Evaluation Feature

### Automatic Evaluation Creation
When creating educator feedback via `POST /feedback/create`, the system automatically:

1. **Creates Evaluation Record**: Automatically creates an evaluation record linked to the feedback
2. **Sets Initial Status**: Sets `edu_fd_evaluation_type_id = 1` (Under Observation)
3. **Default Values**: 
   - `reviewer_feedback`: "Feedback under initial observation"
   - `is_parent_visible`: false
   - `is_active`: true
   - `decline_reason`: null
4. **Links Relations**: Properly links evaluation to both student and feedback

### Benefits
- **Workflow Ready**: Feedback immediately enters the evaluation workflow
- **Consistent State**: Ensures all feedback has associated evaluation tracking
- **No Manual Step**: Eliminates need to manually create evaluation after feedback
- **Audit Trail**: Provides complete tracking from feedback creation to final status

### Response Structure
The feedback creation response includes the auto-created evaluation:
```json
{
  "success": true,  
  "data": {
    "id": 1,
    "student_id": 1,
    // ... other feedback fields
    "evaluations": [
      {
        "id": 1,
        "edu_fb_id": 1,
        "edu_fd_evaluation_type_id": 1,
        "reviewer_feedback": "Feedback under initial observation",
        "is_parent_visible": false,
        "is_active": true,
        "evaluation_type": {
          "id": 1,
          "name": "Under Observation",
          "status_code": 1
        }
      }
    ]
  }
}
```

---

## Status Workflow Reference

### Valid Status Transitions:
- **1 (Under Observation)** → 2, 3, 4, 5, 6 (Can go to any status)
- **2 (Accept)** → 4, 5, 6
- **3 (Decline)** → 4, 5, 6  
- **4 (Aware Parents)** → 5, 6
- **5 (Assigning to Counselor)** → 6
- **6 (Correction Required)** → 2, 3

### Status Codes:
1. Under Observation
2. Accept  
3. Decline
4. Aware Parents
5. Assigning to Counselor
6. Correction Required

---

## Error Response Format

All errors follow consistent format:
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

---

## Performance Testing

### Load Testing Recommendations:
1. **Concurrent Feedback Creation** - Test with 50+ simultaneous creates
2. **Large List Retrieval** - Test pagination with 1000+ records
3. **Complex Filter Queries** - Test with multiple filters simultaneously
4. **Database Transaction Load** - Test evaluation status updates under load

---

## Database Prerequisites

Before testing, ensure:
1. **Students exist** in the Student table
2. **Grade Levels exist** in the GradeLevel table  
3. **Categories exist** in edu_fb_category table
4. **Evaluation Types exist** (should be pre-populated via SQL)
5. **Users exist** for authentication

Use the metadata endpoint to verify all prerequisite data is available before running other tests.