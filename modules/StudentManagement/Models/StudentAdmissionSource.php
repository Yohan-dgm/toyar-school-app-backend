<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class StudentAdmissionSource extends Model
{
    protected $table = 'student_admission_source';

    protected $fillable = [
      
        'name', 
        'created_by',
        'updated_by', 
    ];

  
    /**
     * Relationship with Employee Type
     */
    
   
    public function student_list() :HasMany
    {
        return $this->hasMany(Student::class, 'student_admission_source_id', 'id'); 

    }


}