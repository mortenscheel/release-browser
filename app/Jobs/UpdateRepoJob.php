<?php

namespace App\Jobs;

use App\Actions\UpdateRepo;
use App\Models\Repo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRepoJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Repo $repo)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UpdateRepo::make($this->repo)->execute();
    }
}
