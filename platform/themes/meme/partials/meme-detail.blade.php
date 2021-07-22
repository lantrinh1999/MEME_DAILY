@if (is_plugin_active('meme'))
    <div class="row">
        <div class="col-md-12">
            <h1 class="h4 text-danger text-decoration-none font-weight-bolder">
                @if (!empty($meme->name))
                    {{ $meme->name }}
                @else

                @endif
            </h1>
        </div>
    </div>
    @if (!empty($meme))
        <style>
            .mx-100 {
                width: auto !important;
                height: auto !important;
                max-width: 100% !important;
            }

        </style>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="w-100 shadow-sm rounded-1 p-2 mm-box">
                    <img class="img-fluid w-100 mx-100 mb-3" {{-- onerror="this.onerror=null;this.src='{{ RvMedia::getDefaultImage() }}';" --}}
                        src="{{ RvMedia::getImageUrl($meme->image, null, false, RvMedia::getDefaultImage()) }}"
                        alt="{{ $meme->name }}">
                    <h2 class="h5 title text-dark">
                        {{ $meme->description }}
                    </h2>
                    @if (!empty($meme->tags) && count($meme->tags) > 0)
                        <div class="meme-meta mb-2">
                            @foreach ($meme->tags as $tag)
                                <a title="{{ $tag->name }}" class="badge badge-secondary badge-pill hover-dark tag"
                                    href="{{ $tag->url }}">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach

                        </div>
                    @endif

                    <div class="meme-content">
                        {!! $meme->content !!}
                    </div>

                </div>
            </div>
        </div>
        <div>
            @php
                $memes = getMemes(10, false, false, false, 0, null, true);
            @endphp
            @if (!empty($memes))
                <h4 class="h5 font-weight-bold my-3">Xem thêm meme</h4>

                <div class="row gallery-wrapper">
                    {{-- <!-- Grid sizer --> --}}
                    {!! Agent::isDesktop() ? '<div class="grid-sizer col-lg-6 col-md-6"></div> ' : '' !!}
                    {{-- <!-- Grid item --> --}}
                    @foreach ($memes as $meme)
                        <div class="col-lg-6 col-md-6 grid-item mb-4">
                            <div class="w-100 shadow-sm rounded-1 p-2 mm-box">
                                <a class="title text-dark font-weight-bolder" title="{{ $meme->name }}"
                                    href="{{ route('public.meme', $meme->slugable->key) }}">
                                    <img class="img-fluid w-100 mb-3" {{-- onerror="this.onerror=null;this.src='{{ RvMedia::getDefaultImage() }}';" --}}
                                        src="{{ RvMedia::getImageUrl($meme->image, null, false, RvMedia::getDefaultImage()) }}"
                                        alt="{{ $meme->name }}">
                                </a>

                                <h3 class="h5">
                                    <a class="title text-dark font-weight-bolder" title="{{ $meme->name }}"
                                        href="{{ route('public.meme', $meme->slugable->key) }}">{{ $meme->name }}</a>
                                </h3>
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
            @endif
        </div>
    @endif
@endif
