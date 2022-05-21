<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Home
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            @foreach($repos as $owner => $owner_repos)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-1 px-2">
                    <x-avatar-label :repo="$owner_repos[0]">
                        <a class="text-2xl font-semibold" href="{{ route('repo.owner', ['owner' => $owner_repos[0]->owner]) }}">{{ $owner_repos[0]->owner }}</a>
                    </x-avatar-label>
                @foreach($owner_repos as $owner_repo)
                        <x-repo-link :repo="$owner_repo" />
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
