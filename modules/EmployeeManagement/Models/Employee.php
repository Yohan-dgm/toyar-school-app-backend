<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AttendanceManagement\Models\Leave;
use Modules\EducatorManagement\Models\Educator;
use Modules\EducatorManagement\Models\EmployeeAttachment;
use Modules\GeneralEntityManagement\Models\PersonTitle;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'full_name',
        'full_name_with_title',
        'calling_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'phone',
        'email',
        'address',
        'employee_id_type',
        'nic_number',
        'passport_number',
        // "educator_grade_id",
        // "main_subject_id",
        'designation_id',
        'person_title_id',
        'blood_group',
        'special_health_conditions',
        'employee_type_id',
        'epf_number',
        'employee_number',
        'employee_number_digits',
        'employee_number_prefix',
        'employee_number_current_year',
        'remaining_annual_leaves',
        'remaining_medical_leaves',
        'remaining_maternity_leaves',
        'joined_date',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public $timestamps = true;

    /**
     * Relationship with Employee Type
     */
    public function role_list(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'employee_role_pivot', 'employee_id', 'role_id');
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function person_title(): BelongsTo
    {
        return $this->belongsTo(PersonTitle::class, 'person_title_id', 'id');
    }

    public function leave_list(): HasMany
    {
        return $this->hasMany(Leave::class, 'employee_id', 'id');
    }

    public function employee_type(): BelongsTo
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }

    public function employee_attachment_list(): HasMany
    {
        return $this->hasMany(EmployeeAttachment::class, 'employee_id', 'id');
    }

    public function educator(): HasOne
    {
        return $this->hasOne(Educator::class, 'employee_id', 'id');
    }

    public function purchase_request_note_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNote::class, 'requested_by_id', 'id');
    }

    public function goods_received_note_item_list(): HasMany
    {
        return $this->hasMany(GoodsReceivedNoteItem::class, 'received_by_id', 'id');
    }

    public function payment_voucher_list(): HasMany
    {
        return $this->hasMany(PaymentVoucher::class, 'payment_issued_by_id', 'id');
    }
}
