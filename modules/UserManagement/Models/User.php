<?php

namespace Modules\UserManagement\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AttendanceManagement\Models\EducatorAttendance;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\StudentManagement\Models\EducatorFeedback;
use Modules\StudentManagement\Models\EducatorFeedbackEvolutionProcess;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\StudentManagement\Models\Student;
use Modules\AcademicStaffManagement\Models\ClassTeacher;
use Modules\AcademicStaffManagement\Models\SectionalHead;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'password_new',
        'is_active',
        'user_category',
        'created_by',
        'updated_by',
        'currently_focused_chat_id',
        // 'fcm_token',
    ];
    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'currently_focused_chat_id' => 'integer',
        ];
    }

    protected static function newFactory()
    {
        return \Modules\UserManagement\Database\Factories\UserFactory::new();
    }

    public function user_type_list(): BelongsToMany
    {
        return $this->belongsToMany(UserType::class, 'user_user_type_pivot', 'user_id', 'user_type_id');
    }

    // Relationship with StudentGuardian
    public function student_guardian_list(): HasMany
    {
        return $this->hasMany(StudentGuardian::class, 'user_id', 'id');
    }

    // Relationship with UserPayment
    public function user_payments(): HasMany
    {
        return $this->hasMany(UserPayment::class, 'user_id', 'id');
    }

    // Relationship with UserProfileImage
    public function profile_images(): HasMany
    {
        return $this->hasMany(UserProfileImage::class, 'user_id', 'id');
    }

    // Get active profile image
    public function profile_image(): HasMany
    {
        return $this->profile_images()->where('is_active', true);
    }

    // Get the current active profile image
    public function getActiveProfileImage(): ?UserProfileImage
    {
        return $this->profile_image()->orderBy('created_at', 'desc')->first();
    }

    // Active payments only
    public function active_payments(): HasMany
    {
        return $this->user_payments()->where('is_active', true);
    }

    // Current payments (not expired)
    public function current_payments(): HasMany
    {
        return $this->active_payments()->where(function ($query) {
            $query->where('end_date', '>=', now()->toDateString())
                  ->orWhereNull('end_date');
        })->where('start_date', '<=', now()->toDateString());
    }

    // Get students accessible through payments
    public function accessible_students()
    {
        return Student::whereHas('user_payment_students', function ($query) {
            $query->where('is_active', true)
                  ->current()
                  ->whereHas('user_payment', function ($paymentQuery) {
                      $paymentQuery->where('user_id', $this->id)
                                   ->where('is_active', true)
                                   ->current();
                  });
        });
    }

    // Check if user has valid payment for any students
    public function hasValidPayments(): bool
    {
        return $this->current_payments()->exists();
    }

    // Get student count accessible through payments
    public function getAccessibleStudentCountAttribute(): int
    {
        return $this->accessible_students()->count();
    }

    // Get profile image URL attribute
    public function getProfileImageUrlAttribute(): ?string
    {
        $profileImage = $this->getActiveProfileImage();
        return $profileImage ? $profileImage->getFullUrl() : null;
    }

    // Get profile image public path attribute
    public function getProfileImagePathAttribute(): ?string
    {
        $profileImage = $this->getActiveProfileImage();
        return $profileImage ? $profileImage->getPublicPath() : null;
    }

    // Check if user has profile image
    public function hasProfileImage(): bool
    {
        return $this->getActiveProfileImage() !== null;
    }

    // Relationship with ClassTeacher
    public function class_teacher_assignments(): HasMany
    {
        return $this->hasMany(ClassTeacher::class, 'user_id', 'id');
    }

    // Relationship with SectionalHead
    public function sectional_head_assignments(): HasMany
    {
        return $this->hasMany(SectionalHead::class, 'user_id', 'id');
    }
}
