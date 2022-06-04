<?php

namespace App\Http\Livewire;

use App\Models\Release;
use App\Models\Repo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property-read boolean $has_version_constraint
 */
class ReleasesPage extends Component
{
    use WithPagination;

    public Repo $repo;
    public string $search = '';
    public string $from = '';
    public string $to = '';

    public function render()
    {
        $constraints = function(Builder $query) {
            $query->when($this->from, function(Builder $query) {
                $query->constrainVersion($this->from, $this->to);
            });
        };
        if ($this->search === '') {
            $query = $this->repo->releases()->where($constraints);
        } else {
            $query = Release::search($this->search)->where('repo_id', $this->repo->id)->query($constraints);
        }
        $releases = $query->orderBy('numeric_version', 'desc')->paginate(5);

        return view('livewire.releases-page', compact('releases'));
    }

    public function mount(Request $request, string $owner, string $name, string $from = '', string $to = '')
    {
        $this->search = $request->get('search', '');
        try {
            $this->repo = Repo::whereOwner($owner)->whereName($name)->firstOrFail();
        } catch (\Exception $e) {
            session()->flash('error', "Unknown repository: $owner/$name");
            $this->redirect(url()->previous('/'));
        }
        if ($from) {
            try {
                \Str::normalizeVersion($from);
                $this->from = $from;
            } catch (\Exception) {
                session()->flash('error', "Invalid version: $from");
                $this->redirect(url()->previous('/'));
            }
        }
        if ($to) {
            try {
                \Str::normalizeVersion($to);
                $this->to = $to;
            } catch (\Exception) {
                session()->flash('error', "Invalid version $to");
                $this->redirect(url()->previous('/'));
            }
        }
    }

    public function parseMarkdown(string $markdown)
    {
        $html = Markdown::parse($markdown);
        if (!trim($html)) {
            return '<span class="text-sm text-gray-600">No release notes</span>';
        }
        if ($this->search !== '') {
            // Highlight matches with <mark>
            $pattern = preg_quote($this->search, '/');
            $html = preg_replace_callback("/$pattern/i", function(array $match) {
                return sprintf('<mark>%s</mark>', $match[0]);
            }, $html);
        }

        return $html;
    }

    public function getHasVersionConstraintProperty()
    {
        return $this->from !== '';
    }
}
