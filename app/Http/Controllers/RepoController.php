<?php

namespace App\Http\Controllers;

use App\Models\Repo;

class RepoController extends Controller
{
    public function index()
    {
        $repos = Repo::orderBy('owner')->orderBy('repository')->get()->mapToGroups(function(Repo $repo) {
            return [$repo->owner => $repo];
        });

        return view('repo.index', compact('repos'));
    }

    public function owner(string $owner)
    {
        $repos = Repo::whereOwner($owner)->orderBy('repository')->get();

        return view('repo.owner', compact('repos', 'owner'));
    }
}
