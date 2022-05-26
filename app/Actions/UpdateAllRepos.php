<?php

namespace App\Actions;

use App\Models\Repo;

class UpdateAllRepos
{
    public function execute(): void
    {
        Repo::all()->each(function (Repo $repo) {
            (new ImportReleases($repo))->execute();
        });
    }
}
