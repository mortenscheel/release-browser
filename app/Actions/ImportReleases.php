<?php

namespace App\Actions;

use App\Models\Repo;
use App\Repositories\ReleaseRepository;
use Log;

class ImportReleases
{
    public function __construct(protected Repo $repo)
    {
    }

    public function execute(): void
    {
        Log::info('Import releases started', ['repo' => $this->repo->full_name]);
        $releases = app(ReleaseRepository::class);
        $response = (new FetchReleases($this->repo))->execute();
        foreach ($response as $data) {
            $releases->updateOrCreate($this->repo, $data);
        }
        if ($this->repo->releases()->doesntExist()) {
            $this->repo->delete();
        }
        Log::info('Import releases ended', ['repo' => $this->repo->full_name]);
    }
}
