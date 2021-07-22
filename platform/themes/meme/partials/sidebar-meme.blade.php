@if (is_plugin_active('meme'))
    @php
        $memes = getMemes(10, false, true, false, 0, null, true);
    @endphp
    @if (!empty($memes) && count($memes) > 0)
        {{-- <div class="sidebar featured-memes d-none d-lg-block"> --}}
        <div class="sidebar featured-memes">
            <div class="row">
                @foreach ($memes as $meme)
                    <div class="col-12 mb-4">
                        <div class="w-100 shadow-sm rounded-1 p-2 mm-box">
                            <a href="{{ $meme->url }}">
                                <img class="img-fluid w-100 mb-3"
                                    {{-- onerror="this.onerror=null;this.src='{{ RvMedia::getDefaultImage() }}';" --}}
                                    src="{{ RvMedia::getImageUrl($meme->image, null, false, RvMedia::getDefaultImage()) }}"
                                    alt="{{ $meme->name }}">
                            </a>
                            <h3 class="h6 text-dark"><a class="text-dark" title="{{ $meme->name }}" href="{{ $meme->url }}">
                                    {{ $meme->name }}</a></h3>
                            @if (!empty($meme->tags) && count($meme->tags) > 0)
                                <div class="meme-meta mb-2">
                                    @foreach ($meme->tags as $tag)
                                        <a title="{{ $tag->name }}"
                                            class="badge badge-secondary badge-pill hover-dark tag"
                                            href="{{ $tag->url }}">
                                            #{{ $tag->name }}
                                        </a>
                                    @endforeach

                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endif
