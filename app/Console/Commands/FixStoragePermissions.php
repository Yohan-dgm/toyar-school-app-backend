<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixStoragePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix-permissions {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage directory permissions for file uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // Define directories that need proper permissions
        $directories = [
            'storage/app/public',
            'storage/app/public/nexis-college',
            'storage/app/public/nexis-college/profile_images',
            'storage/logs',
            'storage/framework',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
        ];

        $this->info('Checking and fixing storage permissions...');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        foreach ($directories as $dir) {
            $fullPath = base_path($dir);

            $this->line("Checking: {$dir}");

            // Check if directory exists
            if (! is_dir($fullPath)) {
                $this->info("  Directory does not exist, creating: {$fullPath}");

                if (! $dryRun) {
                    if (! mkdir($fullPath, 0755, true)) {
                        $this->error("  Failed to create directory: {$fullPath}");

                        continue;
                    }
                }
                $this->info('  ✓ Directory created');
            }

            // Check current permissions
            if (is_dir($fullPath)) {
                $currentPerms = substr(sprintf('%o', fileperms($fullPath)), -4);
                $isWritable = is_writable($fullPath);

                $this->line("  Current permissions: {$currentPerms}, Writable: ".($isWritable ? 'Yes' : 'No'));

                if (! $isWritable || $currentPerms !== '0755') {
                    $this->info('  Setting permissions to 0755');

                    if (! $dryRun) {
                        if (chmod($fullPath, 0755)) {
                            clearstatcache();
                            $newPerms = substr(sprintf('%o', fileperms($fullPath)), -4);
                            $newWritable = is_writable($fullPath);
                            $this->info("  ✓ Permissions updated: {$newPerms}, Writable: ".($newWritable ? 'Yes' : 'No'));
                        } else {
                            $this->error("  Failed to set permissions for: {$fullPath}");
                        }
                    }
                } else {
                    $this->info('  ✓ Permissions are correct');
                }
            }
        }

        // Also check the public storage symlink
        $symlinkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        $this->line("Checking storage symlink: {$symlinkPath}");

        if (! is_link($symlinkPath)) {
            $this->info('  Storage symlink does not exist, creating...');

            if (! $dryRun) {
                if (symlink($targetPath, $symlinkPath)) {
                    $this->info('  ✓ Storage symlink created');
                } else {
                    $this->error('  Failed to create storage symlink');
                    $this->info('  You may need to run: php artisan storage:link');
                }
            }
        } else {
            $this->info('  ✓ Storage symlink exists');
        }

        $this->info('');
        $this->info('Storage permissions check completed!');

        if ($dryRun) {
            $this->info('Run without --dry-run to apply changes.');
        } else {
            $this->info('If you still have permission issues, you may need to run this command with sudo:');
            $this->info('sudo php artisan storage:fix-permissions');
        }
    }
}
