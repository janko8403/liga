@extends('layouts.app')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section"></h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-wrap p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center">
                    <img src="/img/pzu-logo.svg" style="width:100px">
                </div>
                <h3 class="text-center mb-4">Liga Mistrzów BSR</h3>
                <form action="#" method="POST" action="{{ route('backend.login') }}" class="login-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="email" class="form-control rounded-left" placeholder="Login" required>
                    </div>
                    <div class="form-group d-flex">
                        <input type="password" name="password" class="form-control rounded-left" placeholder="Hasło" required>
                    </div>

                    <!--
                    @if (Route::has('password.request'))
                    <div class="form-group d-md-flex">
                        <div class="w-100 text-md-right">

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Przypomnij hasło') }}
                        </a>
                        </div>
                    </div>
                    @endif
                    -->
            <div class="form-group">
                        <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Rozpocznij</button>
                    </div>
                </form>
            </div>
        </div>
        <!--
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
