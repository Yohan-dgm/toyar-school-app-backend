<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Modules\ExamManagement\Models\ExamSubject;
use Modules\ExamManagement\Models\ExamSubjectCategory;

class ExamBillItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_bill_item';

    protected $fillable = [
        'exam_bill_id',
        'exam_subject_category_id',
        'rate_id_list',
        'rate_list',
        'subtotal',
        'total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_bill(): BelongsTo
    {
        return $this->belongsTo(ExamBill::class, 'exam_bill_id', 'id');
    }

    public function exam_subject_category(): BelongsTo
    {
        return $this->belongsTo(ExamSubjectCategory::class, 'exam_subject_category_id', 'id');
    }

    public function exam_subject_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamSubject::class, 'exam_bill_item_exam_subject_pivot', 'exam_bill_item_id', 'exam_subject_id');
    }
}
