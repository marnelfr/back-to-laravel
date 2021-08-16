<x-layout>
    @include('_posts-header')
    @if ($posts->count())
        <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
            <x-post-featured-card :post="$posts->first()"/>

            @if ($posts->count() > 1)
                <div class="lg:grid lg:grid-cols-6">
                    @foreach($posts->skip(1) as $post)
                        <x-post-card :post="$post" class="{{ $loop->iteration > 2 ? 'col-span-2' : 'col-span-3' }}" />
                    @endforeach
                </div>
            @endif
        </main>
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
