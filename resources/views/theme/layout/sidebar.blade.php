<div class="col-md-4" id="sidebar">
    <div class="wrap sidebar__inner">
        <div class="sidebar p-2 pt-0 rounded bg-white shadow-sm">
            <h5>Tag HOT</h5>
            <div class="tags clearfix">
                @if($tagHot || count($tagHot) > 0)
                    @foreach($tagHot as $tag)
                        <a class="hashtag mb-2" href="{{route('theme.tag', $tag->slug)}}" title="{{$tag->name}}">
                        <span class="float-left pr-3 pb-1">#{{$tag->name}}</span>
                        </a>

                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
