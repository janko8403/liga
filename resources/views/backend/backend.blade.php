<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/backend_app.css') }}" rel="stylesheet"></link>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liga Mistrzów BSR</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <script>let FF_CSS_FLASH_FIX;</script>
</head>
<body>
<div class="header-container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <img src="/img/pzu-logo.svg" style="width:35px;margin-right:30px">
        <span class="ml-3 pl-3">Liga Mistrzów BSR</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-1">
                <li class="nav-item">
                </li>
            </ul>
            <div class="d-flex px-5">
                <small>
                    <span class="px-2">Sesja</span>
                    <span id="logout_app"></span>
                </small>
            </div>
            <form class="d-flex">
                <i class="fa-regular fa-bell"></i>
            </form>
        </div>
    </div>
</nav>
</div>
<div class="main-c">
    <nav class="main-menu">
    <ul>
        <li>
            <a href="/backend/aktywnosci">
                <i class="fa fa-solid fa-cubes fa-2x"></i>
                <span class="nav-text">
                    Aktywności
                </span>
            </a>
        </li>
        <li class="has-subnav">
            <a href="/backend/pojedynki">
                <i class="fa fa-solid fa-people-arrows fa-2x"></i>
                <span class="nav-text">
                    Pojedynki
                </span>
            </a>
        </li>
        <li>
            <a href="/backend/agenci">
                <i class="fa fa-solid fa-users fa-2x" style="position:relative">
                    @if($userUpdate>0)
                    <span class="position-absolute top-50 start-50 translate-middle badge rounded-pill bg-danger">{{ $userUpdate }}</span>
                    @endif
                </i>
                <span class="nav-text">
                    Agenci
                </span>
            </a>
        </li>
        <li class="has-subnav">
            <a href="/backend/cms">
                <i class="fa fa-solid fa-display fa-2x"></i>
                <span class="nav-text">
                    CMS
                </span>
            </a>
        </li>
        <li class="has-subnav">
            <a href="/backend/powiadomienia">
                <i class="fa fa-gears fa-2x"></i>
                <span class="nav-text">
                    Ustawienia
                </span>
            </a>
        </li>
        <li class="has-subnav">
            <a href="/backend/admins">
                <i class="fa fa-user fa-2x"></i>
                <span class="nav-text">
                    Administratorzy
                </span>
            </a>
        </li>
    </ul>

    <ul class="logout">
        <li>
            <a href="/logout">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">
                    Wyjście
                </span>
            </a>
        </li>
    </ul>
</nav>
</div>
<section class="main-container mb-5">
    <div id="backend_app"></div>
    <script src="{{ asset('js/backend_app.js') }}"></script>
</section>
</body>
</html>
