<x-layout>
    <x-nav-bar />

    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl">
            <h1 class="text-center font-bold text-xl">Edit Post!</h1>

            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <x-form.input name="title" :value="$post->title" />
                <x-form.input name="slug" :value="$post->slug" />
                <x-form.textarea name="excerpt" :value="$post->excerpt" />
                <x-form.textarea name="body" :value="$post->body" />
                <div class="flex mt-6">
                    <div class="flex-1">
                        <x-form.input :require="false" name="thumbnail" type="file" />
                    </div>

                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="" class="rounded-xl ml-6" width="100">
                </div>
                <x-form.field>
                    <x-form.label name="category" />
                    <select name="category_id" id="category_id" class="w-full h-8">
                        @foreach($categories as $category)
                            <option @if($category->is($post->category)) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-form.error name="category"/>
                </x-form.field>
                <x-form.button>Edit</x-form.button>
            </form>
        </main>
    </section>
</x-layout>
