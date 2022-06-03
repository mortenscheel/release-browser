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
        $releases = app(ReleaseRepository::class);
        $response = (new FetchReleases($this->repo))->execute();
        if (empty($response)) {
            $this->repo->delete();
        } else {
            \File::ensureDirectoryExists($this->repo->getStoragePath('/releases'));
            foreach ($response as $data) {
                $releases->updateOrCreate($this->repo, $data);
                \File::put(
                    $this->repo->getStoragePath(sprintf('/releases/%d.json', $data['id'])),
                    json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR)
                );
            }
        }
    }
}
