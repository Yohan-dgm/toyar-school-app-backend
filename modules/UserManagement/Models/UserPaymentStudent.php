<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\StudentManagement\Models\Student;

class UserPaymentStudent extends Model
{
    use HasFactory;

    protected $table = 'user_payment_student';

    protected $fillable = [
        'user_payment_id',
        'student_id',
        'is_active',
        'start_date',
        'end_date',
        'access_level',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationship with UserPayment
    public function user_payment(): BelongsTo
    {
        return $this->belongsTo(UserPayment::class, 'user_payment_id', 'id');
    }

    // Relationship with Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Relationship with created by user
    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relationship with updated by user
    public function updated_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Get the user who owns this payment (through user_payment)
    public function owner_user()
    {
        return $this->hasOneThrough(
            User::class,
            UserPayment::class,
            'id', // Foreign key on user_payments table
            'id', // Foreign key on users table
            'user_payment_id', // Local key on user_payment_student table
            'user_id' // Local key on user_payments table
        );
    }

    // Scope for active payment-student relationships
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for current access (not expired)
    public function scopeCurrent($query)
    {
        return $query->where(function ($q) {
            $q->where('end_date', '>=', now()->toDateString())
                ->orWhereNull('end_date');
        });
    }

    // Scope for specific access level
    public function scopeByAccessLevel($query, $accessLevel)
    {
        return $query->where('access_level', $accessLevel);
    }

    // Scope for students with valid payment access
    public function scopeWithValidPayment($query)
    {
        return $query->whereHas('user_payment', function ($paymentQuery) {
            $paymentQuery->where('is_active', true)
                ->where('start_date', '<=', now()->toDateString())
                ->where(function ($dateQuery) {
                    $dateQuery->where('end_date', '>=', now()->toDateString())
                        ->orWhereNull('end_date');
                });
        });
    }

    // Check if this student access is currently valid
    public function isCurrentlyValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->start_date > now()->toDateString()) {
            return false;
        }

        if ($this->end_date && $this->end_date < now()->toDateString()) {
            return false;
        }

        // Also check if the parent payment is valid
        return $this->user_payment ? $this->user_payment->isCurrentlyValid() : false;
    }

    // Get access level display name
    public function getAccessLevelDisplayAttribute(): string
    {
        return match ($this->access_level) {
            'full' => 'Full Access',
            'limited' => 'Limited Access',
            'readonly' => 'Read Only Access',
            default => ucfirst($this->access_level)
        };
    }

    // Get status based on payment and access validity
    public function getStatusAttribute(): string
    {
        if (! $this->is_active) {
            return 'inactive';
        }

        if ($this->start_date > now()->toDateString()) {
            return 'pending';
        }

        if ($this->end_date && $this->end_date < now()->toDateString()) {
            return 'expired';
        }

        if (! $this->user_payment || ! $this->user_payment->isCurrentlyValid()) {
            return 'payment_expired';
        }

        return 'active';
    }

    // Static method to get students accessible by a user
    public static function getAccessibleStudentsForUser($userId)
    {
        return Student::whereHas('user_payment_students', function ($query) use ($userId) {
            $query->active()
                ->current()
                ->whereHas('user_payment', function ($paymentQuery) use ($userId) {
                    $paymentQuery->where('user_id', $userId)
                        ->where('is_active', true)
                        ->current();
                });
        });
    }
}
