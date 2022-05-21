<?php

namespace App\Repositories;

use App\Models\Release;
use App\Models\Repo;
use Cache;
use Carbon\Carbon;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ReleaseRepository
{
    /**
     * @param \App\Models\Repo $repo
     * @return \Illuminate\Database\Eloquent\Collection<Release>
     */
    public function all(Repo $repo): Collection
    {
        return Cache::tags([$repo->full_name])->rememberForever('all', function () use ($repo) {
           return $repo->releases()->orderBy('version', 'desc')->get();
        });
    }

    public function create(Repo $repo, array $data): ?Release
    {
        $params = $this->transformReleaseData($data);
        if ($params !== null) {
            Cache::tags([$repo->owner])->flush();
            $release = new Release($params);
            $repo->releases()->save($release);
            return $release;
        }
        return null;
    }

    public function update(Repo $repo, array $data): ?Release
    {
        $params = $this->transformReleaseData($data);
        if (!$params) {
            return null;
        }
        $release = $this->all($repo)->firstWhere('version', $params['version']);
        if ($release) {
            Cache::tags([$repo->full_name])->flush();
            $release->update($params);
            return $release;
        }
        return null;
    }

    public function updateOrCreate(Repo $repo, array $data): ?Release
    {
        if ($updated = $this->update($repo, $data)) {
            return $updated;
        }
        return $this->create($repo, $data);
    }

    private function transformReleaseData(array $data): array|null
    {
        if (Arr::get($data, 'draft') || Arr::get($data, 'body') === null) {
            return null;
        }
        $tag = Arr::get($data, 'tag_name');
        if (!$tag) {
            \Log::warning('No tag', $data);
        }
        $version = (new VersionParser())->normalize($tag);
        $body = Arr::get($data, 'body');
        $github_url = Arr::get($data, 'html_url');
        $published_at = Carbon::parse(Arr::get($data, 'published_at'));
        return compact('version', 'tag', 'body', 'github_url', 'published_at');
    }
}
