<?php

namespace Modules\CommunicationManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CommunicationManagement\Models\AnnouncementCategory;

class AnnouncementCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = AnnouncementCategory::getDefaultCategories();

        foreach ($categories as $index => $category) {
            AnnouncementCategory::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'description' => $this->getDescription($category['slug']),
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'created_by' => 1,
                ]
            );
        }
    }

    private function getDescription(string $slug): string
    {
        return match ($slug) {
            'general' => 'General school announcements and notices',
            'academic' => 'Academic-related announcements including exams, assignments, and curriculum updates',
            'events' => 'School events, activities, and special programs',
            'emergency' => 'Emergency notices and urgent communications',
            'administrative' => 'Administrative updates, policy changes, and official notices',
            'sports' => 'Sports activities, competitions, and athletic events',
            'health-safety' => 'Health guidelines, safety protocols, and wellness information',
            'admissions' => 'Admission procedures, deadlines, and enrollment information',
            default => 'Category description'
        };
    }
}
