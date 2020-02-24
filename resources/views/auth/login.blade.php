@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
        <form method="POST" action="{{ route('login') }}">
                                @csrf
                <h1 class="h3 font-weight-normal line-decorator mb-4 text-center" style="width: auto; color: #979898;">Iniciar Sesión</h1>
                <div class="form-group row">

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control text-center @error('email') is-invalid @enderror" name="email" style="font-size: 12px;" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Correo Electónico">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control text-center @error('password') is-invalid @enderror" style="font-size: 12px;" name="password" autocomplete="current-password" placeholder="Contraseña">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row text-center">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label text-secondary" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row text-center">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link text-success" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
                
            </form>
            <hr />
            <div class="row justify-content-center mb-3">
                <div class="col-12 text-center">
                <a style="font-size: 13px;" class="text-success" href="{{route('register')}}">¿Aún no tienes cuenta?</a>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Footer -->
                <div class="col-12">
                    <footer class="text-center mt-5" style="font-size: 12px;">
                        <a class="mt-5 text-muted mb-1" href="https://github.com/OthoArenas/UrPodcast" target="_blank">© 2020&nbsp;Othoniel E. Salazar Arenas</a>
                        <p class="mt-1 mb-3 text-muted">Computación en el Servidor Web</p>
                    </footer>
                </div>
            </div>
        </div>
</div>
@endsection
