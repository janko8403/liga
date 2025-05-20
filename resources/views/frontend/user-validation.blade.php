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

<div class="container">
    <div class="row">
        <div class="card-results">
        <form method="post" action="/api/frontend/confirm"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="token" value="{{ request()->userToken }}">
            <div class="row">
                <div class="col-md-6">
                    <img class="pt-5 pb-4 avatar-profile" src="/img/avatar.png">
                    <p class="mt-5 pt-3 pb-5">
                        <span class="btn-pzu btn-pzu_blue-border cursor-pointer" onclick="selectFile()">dodaj zdjęcie profilowe</span>
                    </p>
                    <span id="file-name" class="mb-5"></span>
                    @error('avatar')
                    <div class="p-4" style="color:red;">
                        <div class="error">{{ $message }}</div>
                    </span>
                    @enderror
                    <input type="file" name="avatar" class="custom-file-input" id="importFile" style="visibility: hidden">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="floating-label">
                        <span class="floating-input">{{ $user->name }}</span>
                        <span class="highlight"></span>
                        <label>Imię</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="floating-label">
                        <span class="floating-input">{{ $user->lastname }}</span>
                        <span class="highlight"></span>
                        <label>Nazwisko</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="floating-label">
                        <span class="floating-input">{{ $user->email }}</span>
                        <span class="highlight"></span>
                        <label>E-mail</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="floating-label">
                        <span class="floating-input">{{ $user->mobile }}</span>
                        <span class="highlight"></span>
                        <label>Telefon</label>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md-6">
                    <label class="checkboxcontainer"> Oświadczam, że zapoznałem się z Regulaminem i Polityką "Liga Mistrzów" i akceptuję ich postanowienia.
                        <input type="checkbox" name="rodoConsent" {{ old('rodoConsent') == 'on' ? 'checked' : '' }}>
                        <span class="checkmark checkmark_active"></span>
                    </label>
                    @error('rodoConsent')
                    <div class="p-4" style="color:red;">
                        <div class="error">{{ $message }}</div>
                    </span>
                    @enderror
                    <button type="submit" class="btn-pzu btn-pzu_blue mt-5">DOKOŃCZ REJESTRACJĘ</button>

                    <p class="pt-5">Jeżeli masz jakieś pytania skontaktuj się ze swoim koordynatorem lub napisz na adres <a href="mailto:mampytanie@ligamistorzowbsr.pl">mampytanie@ligamistorzowbsr.pl</a></p>
                </>
            </div>
            </div>
        </form>
        </div>
    </div>
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
<script>
    const actualBtn = document.getElementById('importFile');
    const fileChosen = document.getElementById('file-name');

    actualBtn.addEventListener('change', function(){
        fileChosen.textContent = 'Wybrano '+this.files[0].name
    })
    function selectFile() {
        document.getElementById("importFile").click()
    }

</script>
<style>.footer {padding:50px 0 30px;height:100px; position:relative;} body {margin-bottom:0px;} </style>
</body>
</html>
