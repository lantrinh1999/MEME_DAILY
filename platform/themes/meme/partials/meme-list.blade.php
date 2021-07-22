@if (is_plugin_active('meme'))
    @php
        if (empty($memes)) {
            if(empty($limit) || !is_numeric($limit)) {
                $limit = theme_option('number_of_posts_in_a_category', 20);
            }
            $memes = getMemes($limit, true, true, !empty($tag->id), $tag->id ?? 0, request('s', null));
        }
    @endphp

    @if (!empty(request('s', null)) || !empty($tag->id))
        <div class="row">
            <div class="col-md-12">
                <h1 class="h4 text-danger text-decoration-none font-weight-bolder">
                    @if (!empty(request('s', null)))
                        {{ 'Tìm kiếm từ khoá meme: "' . request('s', null) . '"' }}
                        @php
                            SeoHelper::setTitle("Ảnh chế của " . trim(request('s', null)));
                        @endphp
                    @else
                        @if (!empty($tag->id))
                            {{ 'Chủ đề: ' . ($tag->name ?? '') }}
                        @else

                        @endif
                    @endif
                </h1>
            </div>
        </div>
    @endif

    @if (!empty($memes) && count($memes) > 0)
        <div class="row gallery-wrapper">
            {{-- <!-- Grid sizer --> --}}
            {!! Agent::isDesktop() ? '<div class="grid-sizer col-lg-6 col-md-6"></div> ' : '' !!}
            {{-- <!-- Grid item --> --}}
            @foreach ($memes as $meme)
                <div class="col-lg-6 col-md-6 grid-item mb-4">
                    <div class="w-100 shadow-sm rounded-1 p-2 mm-box">
                        <a class="title text-dark font-weight-bolder" title="{{ $meme->name }}"
                            href="{{ route('public.meme', $meme->slugable->key) }}">
                            <img class="img-fluid w-100 mb-3"
                                {{-- onerror="this.onerror=null;this.src='{{ RvMedia::getDefaultImage() }}';" --}}
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
        <div>
            @if (!empty($memes->hasMorePages()))
                <a class="btn btn-danger btn-block mb-3 text-uppercase font-weight-bolder"
                    href="{{ !empty($memes->nextPageUrl()) ? $memes->withQueryString()->nextPageUrl() : '#' }}">
                    Xem Thêm Các meme khác
                </a>
            @endif
        </div>
    @else
    @php
        $memes = getMemes(15);
    @endphp
        <h4 class="h5 font-weight-bold my-3">Không có meme nào cả!</h4>
        <div class="row gallery-wrapper">
            {{-- <!-- Grid sizer --> --}}
            {!! Agent::isDesktop() ? '<div class="grid-sizer col-lg-6 col-md-6"></div> ' : '' !!}
            {{-- <!-- Grid item --> --}}
            @foreach ($memes as $meme)
                <div class="col-lg-6 col-md-6 grid-item mb-4">
                    <div class="w-100 shadow-sm rounded-1 p-2 mm-box">
                        <a class="title text-dark font-weight-bolder" title="{{ $meme->name }}"
                            href="{{ route('public.meme', $meme->slugable->key) }}">
                            <img class="img-fluid w-100 mb-3"
                                {{-- onerror="this.onerror=null;this.src='{{ RvMedia::getDefaultImage() }}';" --}}
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
@endif
