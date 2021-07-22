<ul {!! clean($options) !!} data-id="menu-main">
    @foreach ($menu_nodes as $key => $row)
        <li class="menu-item nav-item {{ $row->css_class }} @if ($row->active) active @endif">
                <a class="nav-link" href="{{ $row->url }}" target="{{ $row->target }}">
                    @if ($row->icon_font)
                        <i class='{{ trim($row->icon_font) }}'></i>
                    @endif
                    {!! $row->title !!}
                </a>
        </li>
    @endforeach
</ul>
