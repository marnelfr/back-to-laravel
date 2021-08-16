<x-layout>
    @include('_posts-header')
    @if ($posts->count())
        <x-post-grid :posts="$posts"/>
    @else
        <p>No post publish for the moment</p>
    @endif

</x-layout>




{{--
<x-layout>
    @foreach($posts as $post)
        <article>
            <h2>
                <a href="posts/{{ $post->slug }}">
                    {{ $post->title }}
                </a>
            </h2>
            <p>
                By <a href="/authors/{{ $post->author->username }}">{{ $post->author->name }}</a> in <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
            </p>
            <div>
                {!! $post->excerpt !!}
            </div>
        </article>
    @endforeach
</x-layout>
--}}
