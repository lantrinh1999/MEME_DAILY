@if (is_plugin_active('meme'))
    @php
        $tags = getHotTag(20);
    @endphp
    @if (!empty($tags) && count($tags) > 0)
        <div class="sidebar sidebar-tag p-2 pt-0 rounded bg-white shadow-sm mb-4">
            <h5 class="h5">TAG HOT</h5>
            <div class="tags clearfix">
                @foreach ($tags as $tag)
                    <a class="tag mb-2 badge badge-secondary badge-pill hover-dark"
                        href="{{ $tag->url }}" title="{{ $tag->name }}">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endif
