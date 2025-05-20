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
<body>
    <div id="menu_app"></div>
    <main>
        <div id="frontend_app"></div>
    </main>

    <footer>
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

    <div class="modal fade" id="kontakt" tabindex="-1" aria-labelledby="kontaktLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-end">
                    <button type="button" class="btn-close-pzu" data-bs-dismiss="modal" aria-label="Close">i</button>
                </div>
                <div class="modal-body">
                    <div class="title">Formularz kontaktowy</div>
                    <p class="justify-content-center">Jeśli masz pytania związane z platformą grywalizacyjną albo dostępnymi na niej aktywnościami zapraszamy do kontaktowania się z nami!</p>
                    <p>
                        Na każdą wiadomość odpowiemy w możliwie najszybszym czasie!
                    </p>
                    <form method="post" action="/api/frontend/contact">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <input class="floating-input" name="name" type="text" placeholder=" ">
                                    <span class="highlight"></span>
                                    <label>Imię</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <input class="floating-input" name="lastname" type="text" placeholder=" ">
                                    <span class="highlight"></span>
                                    <label>Nazwisko</label>
                                </div>
                            </div>
                            <!--<div class="col-md-12">
                                <div class="floating-label">
                                    <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                                        <option value=""></option>
                                        <option value="1">Alabama</option>
                                        <option value="2">Boston</option>
                                        <option value="3">Ohaio</option>
                                        <option value="4">New York</option>
                                        <option value="5">Washington</option>
                                    </select>
                                    <span class="highlight"></span>
                                    <label>Wybierz temat</label>
                                </div>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col">
                                <textarea name="message"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <button type="button" class="btn-pzu btn-pzu_blue-border" data-bs-dismiss="modal">ANULUJ</button>
                                <button type="submit" class="btn-pzu btn-pzu_blue">WYŚLIJ</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/frontend_app.js') }}"></script>
</body>
</html>
