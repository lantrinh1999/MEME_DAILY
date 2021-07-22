<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="{{ app()->getLocale() }}"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="{{ app()->getLocale() }}"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="{{ app()->getLocale() }}"><![endif]-->
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- gg font -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Roboto')) }}:ital,wght@0,100;0,300;0,500;0,700;0,900;1,500&display=swap"
        rel="stylesheet" type="text/css"> --}}
    <!-- gg font -->

    <style>
        :root {
            --color-1st: @php echo theme_option('primary_color', '#bead8e') @endphp;
            --primary-font: '@php echo theme_option('primary_font', 'Roboto') @endphp', sans-serif;
            --sidebar-color: @php echo theme_option('sidebar_color', '#17a2b8') @endphp;
            --tag-color: @php echo theme_option('tag_color', '#495057') @endphp;
        }

    </style>

    {!! Theme::header() !!}

    <style>
        .s-c-c {
            background-color: var(--sidebar-color) !important;
        }

        .badge.tag {
            background-color: var(--tag-color) !important;
        }

    </style>

    <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--WARNING: Respond.js doesn't work if you view the page via file://-->
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->

</head>
<!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->

<body class="bg-custom">
    {!! apply_filters(THEME_FRONT_BODY, null) !!}
    {{-- {!! Theme::partial('menu-main') !!} --}}
    <nav id="navbar_top" class="navbar shadow-sm navbar-expand-xl navbar-dark bg-info s-c-c">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="/">MEME DAILY</a>
            <button class="navbar-toggler ml-auto pull-bs-canvas-right" type="button">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- <menu></menu> --}}

                @if (true)
                    {!! Menu::renderMenuLocation('menu-main', [
    'options' => ['class' => 'navbar-nav mr-auto'],
    'view' => 'menu-main',
]) !!}
                @endif

                <form action="/" class="form-inline my-2 my-lg-0">
                    <input value="{{ strip_tags(request('s', null)) }}" class="form-control mr-sm-2" name="s"
                        type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
