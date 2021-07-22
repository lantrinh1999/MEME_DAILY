@if (!empty($menu_nodes) && count($menu_nodes) > 0)
    <p {!! clean($options) !!}>
        @foreach ($menu_nodes->values() as $key => $row)
            <a {{ $row->css_class }} class="text-light @if ($row->active) active @endif" target="{{ $row->target }}" href="{{ $row->url }}">
                {!! $row->title !!}
            </a>
            @if ($key < count($menu_nodes) - 1)
                |
            @endif
        @endforeach
    </p>
@endif
