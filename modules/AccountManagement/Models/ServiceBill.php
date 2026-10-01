<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AdmissionManagement\Models\Applicant;
use Modules\StudentManagement\Models\Student;

class ServiceBill extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'service_bill';

    protected $fillable = [
        //user
        'date',
        'bill_party',
        'student_id',
        'applicant_id',
        'subtotal',
        'total',

        //system
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function service_bill_item_list(): HasMany
    {
        return $this->hasMany(ServiceBillItem::class, 'service_bill_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }
}
