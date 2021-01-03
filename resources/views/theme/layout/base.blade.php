<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="google-site-verification" content="0UYbiRDCWN2rv66wNrJskD7XA9X2K_WGx8bWnYUgp7s" />
    <meta name="robots" content="index,follow" />
    <meta name="dc.language" content="VI">
    <meta name="dc.source" content="//www.memedaily.vn/">
    <meta name="dc.creator" content="MEMEDAILY" />
    <meta name="distribution" content="Global" />
    <meta name="revisit" content="1 days" />
    <meta name="geo.placename" content="Vietnamese" />
    <meta name="geo.region" content="Vietnamese" />
    <meta name="generator" content="//www.memedaily.vn" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    @yield('title')
    @yield('keywords')
    <meta name="description" content="Kho ảnh chế, memes, trào lưu hot và đầy đủ nhất mạng xã hội Việt Nam" />
    <meta property="og:description" content="Kho ảnh chế, memes, trào lưu hot và đầy đủ nhất mạng xã hội Việt Nam" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="object" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Meme Daily" />
    @yield('og:image')
    @yield('meta')
    <link rel="canonical" href="{{ url()->current() }}">
    <link href="{{ mix('/theme/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="{{ mix('/theme/js/scripts.js') }}" defer></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script data-ad-client="ca-pub-4818872934671576" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>

</head>

<body class="bg-custom h-100">
    <amp-auto-ads type="adsense"
        data-ad-client="ca-pub-4818872934671576">
</amp-auto-ads>
    @include('theme.layout.header')
    <section class="main py-3 h-100 mb-auto">
        <div class="container">
            <div class="row row_has_sidebar">
                @yield('content')
                @include('theme.layout.sidebar')
            </div>
        </div>
    </section>
    @include('theme.layout.footer')
    {{--<script type="text/javascript" src="./assets/theme/js/scripts.js"></script>--}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NLWXYQ63G8"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-NLWXYQ63G8');
    </script>
</body>

</html>