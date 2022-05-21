@php
    /** @var \App\Models\Repo $repo */
@endphp
<div {{ $attributes->class('flex items-center gap-2') }}>
    <img class="w-8 h-8" src="{{ $repo->owner_avatar_url }}" alt="">
    {{ $slot }}
</div>
