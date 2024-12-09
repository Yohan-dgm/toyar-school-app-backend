<?php

namespace Modules\StudentManagement\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
     
         
        'applicant_id',
        'admission_number',
        'student_admission_source_id',
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
        'created_by',
        'updated_by', 



 
 

    ];

  
    /**
     * Relationship with Employee Type
     */
    
   
    public function student_admission_source() :BelongsTo
    {
        return $this->belongsTo(StudentAdmissionSource::class, 'student_admission_source_id', 'id'); 

    }


}
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AttendanceManagement\Models\StudentAttendance;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'full_name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function student_attendance_list(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'student_id', 'id');
    }

    // protected static function newFactory(): StudentFactory
    // {
    //     return new StudentFactory();
    // }
}
>>>>>>> 0333d13759d7dac8730a4729aa261a528a41a933
