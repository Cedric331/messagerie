@extends('layouts.app')

@section('content')
@auth
<home :channels="{{ $channels }}" :notifications="{{ Auth::user()->notifications }}"></home>
@endauth

@guest
<div class="view">
    <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row mt-5">

                <div class="col-md-6 mb-5 mt-md-0 mt-5 text-white text-center text-md-left">
                    <h1 class="h1 font-weight-bold">Bienvenue sur Talk! </h1>
                    <hr class="hr-light">
                    <h6 class="mb-3">
                        Ici vous pouvez discuter via une messagerie instantanée avec vos amis sur des divers sujets et
                        si vous ne trouvez pas le sujet qui vous intéresse, vous pouvez le créer.
                    </h6>
                </div>
                <div class="col-md-6 col-xl-5 mb-4">
                    <div class="card">
                        <ul class="card-header nav nav-tabs nav-justified">
                            <li class="nav-item active">
                                <a class="text-primary" data-toggle="tab" href="#register">
                                    <h3>{{ __('Register') }}</h3>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="text-primary" data-toggle="tab" href="#login">
                                    <h3>{{ __('Login') }}</h3>
                                </a>
                            </li>
                        </ul>

                        <div class="card-body tab-content">

                            <div id="login" class="tab-pane fade">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email1"
                                            class="col-md-6 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                                        <div class="col-12">
                                            <input id="email1" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password1"
                                            class="col-md-6 col-form-label text-md-left">{{ __('Password') }}</label>

                                        <div class="col-12">
                                            <input id="password1" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @if (Route::has('password.request'))
                                <hr class="hr-light mb-3 mt-4">
                                <div class="inline-ul text-center d-flex justify-content-center">

                                    <a class="p-2">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié ?') }}
                                        </a>

                                    </a>
                                </div>
                                @endif
                            </div>

                            <form id="register" class="tab-pane fade active show" method="POST"
                                action="{{ route('register') }}">
                                @csrf
                                <div class="md-form">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>
                                    <input dusk='name' id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="md-form">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="md-form">
                                    <label for="password"
                                        class="col-md-5 col-form-label text-md-left">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="md-form">
                                    <label for="password-confirm"
                                        class="col-md-8 col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>


                                <div class="text-center mt-4">
                                    <button type="submit" id="register" class="btn btn-rounded btn-primary">
                                        S'inscrire
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest
    @endsection
