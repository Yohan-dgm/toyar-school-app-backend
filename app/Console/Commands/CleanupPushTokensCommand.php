<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\CommunicationManagement\Services\ExpoPushNotificationService;

class CleanupPushTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push-tokens:cleanup 
                           {--dry-run : Run without making changes}
                           {--days=30 : Number of days to consider as stale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up invalid and stale push tokens';

    /**
     * Execute the console command.
     */
    public function handle(ExpoPushNotificationService $pushService): int
    {
        $isDryRun = $this->option('dry-run');
        $staleDays = (int) $this->option('days');

        $this->info('Starting push tokens cleanup...');
        
        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        try {
            // Get stats before cleanup
            $statsBefore = $pushService->getPushStats();
            $this->displayStats('Before cleanup:', $statsBefore);

            if (!$isDryRun) {
                // Perform cleanup
                $result = $pushService->cleanupTokens();
                
                // Get stats after cleanup
                $statsAfter = $pushService->getPushStats();
                $this->displayStats('After cleanup:', $statsAfter);
                
                $this->info("✅ Cleanup completed successfully");
                $this->info("📊 Tokens cleaned: {$result['cleaned_tokens']}");
            } else {
                $this->info("📋 Dry run completed - would clean {$statsBefore['tokens_exceeding_threshold']} tokens");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Cleanup failed: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    /**
     * Display push token statistics
     */
    private function displayStats(string $title, array $stats): void
    {
        $this->line('');
        $this->info($title);
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Tokens', $stats['total_tokens']],
                ['Active Tokens', $stats['active_tokens']],
                ['Inactive Tokens', $stats['inactive_tokens']],
                ['iOS Tokens', $stats['platform_distribution']['ios']],
                ['Android Tokens', $stats['platform_distribution']['android']],
                ['Tokens with Failures', $stats['tokens_with_failures']],
                ['Tokens Exceeding Threshold', $stats['tokens_exceeding_threshold']],
                ['Health Percentage', $stats['health_percentage'] . '%'],
            ]
        );
    }
}