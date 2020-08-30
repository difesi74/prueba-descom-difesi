@extends('layouts.app')

@section('librerias-extra-js')
<script src="{{ asset('js/cropperjs/cropper.js') }}" defer></script>
<script src="{{ asset('js/cropperjs/jquery-cropper.js') }}" defer></script>
@endsection

@section('librerias-extra-css')
<link rel="stylesheet" href="{{ asset('css/cropperjs/cropper.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" {{-- enctype="multipart/form-data" --}}>
                        @csrf

                        <input type="hidden" id="imagen-data" name="imagen_data">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" maxlength="255" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" maxlength="100" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mostrar-ocultar-password" id="show_hide_password">
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" maxlength="20" required autocomplete="new-password">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mostrar-ocultar-password" id="show_hide_password_confirmation">
                                    <input id="password-confirm" class="form-control" type="password" name="password_confirmation" maxlength="20" required autocomplete="new-password">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fichero-subida" class="col-md-4 col-form-label text-md-right">{{ __('Imagen de Perfil') }}</label>
                            <div class="col-md-6">
                                <div class="subida-fichero custom-file">
                                    <input id="fichero-subida" type="file" class="custom-file-input" accept="image/png, image/jpeg">
                                    <label class="custom-file-label" for="customFile">{{ __('Seleccionar fichero...') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row contenedor-imagen-perfil-usuario justify-content-center">
                            <img id="imagen" src="{{ asset(FicherosHelper::getRutaImagenPerfilUsuarioDefecto()) }}"
                                class="imagen-perfil-usuario max" alt="{{ __('Imagen del usuario') }}" title="{{ __('Imagen del usuario') }}">
                        </div>

                        <div class="form-group row justify-content-center">
                            <button id="btn-registro" type="button" class="btn btn-primary btn-lg extra">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
