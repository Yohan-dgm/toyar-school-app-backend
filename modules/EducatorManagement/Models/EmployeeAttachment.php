<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\EmployeeManagement\Models\Employee;

class EmployeeAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'employee_attachment';

    protected $fillable = [
        'employee_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    // factory
    // protected static function newFactory(): BankAccountFactory
    // {
    //     return new BankAccountFactory();
    // }
}
