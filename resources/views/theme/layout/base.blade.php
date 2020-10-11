<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Meme</title>
    <link href="{{ mix('/theme/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="{{ mix('/theme/js/scripts.js') }}" defer></script>
</head>

<body class="bg-custom">
@include('theme.layout.header')
<section class="main py-3">
    <div class="container">
        <div class="row row_has_sidebar">
            @yield('content')
            @include('theme.layout.sidebar')
        </div>
    </div>
</section>
@include('theme.layout.footer')
{{--<script type="text/javascript" src="./assets/theme/js/scripts.js"></script>--}}
</body>

</html>
