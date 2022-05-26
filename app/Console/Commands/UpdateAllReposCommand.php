<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\UpdateAllRepos;

class UpdateAllReposCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:update-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update releases for all repos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new UpdateAllRepos)->execute();
        return 0;
    }
}
