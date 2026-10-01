<?php

namespace Modules\CommunicationManagement\Intents\Chat\SearchChatUsers;

use Illuminate\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Modules\UserManagement\Models\User;

class SearchChatUsersAction
{
    use AsAction;

    public function handle(array $payload, array $actionData)
    {
        // Validate payload using the DTO
        $dtoData = SearchChatUsersDTO::validate($payload);

        $query = User::query();

        // Filter by category
        if (isset($dtoData['filter']) && $dtoData['filter'] !== 'all') {
            $query->where('user_category', $this->getCategoryValue($dtoData['filter']));
        }

        // Search by name, full_name, username, or role
        if (isset($dtoData['query']) && $dtoData['query'] !== '') {
            $searchTerm = $dtoData['query'];
            $query->where(function (Builder $q) use ($searchTerm) {
                // Search across multiple possible name columns
                $q->where('full_name', 'ILIKE', '%'.$searchTerm.'%')
                  ->orWhere('name', 'ILIKE', '%'.$searchTerm.'%')
                  ->orWhere('username', 'ILIKE', '%'.$searchTerm.'%');
                
                // Add role-based search
                $categorySearch = $this->searchCategoryValue($searchTerm);
                if ($categorySearch !== null) {
                    $q->orWhere('user_category', $categorySearch);
                }
            });
        }

        // Get existing group members to flag them
        $existingMemberIds = [];
        if (isset($dtoData['chat_group_id'])) {
            $existingMemberIds = ChatGroupMember::where('chat_group_id', $dtoData['chat_group_id'])
                ->where('is_active', true)
                ->pluck('user_id')
                ->map(fn($id) => (string)$id)
                ->toArray();
        }

        $perPage = $dtoData['per_page'] ?? 50;
        
        $users = $query->with(['profile_images' => function ($q) {
                $q->where('is_active', true)->orderBy('created_at', 'desc')->limit(1);
            }])
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return $users->through(function ($user) use ($existingMemberIds) {
            $profileImage = $user->profile_images->first();
            return [
                'id' => $user->id,
                'name' => $user->full_name ?? $user->name ?? $user->username,
                'username' => $user->username,
                'avatar' => $profileImage ? $profileImage->getFullUrl() : null,
                'role' => $this->getRoleLabel($user->user_category),
                'is_member' => in_array((string)$user->id, $existingMemberIds),
            ];
        });
    }

    private function getCategoryValue($filter): int
    {
        return match ($filter) {
            'parent' => 1,
            'teacher' => 2,
            'management' => 4,
            'student' => 5,
            default => 0,
        };
    }

    private function searchCategoryValue($term): ?int
    {
        $term = strtolower($term);
        if (str_contains('parent', $term) || str_contains('guardian', $term)) return 1;
        if (str_contains('teacher', $term) || str_contains('educator', $term) || str_contains('staff', $term)) return 2;
        if (str_contains('management', $term) || str_contains('admin', $term)) return 4;
        if (str_contains('student', $term)) return 5;
        return null;
    }

    private function getRoleLabel($category): string
    {
        return match ((int)$category) {
            1 => 'parent',
            2 => 'teacher',
            4 => 'management',
            5 => 'student',
            default => 'user',
        };
    }
}
