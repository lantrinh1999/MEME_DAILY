@extends('theme.layout.base')

@section('title')

    @if(!empty($memes) && !empty($tag))
        <title> {{ $tag['name'] }} - Ảnh chế {{ $tag['name'] }} - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt
            Nam</title>
        <meta property="og:title"
              content="{{ $tag['name'] }} - Ảnh chế {{ $tag['name'] }} - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt Nam"/>
    @elseif(!empty($memes) && empty($tag))
        <title>Memedaily - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt Nam</title>
        <meta property="og:title" content="Memedaily - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt Nam"/>
    @else
    @endif
@endsection
@section('keywords')

    @if(!empty($memes) && !empty($tag))
        {{-- tag --}}
        <meta name="keywords" itemprop="keywords" content="meme thịnh hành, ảnh chế, ảnh hài hước, comment dạo facebook, top comment facebook, {{ $tag['name'] }}"/>
    @elseif(!empty($memes) && empty($tag))
        {{-- home --}}
        <meta name="keywords" itemprop="keywords" content="meme thịnh hành, ảnh chế, ảnh hài hước, comment dạo facebook, top comment facebook"/>
    @else
    @endif
@endsection

@section('og:image')

    @if(!empty($memes) && !empty($tag))
        <meta property="og:image" content="{{$memes[0]['image']}}"/>
    @elseif(!empty($memes) && empty($tag))
        <meta property="og:image" content="{{url('/anhche-memes-haynhat-comment-dao-hot-nhat-cong-dong-mang-xa-hoi-viet-nam.png')}}"/>
    @else
    @endif
@endsection

@section('meta')

    @if($nextPage !== false)
        @if(!empty($memes) && !empty($tag))
            <link rel="next" href="{{ route('theme.tag', ['slug' => $tag['slug'] ,'page' => $nextPage]) }}">
        @elseif(!empty($memes) && empty($tag))
            <link rel="next" href="{{ route( 'theme.home', $nextPage) }}">
        @else
        @endif
    @endif
@endsection

@section('content')
    <div class="col-md-8" id="left">
        <!-- meme -->
        @if(!empty($tag))

            <div class="is-tag pb-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <a class="text-danger text-decoration-none text-bold"
                           href="{{ route( 'theme.tag' , [ 'slug' => $tag['slug'] ] ) }}">
                            <h1 style=""> {{ $tag['name'] }} </h1>
                        </a>
                    </div>
                    @if(!empty($tag['content']))
                        <div class="col-md-12">
                            <div class="py-1">

                                {{$tag['content']}}

                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- tag -->

        @endif
        @if(!empty($memes))
            @foreach($memes as $meme)
                <div class="meme rounded shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-7">
                            <div class="img p-2">
                                <a href="{{ route('theme.meme', $meme['slug']) }}" title="{{ $meme['title'] }}">
                                    @if(!empty($meme['meme_meta']['_pik']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_pik'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_imgur']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_imgur'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_image']))
                                        <img class="w-100" src="{{ $meme['meme_meta']['_image'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @else
                                        <img class="w-100" src="{{ $meme['image'] }} " alt="{{ $meme['title'] }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 fixed_scroll">
                            <div class="content-meme p-2 px-lg-2">
                                <div class="title">
                                    <a class="text-dark text-decoration-none" href="{{ route('theme.meme', $meme['slug']) }}"
                                       title="{{ $meme['title'] }}">{{ $meme['title'] }}</a>
                                </div>
                                <div class="tag">
                                    @if(!empty($meme['tags'] && count($meme['tags']) > 0))
                                        @foreach($meme['tags'] as $tag_)


                                            <a href="{{ route('theme.tag', $tag_['slug']) }}" title="{{$tag_['name']}}">#{{$tag_['name']}}</a>
                                        @endforeach
                                        @php
                                            $tag_ = false;
                                        @endphp

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
            @if($nextPage !== false)
                @if(!empty($memes) && !empty($tag))
                    <a class="btn btn-danger btn-block"
                       href="{{ route('theme.tag', ['slug' => $tag['slug'] ,'page' => $nextPage]) }}">Xem tiếp</a>
                @elseif(!empty($memes) && empty($tag))
                    <a class="btn btn-danger btn-block" href="{{ route( 'theme.home', $nextPage) }}">Xem tiếp</a>
                @else

                @endif
            @endif

        </div>

    </div>
@endsection
