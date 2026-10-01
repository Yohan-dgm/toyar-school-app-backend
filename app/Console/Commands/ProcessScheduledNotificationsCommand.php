<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\CommunicationManagement\Services\NotificationService;

class ProcessScheduledNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:process-scheduled 
                           {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled notifications that are ready to be sent';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService): int
    {
        $isDryRun = $this->option('dry-run');

        $this->info('Processing scheduled notifications...');
        
        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No notifications will be sent');
        }

        try {
            if (!$isDryRun) {
                $processed = $notificationService->processScheduledNotifications();
                
                if ($processed > 0) {
                    $this->info("✅ Successfully processed {$processed} scheduled notifications");
                } else {
                    $this->info("📬 No scheduled notifications ready to be sent");
                }
            } else {
                // In dry run, just count what would be processed
                $readyNotifications = \Modules\CommunicationManagement\Models\Notification::readyToSend()->count();
                $this->info("📋 Dry run completed - would process {$readyNotifications} notifications");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Failed to process scheduled notifications: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}