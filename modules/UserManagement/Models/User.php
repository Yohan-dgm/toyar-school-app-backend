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
        ];
    }

    public function user_type_list(): BelongsToMany
    {
        return $this->belongsToMany(UserType::class, 'user_user_type_pivot', 'user_id', 'user_type_id');
    }
}
