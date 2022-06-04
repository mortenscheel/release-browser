<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <a href="{{ route('repo.index') }}">Home</a> <span class="text-gray-400">></span>
        {{ $repo->full_name }}
    </h2>
</x-slot>

<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-session-errors class="mb-4" />
        <div class="flex items-center justify-between">
            <x-avatar-label :repo="$repo">
                <div class="text-2xl">
                    <a href="{{ $repo->github_url }}" target="_blank">{{ $repo->full_name }}</a>
                </div>
                @if($repo->majors->count() > 1)
                    <div class="flex items-center gap-2">
                        @foreach($repo->majors as $major)
                            <a class="px-2 bg-gray-300 font-semibold rounded-full"
                               href="{{ route('release.index', [
                                'owner' => $repo->owner,
                                'name' => $repo->name,
                                'from' => $major->oldest,
                                'to' => $major->newest,
                                'search' => $search
                            ]) }}">
                                {{ $major->label }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </x-avatar-label>
            <div class="flex items-center gap-2">
                <div class="text-sm text-gray-400">
                    {{ $releases->total() }} releases
                </div>
                <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
              <svg wire:loading.remove fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
                <svg wire:loading class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
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
                        <div class="text-sm text-gray-400" title="{{ $release->published_at }}">
                            Published {{ $release->published_at->diffForHumans() }}</div>
                    </div>
                    <div class="markdown-body pt-1">
                        {!! $this->parseMarkdown($release->body) !!}
                    </div>
                </div>
            @endforeach
            @if($releases->isEmpty())
                No matching releases found
            @endif
            <div>{{ $releases->withQueryString()->links() }}</div>
        </div>
    </div>
</div>
