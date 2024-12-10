<form wire:submit.prevent="subscribe" class="bg-gray-900 opacity-75 w-full shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
    <div class="mb-4">
        <label class="block text-blue-300 py-2 font-bold mb-2" for="emailaddress">
            Enter your email to stay in the loop
        </label>
        <input wire:model="email"
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
            id="emailaddress" type="text" placeholder="you@somewhere.com" />
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between pt-4">
        <button
            class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
            type="submit">
            Join Now
        </button>
    </div>
</form>
