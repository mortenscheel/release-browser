<?php

namespace App\Http\Controllers;

use App\Models\Repo;

class ReleaseController extends Controller
{
    public function index(string $owner, string $repository)
    {
        $repo = Repo::whereOwner($owner)
            ->whereRepository($repository)
            ->with([
                'releases' => function($query) {
                    $query->orderBy('version', 'desc');
                },
            ])
            ->firstOrFail();

        return view('release.index', compact('repo'));
    }
}
