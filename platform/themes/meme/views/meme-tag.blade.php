@if (!empty($tag))
    {!! Theme::partial('meme-list', compact('tag')) !!}
@else
    {!! Theme::partial('meme-list') !!}
@endif
