<?php

namespace App\Console\Commands;

use App\Jobs\ImportReleasesJob;
use App\Jobs\UpdateRepoJob;
use App\Models\Repo;
use Illuminate\Console\Command;

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
    public function handle(): int
    {
        Repo::all()->each(function(Repo $repo) {
            \Bus::chain([
                new UpdateRepoJob($repo),
                new ImportReleasesJob($repo)
            ])->dispatch();
        });
        return 0;
    }
}
