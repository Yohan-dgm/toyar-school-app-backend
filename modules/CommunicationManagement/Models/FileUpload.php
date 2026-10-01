<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'file_uploads';

    protected $fillable = [
        'user_id',
        'filename',
        'mime_type',
        'total_size',
        'uploaded_size',
        'status',
        'storage_path',
        'metadata',
    ];

    protected $casts = [
        'total_size' => 'integer',
        'uploaded_size' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Helpers
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getProgressPercentage(): int
    {
        if ($this->total_size === 0) return 0;
        return (int) (($this->uploaded_size / $this->total_size) * 100);
    }
}
