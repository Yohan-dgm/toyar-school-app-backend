<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\ServiceBill;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeePayment;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\EducatorManagement\Models\EducatorRole;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\GeneralEntityManagement\Models\Nationality;
use Modules\GeneralEntityManagement\Models\Religion;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\UserManagement\Models\UserPaymentStudent;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'applicant_id',
        'admission_number',
        'student_admission_source_id',
        'student_admission_source_other',
        'grade_level_class_id',
        'joined_date',
        'full_name',
        'gender',
        'full_name_with_title',
        'date_of_birth',
        'nationality_id',
        'religion_id',
        'grade_level_id',
        'full_address',
        'phone',
        'email',
        'school_studied_before',
        'special_conditions',
        'admission_fee_discount_percentage',
        'approved_admission_fee',
        'applicable_refundable_deposit',
        'applicable_term_payment',
        'applicable_year_payment',
        'school_house_id',
        'has_dropped_out',
        'created_by',
        'updated_by',
        'admission_number_digits',
        'admission_number_prefix',
        'admission_number_current_year',
        'user_id',
        'joined_term_id',
        'is_sport_list',
        'student_address',
        'is_school_leaver',
        //
        'father_full_name',
        'father_id_type',
        'father_nic_number',
        'father_passport_number',
        'father_phone',
        'father_whatsapp',
        'father_email',
        'father_occupation',
        'father_place_of_work',
        'father_monthly_income',
        //
        'mother_full_name',
        'mother_id_type',
        'mother_nic_number',
        'mother_passport_number',
        'mother_phone',
        'mother_whatsapp',
        'mother_email',
        'mother_occupation',
        'mother_place_of_work',
        'mother_monthly_income',
        //
        'guardian_full_name',
        'guardian_id_type',
        'guardian_nic_number',
        'guardian_passport_number',
        'guardian_phone',
        'guardian_whatsapp',
        'guardian_email',
        'guardian_occupation',
        'guardian_place_of_work',
        'guardian_monthly_income',
        //
        'student_phone',
        'student_email',
        'blood_group',
        'special_health_conditions',
        'student_calling_name',
        // Foreign keys for guardian relationships
        'father_id',
        'mother_id',
        'guardian_id',
    ];

    public $timestamps = true;

    public function student_attachment_list(): HasMany
    {
        return $this->hasMany(StudentAttachment::class, 'student_id', 'id')
            ->orderBy('created_at', 'desc')
            ->limit(1);
    }

    public function student_admission_source(): BelongsTo
    {
        return $this->belongsTo(StudentAdmissionSource::class, 'student_admission_source_id', 'id');
    }

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    public function school_house(): BelongsTo
    {
        return $this->belongsTo(SchoolHouse::class, 'school_house_id', 'id');
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function student_attendance_list(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'student_id', 'id');
    }

    public function student_supply_list(): HasMany
    {
        return $this->hasMany(StudentSupply::class, 'student_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'student_id', 'id');
    }

    public function latest_term_fee_receipt_voucher()
    {
        return $this->hasOne(ReceiptVoucher::class, 'student_id', 'id')->where('payment_received_date', '>', '2024-12-31')->whereNotNull('term_fee_settlement')->where('term_fee_settlement', '>', 0)->select('id', 'student_id', 'admission_fee_settlement', 'refundable_deposit_settlement', 'term_fee_settlement')->latest();
    }

    public function material_bill_list(): HasMany
    {
        return $this->hasMany(MaterialBill::class, 'student_id', 'id');
    }

    public function service_bill_list(): HasMany
    {
        return $this->hasMany(ServiceBill::class, 'student_id', 'id');
    }

    public function exam_bill_list(): HasMany
    {
        return $this->hasMany(ExamBill::class, 'student_id', 'id');
    }

    public function student_list(): HasMany
    {
        return $this->hasMany(StudentExamMark::class, 'student_id', 'id');
    }

    public function admission_fee_invoice_list(): HasMany
    {
        return $this->hasMany(AdmissionFeeInvoice::class, 'student_id', 'id');
    }

    public function refundable_deposit_list(): HasMany
    {
        return $this->hasMany(RefundableDeposit::class, 'student_id', 'id');
    }

    public function term_fee_invoice_list(): HasMany
    {
        return $this->hasMany(TermFeeInvoice::class, 'student_id', 'id');
    }

    public function sport_fee_invoice_list(): HasMany
    {
        return $this->hasMany(SportFeeInvoice::class, 'student_id', 'id');
    }

    // public function message_user_list(): HasMany
    // {
    //     return $this->hasMany(MessageChatGroupItem::class, 'user_id', 'user_id');
    // }

    public function student_sport_list(): HasMany
    {
        return $this->hasMany(StudentSport::class, 'student_id', 'id');
    }

    public function term_fee_payment_list(): HasMany
    {
        return $this->hasMany(TermFeePayment::class, 'student_id', 'id');
    }

    public function student_role_list(): HasMany
    {
        return $this->hasMany(StudentRole::class, 'student_id', 'id');
    }

    public function student_achievement_list(): HasMany
    {
        return $this->hasMany(StudentAchievement::class, 'student_id', 'id');
    }

    public function educator_role_list(): HasMany
    {
        return $this->hasMany(EducatorRole::class, 'grade_level_id', 'id');
    }

    public function grade_level_educator_role_list(): HasMany
    {
        return $this->hasMany(EducatorRole::class, 'grade_level_id', 'grade_level_id');
    }

    // Guardian relationships
    public function father(): BelongsTo
    {
        return $this->belongsTo(StudentGuardian::class, 'father_id', 'id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(StudentGuardian::class, 'mother_id', 'id');
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(StudentGuardian::class, 'guardian_id', 'id');
    }

    // Relationship with UserPaymentStudent (junction table)
    public function user_payment_students(): HasMany
    {
        return $this->hasMany(UserPaymentStudent::class, 'student_id', 'id');
    }

    // Get active payment relationships
    public function active_user_payment_students(): HasMany
    {
        return $this->user_payment_students()->where('is_active', true);
    }

    // Get current valid payment relationships
    public function current_user_payment_students(): HasMany
    {
        return $this->active_user_payment_students()
            ->where('start_date', '<=', now()->toDateString())
            ->where(function ($query) {
                $query->where('end_date', '>=', now()->toDateString())
                    ->orWhereNull('end_date');
            });
    }
}
