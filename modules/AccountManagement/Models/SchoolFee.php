<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevel;

class SchoolFee extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'school_fee';

    protected $fillable = [
        'school_fee_type',
        //Admission Fee, Refundable Deposit, Term Fee, Sport Fee
        'grade_level_id', //--Admission Fee, Term Fee
        'term_id', //--Term Fee
        'amount',
        'is_active',
        'version',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function grade_lavel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }
}
