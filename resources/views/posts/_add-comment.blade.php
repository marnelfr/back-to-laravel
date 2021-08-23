@auth
    <x-panel>
        <form method="POST" action="/posts/{{ $post->slug }}/comment">
            @csrf

            <header class="flex items-center">
                <img src="https://i.pravatar.cc/60?u={{ auth()->id() }}" alt="" width="40" height="40"
                     class="rounded-xl rounded-full">

                <h2 class="ml-4">Want to participate?</h2>
            </header>

            <div class="mt-6">
                <textarea class="w-full text-sm focus:outline-none focus:ring"
                          name="body" cols="30"
                          rows="5"

                          placeholder="Quick, thing of something to say!"></textarea>
                @error('body')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                <x-form.button>Submit</x-form.button>
            </div>
        </form>
    </x-panel>
@else
    <a class="text-blue-500 hover:underline" href="/register">Register</a> or <a class="text-blue-500 hover:underline"
                                                                                 href="/login">Log
        in</a> to leave a comment.
@endauth
