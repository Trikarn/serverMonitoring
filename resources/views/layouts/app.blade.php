<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Мониторинг серверов</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/chartjs-plugin-annotation.min.js')}}"></script>
    {{-- <script src="{{asset('js/chart.js')}}"></script> --}}
    {{-- <script src="{{asset('js/chart.js')}}"></script> --}}
    {{-- <script src="path/to/chartjs-plugin-annotation/dist/chartjs-plugin-annotation.min.js"></script> --}}



    <script src="https://cdn.anychart.com/releases/8.9.0/js/anychart-base.min.js" type="text/javascript"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .group-rom {
            width: 100%;
            float: left;
            border-bottom: 1px solid #eaebee;
        }

        .group-rom .first-part,
        .group-rom .second-part,
        .group-rom .third-part {
            float: left;
            padding: 15px;
        }

        .group-rom .first-part {
            width: 25%;
        }

        .group-rom .first-part.odd {
            background: #f7f8fa;
            color: #6a6a6a;
            font-weight: 600;
        }

        .group-rom .second-part{
            width: 60%;
        }

        .group-rom .third-part{
            width: 15%;
            color: #d4d3d3;
        }
    </style>
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Мониторинг серверов
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a href="/servers" class="nav-link @if(Request::is('servers*')) active @endif">Мои сервера</a>
                                </li>
                                @if (Auth::user()->type != 'admin')
                                <li class="nav-item">
                                    <a href="/favorite" class="nav-link @if(Request::is('favorite*')) active @endif">Избранное</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="/supports" class="nav-link @if(Request::is('support*')) active @endif">Поддержка</a>
                                </li>
                                @if (Auth::user()->type != 'admin')
                                <li class="nav-item">
                                    <a href="/telegram" class="nav-link @if(Request::is('telegram*')) active @endif">Телеграм-каналы</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="/settings" class="nav-link @if(Request::is('settings*')) active @endif">Настройки</a>
                                </li>
                            </ul>   
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Логин') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
