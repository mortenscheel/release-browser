<?php

namespace App\Actions;

use App\Models\Repo;
use App\Repositories\ReleaseRepository;

class ImportReleases
{
    public function __construct(protected Repo $repo)
    {
    }

    public function execute(): void
    {
        \Log::debug('starting');
        $releases = app(ReleaseRepository::class);
        $response = (new FetchReleases($this->repo))->execute();
        \Log::debug(count($response) . ' releases');
        if (empty($response)) {
            $this->repo->delete();
        } else {
            foreach ($response as $data) {
                $releases->updateOrCreate($this->repo, $data);
            }
        }
    }
}
