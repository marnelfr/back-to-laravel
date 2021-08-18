<x-layout>
    @include('posts._header')
    @if ($posts->count())
        <x-post-grid :posts="$posts"/>
    @else
        <div class="text-center mt-5">
            <p>No post publish for the moment {{ isset($currentCategory) ? 'in this category' : '' }}</p>
        </div>
    @endif
    @if (session()->has('success'))
        <x-flash :message="session('success')" />
    @endif
</x-layout>

