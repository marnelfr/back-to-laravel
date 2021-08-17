<x-layout>
    @include('_posts-header')
    @if ($posts->count())
        <x-post-grid :posts="$posts"/>
    @else
        <div class="text-center mt-5">
            <p>No post publish for the moment</p>
        </div>
    @endif
</x-layout>

