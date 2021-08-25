<x-layout>
    <x-nav-bar />

    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl">
            <h1 class="text-center font-bold text-xl">New Post!</h1>

            <form method="POST" action="/admin/posts" class="mt-10" enctype="multipart/form-data">

                @csrf

                <x-form.input name="title" />
                <x-form.input name="slug" />
                <x-form.textarea name="excerpt" />
                <x-form.textarea name="body" />

                <x-form.input name="thumbnail" type="file" />

                <x-form.field>
                    <x-form.label name="category" />
                    <select class="h-10 w-full" name="category_id" id="category_id">
                        <option value="">Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-form.error name="category"/>
                </x-form.field>

                <x-form.button>Publish</x-form.button>
            </form>
        </main>
    </section>
</x-layout>
