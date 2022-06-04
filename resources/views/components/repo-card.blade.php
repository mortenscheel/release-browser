@php
    /** @var \App\Models\Repo $repo */
@endphp
<div class="bg-white overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-200 sm:rounded-lg py-2 px-4">
    <a href="{{ route('release.index', ['owner' => $repo->owner, 'name' => $repo->name]) }}">
        <div class="flex items-center justify-between">
            <x-avatar-label :repo="$repo">
                <span class="text-xl">{{ $repo->full_name }}</span>
            </x-avatar-label>
            <div class="flex items-center">
                <div class="text-yellow-400">
                    <svg stroke="currentColor" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                        <path d="M8 .2l4.9 15.2L0 6h16L3.1 15.4z"/>
                    </svg>
                </div>
                <div class="text-sm text-gray-600 ml-1">{{ number_format($repo->stars) }}</div>
            </div>
        </div>
        <div class="mt-2 text-gray-800">
            <div>{{ $repo->description ?? 'No description' }}</div>
        </div>
        <div class="mt-2 text-gray-600 text-sm flex items-center justify-between">
            <div>
                Latest release: {{ $repo->latestRelease->tag }}
                <span title="{{ $repo->latestRelease->published_at }}">({{ $repo->latestRelease->published_at->diffForHumans() }})</span>
            </div>
            <div>{{ $repo->releases_count }} releases</div>
            <div>
                Created <span title="{{ $repo->published_at }}">{{ $repo->published_at->diffForHumans() }}</span>
            </div>
        </div>
    </a>
</div>
