<div class="p-4 bg-gray-100 dark:bg-gray-800 min-h-screen" wire:poll>
    <div class="text-center">
        <div class="grid grid-cols-2">
            <div>
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $myTent->name }}</h4>
                    <h5 class="text-sm text-gray-600 dark:text-gray-300">{{ $myTent->description }}</h5>
                </div>
            </div>
            <div>
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example"
                    aria-controls="drawer-example">
                    Show Members
                </button>
            </div>
        </div>

        <div>
            {{-- @livewire('tent.new-groupmessage') --}}
        </div>

        <div class="container mx-auto p-4">
            @if (!$myTent)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                    role="alert">
                    You are not a member of any group.
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg">
                    {{-- Group Header --}}
                    <div class="bg-blue-500 text-white p-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">{{ $myTent->name }} Group Chat</h2>
                        <div class="text-sm">
                            Members: {{ $members->count() }}
                        </div>
                    </div>

                    {{-- Messages Container --}}
                    <div class="p-4 max-h-[600px] overflow-y-auto">
                        @forelse($groupMessages as $message)
                            <div id="disqus_thread"></div>

                        @empty
                            <div class="text-center text-gray-500 py-4">
                                No messages yet. Start the conversation!
                            </div>
                        @endforelse
                    </div>


                </div>
            @endif
        </div>

    </div>

    <!-- drawer component -->
    <div id="drawer-example"
        class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-label">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg
                class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>Members</h5>
        <button type="button" data-drawer-hide="drawer-example" aria-controls="drawer-example"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
            All members of this chat are listed here
        </p>
        <div class="grid grid-cols-2 gap-4">
            <ul class="space-y-2">
                @foreach ($members as $member)
                    <li class="text-gray-700 dark:text-gray-300">{{ $member->user?->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('23b0be8d71c9361887a3', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('private-group-{ $myTent->id }');
        channel.bind('new-group-message', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
@endpush
</div>
