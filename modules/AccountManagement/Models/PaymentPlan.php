<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\Program;
use Modules\StudentManagement\Models\Student;

class PaymentPlan extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'payment_plan';

    protected $fillable = [
        'student_id',
        'grade_level_id',
        'main_program_id',
        'main_program_down_payment',
        'admission_down_payment',
        'refundable_deposit_down_payment',
        'agreed_number_of_installments',
        'should_add_installment_interest',
        'installment_interest_factor',
        'should_add_late_payment_interest',
        'late_payment_interest_factor',
        'main_program_rate_id',
        'main_program_rate',
        'admission_rate_id',
        'admission_rate',
        'refundable_deposit_rate_id',
        'refundable_deposit_rate',
        'is_first_down_payment_bill_generated',
        'first_down_payment_bill_id',
        'is_active',
        'pending_number_of_installments',
        'subtotal',
        'discount',
        'subtotal_after_discount',
        'total',
        'total_due',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function main_program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'main_program_id', 'id');
    }

    public function main_program_rate(): BelongsTo
    {
        return $this->belongsTo(ItemRate::class, 'main_program_rate_id', 'id');
    }

    public function admission_rate(): BelongsTo
    {
        return $this->belongsTo(ItemRate::class, 'admission_rate_id', 'id');
    }

    public function refundable_deposit_rate(): BelongsTo
    {
        return $this->belongsTo(ItemRate::class, 'refundable_deposit_rate_id', 'id');
    }

    // factory
    // protected static function newFactory(): PaymentPlanFactory
    // {
    //     return new PaymentPlanFactory();
    // }
}
