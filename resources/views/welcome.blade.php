<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/mis-scripts.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/mis-estilos.css') }}" rel="stylesheet">
    </head>
    <body>
        @if (Route::has('login'))
            <div class="content">
                <div class="row principal justify-content-center">
                    <h1>{{ config('app.name') }}</h1>
                </div>
                @auth
                    <div class="row principal justify-content-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset(Auth::user()->getRutaImagenPerfil()) }}"
                                class="imagen-perfil-usuario max clicable transicion-bn-color rounded-circle"
                                alt="{{ Auth::user()->name }}" title="{{ __('Ir a pantalla de Inicio') }}">
                        </a>
                    </div>
                    <div class="row principal justify-content-center">
                        <a class="btn btn-success btn-lg extra" href="{{ route('home') }}" role="button">
                            <i class="fa fa-user"></i> {{ __('Inicio') }}</a>
                    </div>
                    <div class="row principal justify-content-center">
                        <a class="btn btn-danger btn-lg extra" href="{{ route('logout') }}" role="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            title="{{ __('Cerrar Sesión') }}">
                            <i class="fa fa-power-off"></i> {{ __('Cerrar') }}</a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>                                    
                @else
                    <div class="row principal justify-content-center">
                        <a href="{{ route('login') }}">
                            <img src="{{ asset(FicherosHelper::getRutaImagenPerfilUsuarioDefecto()) }}"
                                class="imagen-perfil-usuario max clicable rounded-circle"
                                alt="{{ config('personalizada.imagen_perfil_usuario_defecto') }}" title="{{ __('Acceder') }}">
                        </a>
                    </div>
                    <div class="row principal justify-content-center">
                        <a class="btn btn-success btn-lg extra" href="{{ route('login') }}" role="button">
                            <i class="fa fa-sign-in-alt"></i> {{ __('Acceder') }}</a>
                    </div>
                    @if (Route::has('register'))
                        <div class="row principal justify-content-center">
                            <a class="btn btn-primary btn-lg extra" href="{{ route('register') }}" role="button">
                                <i class="fa fa-user-plus"></i> {{ __('Registro') }}</a>
                        </div>
                    @endif
                @endauth
            </div>
        @endif
    </body>
</html>
