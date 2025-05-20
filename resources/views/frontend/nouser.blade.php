<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/frontend_app.css') }}" rel="stylesheet"></link>
    <title>Liga Mistrzów BSR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>
<style>
    .footer {
        position: fixed;
        height: 200px;
        bottom: 0px;
        left: 0px;
        right: 0px;
        margin-bottom: 0px;
    }
    body {
        margin-bottom:200px;
    }

</style>
<body style="min-height:100%">

<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/img/pzu-logo-front.png">
        </a>
    </div>
</nav>

<div class="container pt-5 pb-5">
    <h1>Brak uprawnień do aplikacji.</h1>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p>© PZU 2022. Wszelkie prawa zastrzeżone</p>
            </div>
            <div class="col-md-8">
                <ul class="mt-4 mt-md-0">
                    <li>
                        <a href="">Grupa PZU</a>
                    </li>
                    <li>
                        <a href="/polityka-prywatnosci">Polityka prywatności</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
