<?php

namespace App\Console\Commands;

use App\Actions\AddRepo;
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
                $this->task($full_name, function () use ($match){
                    [$_, $owner, $name] = $match;
                    $repo = (new AddRepo($owner, $name))->execute();
                    if ($repo) {
                        ImportReleasesJob::dispatch($repo);
                        return true;
                    }

                    return false;
                });
            }
        }

        return 0;
    }
}
