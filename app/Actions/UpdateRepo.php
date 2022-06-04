<?php

namespace App\Actions;

use App\Models\Repo;
use App\Repositories\RepoRepository;

class UpdateRepo
{
    public function __construct(private Repo $repo)
    {
    }

    public function execute(): void
    {
        $repos = app(RepoRepository::class);
        $data = (new FetchRepo($this->repo->owner, $this->repo->name))->execute();
        $repos->update($this->repo, $data);
    }
}
