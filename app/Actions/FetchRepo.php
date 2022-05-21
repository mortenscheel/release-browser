<?php

namespace App\Actions;

use App\Models\Repo;
use Github\ResultPager;
use GrahamCampbell\GitHub\GitHubManager;

class FetchRepo
{
    protected GitHubManager $github;
    protected ResultPager $pager;

    public function __construct(
        protected string $owner,
        protected string $name
    ) {
        $this->github = app('github');
        $this->pager = new ResultPager($this->github->connection());
    }

    public function execute(): array
    {
        return $this->github->repos()->show($this->owner, $this->name);
    }
}
