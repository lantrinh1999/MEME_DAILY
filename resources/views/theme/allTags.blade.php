@extends('theme.layout.base')

@section('content')
    <div class="col-md-8" id="left">
        <div class="meme rounded shadow-sm">
            <div class="tags clearfix py-3 pl-2 ">
                @if(!empty($tags))
                    @foreach($tags as $tag)
                        <span class="float-left pr-3 pb-2"><a class="hashtag" href="{{route('theme.tag', ['slug' => $tag['slug']])}}" title="123">#{{ $tag['name'] }} </a></span>
                    @endforeach
                @endif

            </div>
        </div>
        <!-- meme -->
    </div>
@endsection
