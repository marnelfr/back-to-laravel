@props(['author'])
<a href="/?author={{ $author->username }}">
    {{ $author->name }}
</a>
