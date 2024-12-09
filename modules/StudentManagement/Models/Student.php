<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Student extends Model
{
    protected $table = 'employee';

    protected $fillable = [
     
         
        'applicant_id',
        'admission_number',
        'student_admission_source_id',
        'joined_date',
        'full_name',
        'gender
        full_name_with_title',
        'date_of_birth',
        'nationality_id',
        'religion_id',
        'grade_level_id',
        'full_address',
        'phone
        email
        school_studied_before',
        'special_conditions',
        'admission_fee_discount_percentage',
        'approved_admission_fee',
        'applicable_refundable_deposit',
        'applicable_term_payment',
        'applicable_year_payment', 


 
 

    ];

  
    /**
     * Relationship with Employee Type
     */
    
   
    public function student_admission_source() :BelongsTo
    {
        return $this->belongsTo(StudentAdmissionSource::class, 'student_admission_source_id', 'id'); 

    }


}