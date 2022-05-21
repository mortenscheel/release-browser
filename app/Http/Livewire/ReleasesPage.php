<?php

namespace App\Http\Livewire;

use App\Models\Release;
use App\Models\Repo;
use Illuminate\Mail\Markdown;
use Livewire\Component;
use Livewire\WithPagination;

class ReleasesPage extends Component
{
    use WithPagination;
    public Repo $repo;
    public string $search = '';

    public function render()
    {
        if ($this->search === '') {
            $query = $this->repo->releases();
        } else {
            $query = Release::search($this->search)->where('repo_id', $this->repo->id);
        }
        $releases = $query->orderBy('published_at', 'desc')->paginate(5);
        return view('livewire.releases-page', compact('releases'));
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
