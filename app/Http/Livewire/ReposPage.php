<?php

namespace App\Http\Livewire;

use App\Models\Repo;
use Livewire\Component;

class ReposPage extends Component
{
    public string $search = '';
    public string $order = 'stars';

    public function render()
    {
        if ($this->search === '') {
            $query = Repo::query()->whereHas('latestRelease')->withCount('releases');
        } else {
            $query = Repo::search($this->search)->query(fn($query) => $query->withCount('releases'));
        }
        $repos = $query
            ->when($this->order === 'name', fn($query) => $query->orderBy('full_name'))
            ->when($this->order === 'stars', fn($query) => $query->orderBy('stars', 'desc'))
            ->when($this->order === 'age', fn($query) => $query->orderBy('published_at'))
            ->paginate(10);
        return view('livewire.repos-page', compact('repos'));
    }
}
