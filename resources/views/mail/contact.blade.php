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
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ $message->embed('img/pzu-logo-front.png') }}" alt="Logo">
        </a>
    </div>
</nav>

<div style="margin-top:20px;">
    <h3>Nowa wiadomość</h3>
    <p style="padding-top:20px">{{ $data['content'] }}</p>

    <h3 style="margin-top:20px">Użytkownik</h3>
    <p style="padding-top:20px">
        {{ $data['name'] }} {{ $data['lastname'] }}
    </p>

    <h3 style="margin-top:20px">Użytkownik CAS</h3>
    <p style="padding-top:20px">
        {{ $data['org_name'] }} {{ $data['org_lastname'] }}
    </p>
</div>

</body>
</html>
