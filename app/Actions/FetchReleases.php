<?php

namespace App\Actions;

use App\Models\Repo;
use Github\ResultPager;
use GrahamCampbell\GitHub\GitHubManager;

class FetchReleases
{
    protected GitHubManager $github;
    protected ResultPager $pager;

    public function __construct(
        protected Repo $repo
    ) {
        $this->github = app('github');
        $this->pager = new ResultPager($this->github->connection());
    }

    public function execute(): array
    {
        return $this->pager->fetchAll($this->github->repo()->releases(), 'all', [
            $this->repo->owner,
            $this->repo->repository,
        ]);
    }
}
