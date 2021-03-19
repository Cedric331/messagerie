@extends('layouts.app')
   
@section('content')
   @auth
      <home :channels={{ $channels }}></home>
   @endauth

   @guest
   <div class="view" style="background-image: url('http://mdbootstrap.com/img/Photos/Others/images/91.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
      <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
        <div class="container">
          <div class="row mt-5">

            <div class="col-md-6 mb-5 mt-md-0 mt-5 text-white text-center text-md-left">
              <h1 class="h1 font-weight-bold">Bienvenue sur Talk! </h1>
              <hr class="hr-light">
              <h6 class="mb-3">
                 Ici vous pouvez discuter via une messagerie instantanée avec vos amis sur des divers sujets et si vous ne trouvez pas le sujet qui vous intéresse, vous pouvez le créer.
              </h6>
            </div>
            <div class="col-md-6 col-xl-5 mb-4">
              <!--Form-->
              <div class="card">
               <form method="POST" action="{{ route('register') }}">
                  @csrf
                <div class="card-body">
                  <!--Header-->
                  <div class="text-center">
                    <h3 class="white-text font-weight-bold">{{ __('Register') }}</h3>
                    <hr class="hr-light">
                  </div>
                  <!--Body-->
                  <div class="md-form">
                    <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div>
                  
                  <div class="md-form">
                     <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                         @error('email')
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                  </div>

                  <div class="md-form">
                     <label for="password" class="col-md-5 col-form-label text-md-left">{{ __('Password') }}</label>
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                         @error('password')
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                  </div>

                  <div class="md-form">
                     <label for="password-confirm" class="col-md-5 col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>


                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn-rounded btn-primary">
                     {{ __('Register') }}
                 </button>
                    <hr class="hr-light mb-3 mt-4">
                    <div class="inline-ul text-center d-flex justify-content-center">
                      <a class="p-2 m-2">
                        <p>Déjà inscrit ?</p>
                      </a>
                      <a class="p-2 m-2">
                        <p>Mot de passe oublié ?</p>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   @endguest
@endsection

