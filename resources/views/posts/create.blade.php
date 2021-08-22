<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl">
            <h1 class="text-center font-bold text-xl">New Post!</h1>

            <form method="POST" action="/admin/posts" class="mt-10">

                @csrf

                <div class="mb-6">
                    <label class="block mb-2 font-bold text-xs text-gray-700" for="title">
                        Title
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                           type="text"
                           autofocus
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           required
                    >
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-bold text-xs text-gray-700" for="slug">
                        Slug
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                           type="text"
                           name="slug"
                           id="slug"
                           value="{{ old('slug') }}"
                           required
                    >
                    @error('slug')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-bold text-xs text-gray-700" for="excerpt">
                        Excerpt
                    </label>
                    <textarea name="excerpt" id="excerpt" cols="30" rows="10" spellcheck="false" class="h-16 w-full">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-bold text-xs text-gray-700" for="body">
                        Body
                    </label>
                    <textarea name="body" id="body" cols="30" rows="10" spellcheck="false" class="h-32 w-full">{{ old('body') }}</textarea>
                    @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-bold text-xs text-gray-700" for="category_id">
                        Category
                    </label>

                    <select class="h-10 w-full" name="category_id" id="category_id">
                        <option value="">Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                        Publish
                    </button>
                </div>
            </form>
        </main>
    </section>
</x-layout>
