<?php

namespace Modules\DisciplineManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class DisciplineRecord extends Model
{
    use HasFactory;

    protected $table = "discipline_record";

    protected $fillable = [
        "student_id",
        "academic_year",
        "misconduct_level_id",
        "offence",
        "description",
        "incident_date",
        "marks_deducted",
        "override_reason",
        "disciplinary_action_taken",
        "reported_by",
        "reviewed_by",
        "status",
        "reviewed_date",
        "parent_informed",
        "student_response",
        "grade_class_at_time",
        "is_active",
        "created_by",
        "updated_by",
    ];
    public $timestamps = true;

    protected $casts = [
        "incident_date" => "date",
        "reviewed_date" => "date",
        "parent_informed" => "boolean",
        "is_active" => "boolean",
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, "student_id", "id");
    }

    public function misconduct_level(): BelongsTo
    {
        return $this->belongsTo(DisciplineMisconductLevel::class, "misconduct_level_id", "id");
    }

    public function reported_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, "reported_by", "id");
    }

    public function reviewed_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, "reviewed_by", "id");
    }
}
