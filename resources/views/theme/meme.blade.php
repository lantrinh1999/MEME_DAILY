@extends('theme.layout.base')

@section('title')

    <title> {{ $meme['title'] }}  - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt
        Nam</title>
    <meta property="og:title"
          content="{{ $meme['title'] }} - Tổng hợp ảnh chế, memes hay nhất mạng xã hội Việt Nam"/>


@endsection
@section('keywords')

    <meta name="keywords" itemprop="keywords"
          content="meme thịnh hành, ảnh chế, ảnh hài hước, comment dạo facebook, top comment facebook, {{ @$tags[0]['name'] }}"/>

@endsection

@section('og:image')

    <meta property="og:image" content="{{$meme['image']}}"/>
@endsection

@section('meta')


@endsection

@section('content')
    <div class="col-md-8" id="left">
        <!-- meme -->

        @if(!empty($meme))

                <div class="meme rounded shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <div class="title p-2">
                                <a class="text-dark text-decoration-none"
                                   href="{{ route('theme.meme', $meme['slug']) }}"
                                   title="{{ $meme['title'] }}"><h1>{{ $meme['title'] }}</h1></a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="img p-2">
                                <a href="{{ route('theme.meme', $meme['slug']) }}" title="{{ $meme['title'] }}">
                                    @if(!empty($meme['meme_meta']['_pik']))
                                        <img class="mw-100" src="{{ $meme['meme_meta']['_pik'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_imgur']))
                                        <img class="mw-100" src="{{ $meme['meme_meta']['_imgur'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @elseif(!empty($meme['meme_meta']['_image']))
                                        <img class="mw-100" src="{{ $meme['meme_meta']['_image'] }} "
                                             alt="{{ $meme['title'] }}">
                                    @else
                                        <img class="mw-100" src="{{ $meme['image'] }} " alt="{{ $meme['title'] }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="content-meme p-2 px-lg-2">
                                <div class="content">

                                    @if($meme['content'])
                                            {!! $meme['content'] !!}
                                    @endif

                                </div>
                                <div class="tag">
                                    Xem thêm:
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

        @endif


    </div>
@endsection
