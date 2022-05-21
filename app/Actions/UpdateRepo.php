<?php

namespace App\Actions;

use App\Models\Release;
use App\Models\Repo;
use Arr;
use Composer\Semver\VersionParser;

class UpdateRepo
{
    public function __construct(protected Repo $repo)
    {
    }

    public function execute(): void
    {
        $data = (new FetchReleases($this->repo))->execute();
        $releases = collect($data)->map(function(array $release) {
            $version = (new VersionParser())->normalize(Arr::get($release, 'tag_name'));
            $body = Arr::get($release, 'body');
            if (Arr::get($release, 'draft') || $this->repo->releases->where('version', $version)->isNotEmpty()) {
                return null;
            }

            return new Release(compact('version', 'body'));
        })->filter()->values();
        if ($releases->isNotEmpty()) {
            $this->repo->releases()->saveMany($releases);
        }
    }
}
