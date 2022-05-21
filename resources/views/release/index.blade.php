<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('repo.index') }}">Home</a> <span class="text-gray-400">></span>
            {{ $repo->full_name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('releases-page', compact('repo'))
        </div>
    </div>
</x-app-layout>
