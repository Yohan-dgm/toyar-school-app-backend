<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\ExamBillItem;
use Modules\AccountManagement\Models\ItemRate;

class ExamSubject extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_subject';

    protected $fillable = [
        'exam_subject_category_id',
        'name',
        'exam_subject_code',
        'exam_subject_components',
        'has_practical_component',
        'exam_subject_option_code',
        'exam_subject_fee',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_subject_category(): BelongsTo
    {
        return $this->belongsTo(ExamSubjectCategory::class, 'exam_subject_category_id', 'id');
    }

    public function exam_subject_component_list(): HasMany
    {
        return $this->hasMany(ExamSubjectComponent::class, 'exam_subject_id', 'id');
    }

    public function exam_subject_group_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamSubjectGroup::class, 'exam_subject_exam_subject_group_pivot', 'exam_subject_id', 'exam_subject_group_id');
    }

    public function exam_bill_item_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamBillItem::class, 'exam_bill_item_exam_subject_pivot', 'exam_subject_id', 'exam_bill_item_id');
    }

    public function item_rate_list(): HasMany
    {
        return $this->hasMany(ItemRate::class, 'exam_subject_id', 'id');
    }
}
