<x-layout>
    @foreach($posts as $post)
        <article>
            <h4>
                <a href="posts/{{ $post->id }}">
                    {{ $post->title }}
                </a>
            </h4>
            <div>
                {!! $post->body !!}
            </div>
        </article>
    @endforeach
</x-layout>
