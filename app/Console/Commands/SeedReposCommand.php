<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedReposCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import repos from DEFAULT_REPOS';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repos = config('repos.default');
        if (empty($repos)) {
            $this->warn('No repos found in DEFAULT_REPOS');
            return self::FAILURE;
        }
        \Artisan::call('repo:add', ['names' => $repos], $this->getOutput());
        return self::SUCCESS;
    }
}
