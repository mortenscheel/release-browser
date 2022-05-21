@php
    /** @var \App\Models\Repo $repo */
@endphp
<div class="flex items-center gap-2">
    <a href="{{ route('release.index', [$repo->owner, $repo->name]) }}">{{ $repo->full_name }}</a>
    <span class="text-sm text-gray-400">{{ $repo->releases_count }} releases. Latest: {{ $repo->latestRelease->version }}</span>
</div>
