<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="stl">
        <v-app>
        <div class="stl-header">
            <div class="stl__header-container">
                <div class="stl__logo">
                    <a href="/" class="stl-logo">
                        <h1 class="stl-logo__title">Система распределения учебной нагрузки</h1>
                    </a>
                </div>
                <div class="stl__user">
                    <div class="stl-user">
                    @guest
                        <v-btn flat small title="Вход"><a class="nav-link" href="{{ route('login') }}">Вход</a></v-btn>
                        <v-btn flat small title="Регистрация"><a class="nav-link" href="{{ route('register') }}">Регистрация</a></v-btn>
                    @else

                        <div class="stl-user__trigger" name="user-trigger">
                            <div class="stl-user__name">{{ Auth::user()->name}}</div>
                        </div>

                        <tippy
                                to="user-trigger"
                                trigger="click"
                                theme="minimal"
                                :distance="0"
                                :interactive="true">

                            <ul class="stl-user__list">

                                <li class="stl-user__item">
                                    <a href="" class="stl-user__link">
                                        <div class="stl-user__link-text">Сообщения</div>
                                    </a>
                                </li>

                                <li class="stl-user__item">
                                    <a href="" class="stl-user__link">
                                        <div class="stl-user__link-text">Справочники</div>
                                    </a>
                                </li>

                                <li class="stl-user__item">
                                    <a href="{{ route('home') }}" class="stl-user__link">
                                        <div class="stl-user__link-text">Распределения</div>
                                    </a>
                                </li>

                                <li class="stl-user__item">
                                    <a href="" class="stl-user__link">
                                        <div class="stl-user__link-text">Мой профиль</div>
                                    </a>
                                </li>

                                <li class="stl-user__item">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="stl-user__link">
                                        <div class="stl-user__link-text">Выйти</div>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>

                            </ul>
                        </tippy>

                        @endguest
                    </div>
                </div>
            </div>
        </div>

            <div class="stl__main">
                <div class="stl__main-container">
                    @yield('content')
                </div>
            </div>

            <stl-loader v-show="$store.state.isLoad" />
        </v-app>
    </div>
</body>
</html>
<script>

</script>