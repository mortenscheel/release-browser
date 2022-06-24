<?php

namespace App\Console\Commands;

use App\Actions\ImportReleases;
use App\Actions\UpdateRepo;
use App\Jobs\ImportReleasesJob;
use App\Models\Repo;
use Illuminate\Console\Command;
use App\Actions\UpdateAllRepos;

class UpdateRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:update {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update repo with releases';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repo = Repo::whereFullName($this->argument('name'))->firstOrFail();
        // $this->task('Updating repository', fn() => (new UpdateRepo($repo))->execute());
        // $this->task('Updating releases', fn() => (new ImportReleases($repo))->execute());
        ImportReleasesJob::dispatch($repo);
        return 0;
    }
}
