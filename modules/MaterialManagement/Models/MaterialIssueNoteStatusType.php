<?php

namespace Modules\MaterialManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class MaterialIssueNoteStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_issue_note_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function material_issue_note_list(): HasMany
    {
        return $this->hasMany(MaterialIssueNote::class, 'material_issue_note_status_type_id', 'id');
    }
}
