<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\ExamBillItem;

class ExamSubjectCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_subject_category';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_subject_list(): HasMany
    {
        return $this->hasMany(ExamSubject::class, 'exam_subject_category_id', 'id');
    }

    public function exam_bill_item_list(): HasMany
    {
        return $this->hasMany(ExamBillItem::class, 'exam_bill_category_id', 'id');
    }
}
