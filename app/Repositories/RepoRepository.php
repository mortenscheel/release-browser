<?php

namespace App\Repositories;

use App\Models\Repo;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RepoRepository
{
    /**
     * @return Collection<int, Repo>
     */
    public function all(): Collection
    {
        return \Cache::tags(['repos'])->rememberForever('all', function () {
           return Repo::with('latestRelease')->withCount('releases')->orderBy('owner')->orderBy('stars', 'desc')->get();
        });
    }

    /**
     * @param string $owner
     * @return Collection<int, Repo>
     */
    public function byOwner(string $owner): Collection
    {
        return $this->all()->filter(fn(Repo $repo) => $repo->owner === $owner);
    }

    public function find(string $owner, string $name = null): ?Repo
    {
        if ($name) {
            return $this->all()->where('owner', $owner)->where('name', $name)->first();
        }
        return $this->all()->where('full_name', $owner)->first();
    }

    public function create(array $data): ?Repo
    {
        $params = $this->transformRepoData($data);
        if (Repo::whereOwner($params['owner'])->whereName($params['name'])->exists()) {
            return null;
        }
        \Cache::tags(['repos'])->flush();
        return Repo::create($params);
    }

    public function update(Repo $repo, array $data): Repo
    {
        \Cache::tags(['repos', $repo->owner, $repo->full_name])->flush();
        return tap($repo, function (Repo $repo) use ($data) {
            $repo->update($this->transformRepoData($data));
        });
    }

    private function transformRepoData(array $data): array
    {
        return [
            'owner'            => Arr::get($data, 'owner.login'),
            'name'             => Arr::get($data, 'name'),
            'full_name'        => Arr::get($data, 'full_name'),
            'github_url'       => Arr::get($data, 'html_url'),
            'published_at'     => Carbon::parse(Arr::get($data, 'created_at')),
            'description'      => Arr::get($data, 'description'),
            'homepage_url'     => Arr::get($data, 'homepage'),
            'language'         => Arr::get($data, 'language'),
            'owner_avatar_url' => Arr::get($data, 'organization.avatar_url', Arr::get($data, 'owner.avatar_url')),
            'stars'            => Arr::get($data, 'stargazers_count'),
        ];
    }
}
