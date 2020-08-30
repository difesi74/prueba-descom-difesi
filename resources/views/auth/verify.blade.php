@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <img src="{{ asset(Auth::user()->getRutaImagenPerfil()) }}"
                class="imagen-perfil-usuario med filtro-bn rounded-circle"alt="{{ Auth::user()->name }}">
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>

                    {{ __('Si ya lo has entendido y/o has recibido el correo, también puedes ir a la')}}
                        <a href="{{ url('/') }}">{{ __('pantalla de acceso') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
