<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class StudentAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_attachment';

    protected $fillable = [
        'student_id',
        'file_name',
        'original_file_name',
        'mime_type',
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
    // factory
    // protected static function newFactory(): BankAccountFactory
    // {
    //     return new BankAccountFactory();
    // }
}
