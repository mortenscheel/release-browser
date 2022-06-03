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
        \File::ensureDirectoryExists($this->repo->getStoragePath());
        \File::put(
            $this->repo->getStoragePath('repo.json'),
            json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR)
        );
        $repos->update($this->repo, $data);
    }
}
