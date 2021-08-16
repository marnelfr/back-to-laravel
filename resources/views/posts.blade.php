<x-layout>
    @include('_posts-header')
    @if ($posts->count())
        <x-post-grid :posts="$posts"/>
    @else
        <p>No post publish for the moment</p>
    @endif
</x-layout>

