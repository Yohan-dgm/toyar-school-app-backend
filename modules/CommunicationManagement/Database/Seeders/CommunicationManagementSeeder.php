<?php

namespace Modules\CommunicationManagement\Database\Seeders;

use Illuminate\Database\Seeder;

class CommunicationManagementSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            NotificationTypeSeeder::class,
            SampleNotificationSeeder::class,
            AnnouncementCategorySeeder::class,
        ]);
    }
}
