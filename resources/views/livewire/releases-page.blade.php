<div>
    <div class="flex items-center justify-between">
        <x-avatar-label :repo="$repo">
            <div class="text-2xl">
                <a href="{{ $repo->github_url }}" target="_blank">{{ $repo->full_name }}</a>
            </div>
            <select wire:model="major" class="form-select py-1 pr-8">
                <option value="">All</option>
                @foreach($repo->majors as $major_version)
                    <option value="{{ $major_version }}">v{{ $major_version }}</option>
                @endforeach
            </select>
        </x-avatar-label>
        <div class="flex items-center gap-2">
            <div class="text-sm text-gray-400">
                {{ $releases->total() }} releases
            </div>
            <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </span>
                <input type="search" wire:model="search" class="py-2 text-sm rounded-md pl-10 focus:outline-none bg-white text-gray-900" placeholder="Search..." autocomplete="off">
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-4 mt-3">
        @foreach($releases as $release)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-2 px-4">
                <div class="flex items-center gap-2 border-b pb-1">
                    <div class="text-xl font-semibold">
                        <a href="{{ $release->github_url }}" target="_blank">{{ $release->tag }}</a>
                    </div>
                    <div class="text-sm text-gray-400" title="{{ $release->published_at }}">Published {{ $release->published_at->diffForHumans() }}</div>
                </div>
                <div class="markdown-body pt-1">
                    {!! $this->parseMarkdown($release->body) !!}
                </div>
            </div>
        @endforeach
        <div>{{ $releases->withQueryString()->links() }}</div>
    </div>
</div>
