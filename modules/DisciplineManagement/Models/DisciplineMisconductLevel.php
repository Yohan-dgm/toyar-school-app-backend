<?php

namespace Modules\DisciplineManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DisciplineMisconductLevel extends Model
{
    use HasFactory;

    protected $table = "discipline_misconduct_level";

    protected $fillable = [
        "level_number",
        "level_name",
        "nature_of_offence",
        "indicative_deduction_min",
        "indicative_deduction_max",
        "examples",
        "approval_tier",
        "is_active",
        "created_by",
        "updated_by",
    ];
    public $timestamps = true;

    protected $casts = [
        "is_active" => "boolean",
    ];

    public function discipline_record_list(): HasMany
    {
        return $this->hasMany(DisciplineRecord::class, "misconduct_level_id", "id");
    }
}
