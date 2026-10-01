<?php

namespace Modules\SectionAccessManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class SectionAccess extends Model
{
    protected $table = "section_access";

    protected $fillable = [
        "section_key",
        "user_id",
        "granted_by",
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function granted_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, "granted_by", "id");
    }
}
