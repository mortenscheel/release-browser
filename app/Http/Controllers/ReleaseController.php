<?php

namespace App\Http\Controllers;

use App\Models\Release;
use App\Repositories\RepoRepository;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;

class ReleaseController extends Controller
{
    public function __construct(
        protected RepoRepository $repos,
    ) {
    }

    public function index(Request $request, string $owner, string $name)
    {
        $repo = $this->repos->find($owner, $name);
        if ($search = $request->get('search')) {
            $query = Release::search($search)->where('repo_id', $repo->id);
        } else {
            $query = $repo->releases();
        }
        $releases = $query->orderBy('version', 'desc')->paginate(5);

        return view('release.index', compact('repo', 'releases'));
    }
}
