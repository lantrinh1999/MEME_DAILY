<!DOCTYPE html>
<html class="h-full bg-gray-200">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">

    <link href="{{ mix('/admin/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

    {{-- Inertia --}}
    <script
        src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign"
        defer></script>

    {{-- Ping CRM --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>
    @routes
    <script src="{{ mix('/admin/js/app.js') }}" defer></script>
    <script src="{{ mix('/admin/js/scripts.js') }}" defer></script>
    <style>
            html, body {
            font-family: 'Roboto' !important;
        }

        .nav-icon {
            font-size: 15px !important
        }


    </style>

</head>
<body>

<main class="sidebar-mini layout-fixed control-sidebar-slide-open text-md">
    @inertia
{{--    {!! ssr('/admin/js/app-server.js')->render() !!}--}}
</main>

</body>
</html>
