<?php

namespace App\Console\Commands;

use App\Jobs\AddRepoJob;
use App\Models\Repo;
use Illuminate\Console\Command;

class AddRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (preg_match('@^(\w+)/(\w+)$@', $name, $match)) {
            [$_, $owner, $repository] = $match;
            if (Repo::whereOwner($owner)->whereRepository($repository)->exists()) {
                $this->error("$name already exists");

                return self::FAILURE;
            }
            $this->info("Job dispatched");
            AddRepoJob::dispatch($owner, $repository);
        }

        return 0;
    }
}
