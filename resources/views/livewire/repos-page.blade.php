<div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div>Order by</div>
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" class="form-radio" wire:model="order" value="stars">
                <span class="ml-1">Stars</span>
            </label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" class="form-radio" wire:model="order" value="name">
                <span class="ml-1">Name</span>
            </label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" class="form-radio" wire:model="order" value="age">
                <span class="ml-1">Age</span>
            </label>
        </div>
        <div class="flex items-center gap-2">
            <div class="text-sm text-gray-400">
                {{ $repos->total() }} repos
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
    <div class="flex flex-col gap-4 mt-4">
        @foreach($repos as $repo)
            <x-repo-card :repo="$repo" />
        @endforeach
    </div>
    <div>{{ $repos->withQueryString()->links() }}</div>
</div>
