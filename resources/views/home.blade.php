@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-4 text-center">
            <img src="{{ asset(Auth::user()->getRutaImagenPerfil()) }}"
                class="imagen-perfil-usuario max rounded-circle"alt="{{ Auth::user()->name }}">
        </div>
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Panel de Inicio') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>{!! __('Hola, <strong>:nombre</strong>.', ['nombre' => Auth::user()->name]) !!}</h1>
                    <h1>{{ __('Bienvenid@ a tu pantalla de inicio!') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
