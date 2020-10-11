@extends('theme.layout.base')

@section('content')
    <div class="col-md-8" id="left">
        <!-- meme -->
        @if(!empty($memes))
            @foreach($memes as $meme)
                <div class="meme rounded shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-7">
                            <div class="img p-2">
                                <a href="/"  title="{{ $meme['title'] }}">
                                    @if(!empty($meme['meme_meta']['_pik']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_pik'] }} " alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_imgur']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_imgur'] }} " alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_image']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_image'] }} " alt="{{ $meme['title'] }}">
                                    @else
                                        <img class="w-100" src="{{ $meme['image'] }} " alt="{{ $meme['title'] }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 fixed_scroll">
                            <div class="content-meme p-2 px-lg-2">
                                <div class="title">
                                    <a class="text-dark text-decoration-none" href="/"
                                       title="{{ $meme['title'] }}">{{ $meme['title'] }}</a>
                                </div>
                                <div class="tag">
                                    @if(!empty($meme['tags'] && count($meme['tags']) > 0))
                                        @foreach($meme['tags'] as $tag)


                                            <a href="/" title="{{$tag['name']}}">#{{$tag['name']}}</a>
                                        @endforeach
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- meme -->
            @endforeach
        @endif

        <div class="next mb-3 mb-lg-0">
            <a class="btn btn-danger btn-block" href="{{route('theme.home', $nextPage)}}">Xem tiếp</a>
        </div>

    </div>
@endsection
