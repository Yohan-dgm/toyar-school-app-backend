<?php

namespace Modules\SportManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\Sport;

class SportCoach extends Model
{
    use HasFactory;

    protected $table = 'sport_coaches';

    protected $fillable = [
        'sport_id',
        'coach_id',
        'is_head_coach',
        'is_active',
        'started_date',
        'ended_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_head_coach' => 'boolean',
        'is_active' => 'boolean',
        'started_date' => 'date',
        'ended_date' => 'date',
    ];

    public $timestamps = true;

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Educator::class, 'coach_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHeadCoaches($query)
    {
        return $query->where('is_head_coach', true);
    }

    public function scopeBySport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    public function scopeByCoach($query, $coachId)
    {
        return $query->where('coach_id', $coachId);
    }
}
