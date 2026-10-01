<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\StudentManagement\Models\Student;

class UserPayment extends Model
{
    use HasFactory;

    protected $table = 'user_payments';

    protected $fillable = [
        'user_id',
        'package_type',
        'is_active',
        'start_date',
        'end_date',
        'amount',
        'currency',
        'payment_method',
        'transaction_reference',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationship with User (owner of the payment)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship with UserPaymentStudent (junction table)
    public function user_payment_students(): HasMany
    {
        return $this->hasMany(UserPaymentStudent::class, 'user_payment_id', 'id');
    }

    // Direct relationship to students through the junction table
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            UserPaymentStudent::class,
            'user_payment_id', // Foreign key on user_payment_student table
            'id', // Foreign key on students table
            'id', // Local key on user_payments table
            'student_id' // Local key on user_payment_student table
        );
    }

    // Active students only (where user_payment_student.is_active = true)
    public function active_students()
    {
        return $this->students()->wherePivot('is_active', true);
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

    // Scope for active payments
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for payments by package type
    public function scopeByPackageType($query, $packageType)
    {
        return $query->where('package_type', $packageType);
    }

    // Scope for current payments (not expired)
    public function scopeCurrent($query)
    {
        return $query->where(function ($q) {
            $q->where('end_date', '>=', now()->toDateString())
                ->orWhereNull('end_date');
        });
    }

    // Check if payment is currently valid
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

        return true;
    }

    // Get package type display name
    public function getPackageTypeDisplayAttribute(): string
    {
        return match ($this->package_type) {
            'basic' => 'Basic Package',
            'family' => 'Family Package',
            'premium' => 'Premium Package',
            'annual' => 'Annual Package',
            default => ucfirst($this->package_type)
        };
    }

    // Get payment status
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

        return 'active';
    }
}
