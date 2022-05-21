<?php

namespace App\Jobs;

use App\Actions\UpdateRepo;
use App\Models\Repo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddRepoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected string $owner, protected string $repository)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Repo::whereOwner($this->owner)->whereRepository($this->repository)->doesntExist()) {
            $repo = Repo::create([
                'owner'      => $this->owner,
                'repository' => $this->repository,
            ]);
            (new UpdateRepo($repo))->execute();
        }
    }
}
