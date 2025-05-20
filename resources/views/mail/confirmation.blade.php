<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liga Mistrzów BSR</title>
</head>
<style>
    body {
        margin-bottom:200px;
    }
</style>
<body style="min-height:100%">
<div style="margin-left:auto;margin-right:auto;max-width:80%">
    <table style="width:100%">
        <tr>
            <td style="width:50%;margin-right:auto" align="left">
                <img src="{{ $message->embed('img/pzu-logo-front.png') }}"  style="padding:20px;" alt="Logo">
            </td>
            <td style="width:50%;margin-left:auto" align="right">
                <h1 style="color:#234678">Dokończ rejestrację!</h1>
            </td>
        </tr>
    </table>
    <img src="{{ $message->embed('img/mail-header.jpeg') }}" style="padding:20px;width:100%" alt="Logo">
</div>

<div style="margin-left:auto;margin-right:auto;max-width:80%;margin-top:40px">
    <p>Twoja przygoda z grywalizacją właśnie się rozpoczyna! Jesteś o krok od dołączenia do społeczności grywalizacyjnej Liga Mistrzów!</p>
        Żeby Twoje konto było aktywne, dokończ rejestrację klikając przycisk DALEJ.
    <p style="margin-top:20px;">
        Widzimy się w Lidze Mistrzów i życzymy owocnego grywalizowania!
    </p>
    <p>
        <a class="btn btn-primary" href="{{env('APP_URL')}}/confirm/{{ $mailData['verification_token'] }}">DALEJ</a>
    </p>
</div>
</body>
</html>
<style>
a:link { text-decoration: none; }
a:visited { text-decoration: none; }
a:hover { text-decoration: none; }
a:active { text-decoration: none; }
.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
</style>
