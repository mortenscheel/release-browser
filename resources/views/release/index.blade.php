<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('repo.index') }}">Home</a> <span class="text-gray-400">></span>
            <a href="{{ route('repo.owner', ['owner' => $repo->owner]) }}">{{ ucfirst($repo->owner) }}</a>
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-avatar-label :repo="$repo">
                <div class="text-2xl">{{ $repo->full_name }}</div>
            </x-avatar-label>
            <div class="flex flex-col gap-4 mt-3">
                @foreach($releases as $release)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-2 px-4">
                        <div class="flex items-center gap-2 border-b pb-1">
                            <div class="text-xl font-semibold">{{ $release->version }}</div>
                            <div class="font-sm text-gray-400">{{ $release->published_at }}</div>
                        </div>
                        <div class="markdown-body pt-1">
                            {{ \Illuminate\Mail\Markdown::parse($release->body) }}
                        </div>
                    </div>
                @endforeach
                <div>{{ $releases->withQueryString()->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>
