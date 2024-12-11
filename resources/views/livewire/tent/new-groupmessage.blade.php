<div>
    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="sendMessage" class="bg-white p-4 rounded shadow">
        <div class="mb-4">
            <textarea 
                wire:model="message" 
                class="w-full p-2 border rounded" 
                placeholder="Type your message..."
                rows="4"
                maxlength="5000"
            ></textarea>
            @error('message') 
                <span class="text-red-500">{{ $message }}</span> 
            @enderror
        </div>

        <div class="mb-4">
            <input 
                type="file" 
                wire:model="attachments" 
                multiple 
                class="w-full p-2 border rounded"
            />
            @error('attachments.*') 
                <span class="text-red-500">{{ $message }}</span> 
            @enderror
        </div>

        @if($attachments)
            <div class="mb-4">
                <h4 class="font-bold mb-2">Attached Files:</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="relative">
                            <span class="text-sm">
                                {{ $attachment->getClientOriginalName() }}
                            </span>
                            <button 
                                type="button" 
                                wire:click="removeAttachment({{ $index }})"
                                class="text-red-500 ml-2"
                            >
                                Remove
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <button 
            type="submit" 
            class="bg-blue-500 text-white px-4 py-2 rounded"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Send Message</span>
            <span wire:loading>Sending...</span>
        </button>
    </form>
</div>  