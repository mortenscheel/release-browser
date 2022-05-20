<?php

namespace App\Actions;

use App\Models\Release;
use App\Models\Repo;
use Composer\Semver\VersionParser;

class UpdateRepo
{
    public function __construct(protected Repo $repo)
    {
    }

    public function execute(): void
    {
        $data = (new FetchReleases($this->repo))->execute();
        $repo = Repo::with('releases')->firstOrCreate([
            'owner'      => 'GrahamCampbell',
            'repository' => 'Laravel-Github',
        ]);
        $releases = collect($data)->map(function(array $release) use ($repo) {
            $version = (new VersionParser())->normalize(\Arr::get($release, 'tag_name'));
            if (\Arr::get($release, 'draft') || $repo->releases->where('version', $version)->isNotEmpty()) {
                return null;
            }
            $body = preg_replace('/\r\n/', '\n', \Arr::get($release, 'body'));

            return new Release(compact('version', 'body'));
        })->filter()->values();
        if ($releases->isNotEmpty()) {
            $repo->releases()->saveMany($releases);
        }
    }
}
