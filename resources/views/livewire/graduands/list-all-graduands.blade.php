<div class="p-4">
    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live.debounce.1000ms="search"
            class="border p-2 w-full rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
            placeholder="Search by name or email...">
    </div>

    <!-- Graduand List -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @forelse ($graduands as $graduand)
            <div
                class="w-full max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-end px-4 pt-4">
                    <!-- Dropdown menu can go here if needed -->
                </div>
                <div class="flex flex-col items-center pb-6">
                    <img class="w-20 h-20 mb-3 rounded-full shadow-lg" src="{{ $graduand->profile_photo_url }}"
                        alt="Profile image" />
                    <h5 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">{{ $graduand->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Visual Designer</span>
                    <div class="flex mt-4 md:mt-6">
                        <a href="#"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                            friend</a>
                        <a href="javascript:void(0)" wire:click.prevent="createChat({{ $graduand->id }})"
                            class="py-2 px-3 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Message</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center mt-4 text-gray-600 dark:text-gray-400">No graduands found.</p>
        @endforelse
    </div>

    @if (!$graduands->isEmpty())
        {{ $graduands->links() }}
    @endif
</div>
