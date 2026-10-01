<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserPushToken extends Model
{
    use HasFactory;

    protected $table = 'user_push_tokens';

    protected $fillable = [
        'user_id',
        'device_id',
        'push_token',
        'platform',
        'app_version',
        'device_name',
        'device_model',
        'os_version',
        'is_active',
        'last_used_at',
        'failed_deliveries',
        'last_failure_at',
        'failure_reason',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'failed_deliveries' => 'integer',
        'last_failure_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Constants for platform types
    const PLATFORM_IOS = 'ios';
    const PLATFORM_ANDROID = 'android';

    const PLATFORMS = [
        self::PLATFORM_IOS,
        self::PLATFORM_ANDROID,
    ];

    // Constants for failure thresholds
    const MAX_FAILED_DELIVERIES = 5;
    const INACTIVE_DAYS_THRESHOLD = 30;

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForDevice($query, $deviceId)
    {
        return $query->where('device_id', $deviceId);
    }

    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeRecentlyUsed($query, $days = 30)
    {
        return $query->where('last_used_at', '>=', now()->subDays($days));
    }

    public function scopeStale($query, $days = null)
    {
        $days = $days ?? self::INACTIVE_DAYS_THRESHOLD;
        return $query->where('last_used_at', '<', now()->subDays($days));
    }

    public function scopeWithFailures($query)
    {
        return $query->where('failed_deliveries', '>', 0);
    }

    public function scopeExceedingFailureThreshold($query)
    {
        return $query->where('failed_deliveries', '>=', self::MAX_FAILED_DELIVERIES);
    }

    public function scopeValidTokens($query)
    {
        return $query->active()
            ->where('failed_deliveries', '<', self::MAX_FAILED_DELIVERIES);
    }

    // Accessors
    public function getIsValidAttribute(): bool
    {
        return $this->is_active && 
               $this->failed_deliveries < self::MAX_FAILED_DELIVERIES &&
               $this->last_used_at->gt(now()->subDays(self::INACTIVE_DAYS_THRESHOLD));
    }

    public function getIsStaleAttribute(): bool
    {
        return $this->last_used_at->lt(now()->subDays(self::INACTIVE_DAYS_THRESHOLD));
    }

    public function getDaysInactiveAttribute(): int
    {
        return $this->last_used_at->diffInDays(now());
    }

    public function getFormattedLastUsedAttribute(): string
    {
        return $this->last_used_at->format('M d, Y \a\t g:i A');
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->last_used_at->diffForHumans();
    }

    // Helper methods
    public function markAsUsed(): bool
    {
        return $this->update([
            'last_used_at' => Carbon::now(),
        ]);
    }

    public function incrementFailure(string $reason = null): bool
    {
        return $this->update([
            'failed_deliveries' => $this->failed_deliveries + 1,
            'last_failure_at' => Carbon::now(),
            'failure_reason' => $reason,
        ]);
    }

    public function resetFailures(): bool
    {
        return $this->update([
            'failed_deliveries' => 0,
            'last_failure_at' => null,
            'failure_reason' => null,
        ]);
    }

    public function deactivate(string $reason = null): bool
    {
        return $this->update([
            'is_active' => false,
            'failure_reason' => $reason,
            'last_failure_at' => Carbon::now(),
        ]);
    }

    public function activate(): bool
    {
        return $this->update([
            'is_active' => true,
            'failed_deliveries' => 0,
            'last_failure_at' => null,
            'failure_reason' => null,
            'last_used_at' => Carbon::now(),
        ]);
    }

    public function updateToken(string $newToken, array $deviceInfo = []): bool
    {
        $updateData = [
            'push_token' => $newToken,
            'last_used_at' => Carbon::now(),
            'is_active' => true,
            'failed_deliveries' => 0,
            'last_failure_at' => null,
            'failure_reason' => null,
        ];

        // Update device info if provided
        if (isset($deviceInfo['app_version'])) {
            $updateData['app_version'] = $deviceInfo['app_version'];
        }
        if (isset($deviceInfo['device_name'])) {
            $updateData['device_name'] = $deviceInfo['device_name'];
        }
        if (isset($deviceInfo['device_model'])) {
            $updateData['device_model'] = $deviceInfo['device_model'];
        }
        if (isset($deviceInfo['os_version'])) {
            $updateData['os_version'] = $deviceInfo['os_version'];
        }

        return $this->update($updateData);
    }

    // Static methods
    public static function createOrUpdateToken(int $userId, string $deviceId, string $pushToken, string $platform, array $deviceInfo = []): self
    {
        $token = self::where('user_id', $userId)
                    ->where('device_id', $deviceId)
                    ->first();

        if ($token) {
            $token->updateToken($pushToken, $deviceInfo);
            return $token->fresh();
        }

        return self::create(array_merge([
            'user_id' => $userId,
            'device_id' => $deviceId,
            'push_token' => $pushToken,
            'platform' => $platform,
            'is_active' => true,
            'failed_deliveries' => 0,
            'last_used_at' => Carbon::now(),
        ], $deviceInfo));
    }

    public static function getValidTokensForUser(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return self::forUser($userId)->validTokens()->get();
    }

    public static function getValidTokensForUsers(array $userIds): \Illuminate\Database\Eloquent\Collection
    {
        return self::whereIn('user_id', $userIds)->validTokens()->get();
    }

    public static function cleanupInvalidTokens(): int
    {
        // Deactivate tokens that exceed failure threshold
        $deactivatedCount = self::exceedingFailureThreshold()
            ->active()
            ->update([
                'is_active' => false,
                'failure_reason' => 'Exceeded maximum failed deliveries',
            ]);

        // Delete very old inactive tokens (older than 90 days)
        $deletedCount = self::inactive()
            ->where('updated_at', '<', now()->subDays(90))
            ->delete();

        return $deactivatedCount + $deletedCount;
    }

    public static function getTokenStats(): array
    {
        $total = self::count();
        $active = self::active()->count();
        $ios = self::active()->byPlatform(self::PLATFORM_IOS)->count();
        $android = self::active()->byPlatform(self::PLATFORM_ANDROID)->count();
        $withFailures = self::active()->withFailures()->count();
        $stale = self::active()->stale()->count();

        return [
            'total_tokens' => $total,
            'active_tokens' => $active,
            'inactive_tokens' => $total - $active,
            'ios_tokens' => $ios,
            'android_tokens' => $android,
            'tokens_with_failures' => $withFailures,
            'stale_tokens' => $stale,
            'health_percentage' => $total > 0 ? round((($active - $withFailures - $stale) / $total) * 100, 2) : 100,
        ];
    }
}