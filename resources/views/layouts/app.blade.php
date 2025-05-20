<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Liga Mistrzów BSR') }}</title>
</head>

<body class="img fullheight">
    <div id="app" style="width:100%">
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
