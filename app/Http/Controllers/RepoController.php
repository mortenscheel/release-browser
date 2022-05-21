<?php

namespace App\Http\Controllers;

use App\Models\Repo;
use App\Repositories\RepoRepository;

class RepoController extends Controller
{
    public function __construct(protected RepoRepository $repos)
    {
    }

    public function index()
    {
        return view('repo.index')->with('repos', $this->repos->all()->mapToGroups(function(Repo $repo) {
            return [$repo->owner => $repo];
        }));
    }

    public function owner(string $owner)
    {
        return view('repo.owner')->with([
            'owner' => $owner,
            'repos' => $this->repos->byOwner($owner),
        ]);
    }
}
