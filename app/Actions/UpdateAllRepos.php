<?php

namespace App\Actions;

use App\Models\Repo;

class UpdateAllRepos
{
    public function execute(): void
    {
        Repo::all()->each(function (Repo $repo) {
            (new UpdateRepo($repo))->execute();
            (new ImportReleases($repo))->execute();
        });
    }
}
