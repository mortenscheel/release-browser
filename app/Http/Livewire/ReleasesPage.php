<?php

namespace App\Http\Livewire;

use App\Models\Release;
use App\Models\Repo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Livewire\Component;
use Livewire\WithPagination;

class ReleasesPage extends Component
{
    use WithPagination;
    public Repo $repo;
    public string $search = '';
    public string $major = '';

    public function render()
    {
        if ($this->search === '') {
            $query = $this->repo->releases()->when($this->major, function (Builder $query) {
                $query->where('major', $this->major);
            });
        } else {
            $query = Release::search($this->search)->where('repo_id', $this->repo->id)->when($this->major, function (\Laravel\Scout\Builder $scout) {
                $scout->query(function ($query) {
                    $query->where('major', $this->major);
                });
            });
        }
        $releases = $query->orderBy('published_at', 'desc')->paginate(5);
        return view('livewire.releases-page', compact('releases'));
    }

    public function mount(Request $request)
    {
        $this->major = $request->get('major', '');
        $this->search = $request->get('search', '');
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
            $html = preg_replace_callback("/$pattern/i", function (array $match) {
               return sprintf('<mark>%s</mark>', $match[0]);
            }, $html);
        }
        return $html;
    }
}
