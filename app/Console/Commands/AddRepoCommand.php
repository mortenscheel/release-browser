<?php

namespace App\Console\Commands;

use App\Jobs\AddRepoJob;
use App\Jobs\ImportReleasesJob;
use App\Models\Repo;
use Illuminate\Console\Command;

class AddRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:add {names*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a name';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $names = $this->argument('names');
        foreach ($names as $full_name) {
            if (preg_match('@^(.+)/(.+)$@', $full_name, $match)) {
                [$_, $owner, $name] = $match;

                if (Repo::whereOwner($owner)->whereName($name)->exists()) {
                    $this->error("$name already exists");

                    return self::FAILURE;
                }
                $this->info("Import job dispatched for $owner/$name");
                \Bus::chain([
                    new AddRepoJob($owner, $name),
                    new ImportReleasesJob($owner, $name),
                ])->dispatch();
            }
        }

        return 0;
    }
}
