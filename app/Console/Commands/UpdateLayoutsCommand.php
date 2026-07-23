<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateLayoutsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:layouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all blade files in the circular-economy directory to use the new layout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = resource_path('views/opportunities/circular-economy');
        $this->updateLayoutsInDirectory($directory);
        
        $this->info('All layouts updated successfully!');
    }
    
    /**
     * Update layouts in a directory and its subdirectories
     *
     * @param string $directory
     * @return void
     */
    protected function updateLayoutsInDirectory($directory)
    {
        $files = File::allFiles($directory);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $this->updateLayoutInFile($file->getPathname());
            }
        }
    }
    
    /**
     * Update layout in a single file
     *
     * @param string $filePath
     * @return void
     */
    protected function updateLayoutInFile($filePath)
    {
        $content = File::get($filePath);
        
        // Skip files that don't use the old layout
        if (!str_contains($content, '@extends(\'opportunities.circular-economy.layouts.app\')')) {
            return;
        }
        
        $updatedContent = str_replace(
            '@extends(\'opportunities.circular-economy.layouts.app\')',
            '@extends(\'opportunities.layouts.app\')',
            $content
        );
        
        File::put($filePath, $updatedContent);
        
        $this->line("Updated layout in: " . $filePath);
    }
}
