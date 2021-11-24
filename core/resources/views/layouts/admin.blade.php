<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('page-title')</title>
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
  @stack('styles')
</head>

<body>
<div>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ site_config('site_title') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ trans('lang.Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="navbar-nav ml-auto">
          @if(auth()->check())
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ auth()->user()->name }} <span class="caret"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}">
                  {{ trans('lang.logout') }}
                </a>
              </div>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ trans('lang.login') }}</a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  <main class="py-4">
    <div class="container-fluid">
      @if(auth()->check())
        <div class="row justify-content-center">
          <div class="col-md-2">
            <div class="list-group">
              <a href="{{ route('admin-dashboard') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'dashboard') active @endif">{{ trans('lang.dashboard') }}</a>
              <a href="{{ route('admin-transactions') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'transactions') active @endif">{{ trans('lang.transactions') }}</a>
              <a href="{{ route('admin-forms') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'forms') active @endif">{{ trans('lang.forms') }}</a>
              <a href="{{ route('admin-factors') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'factors') active @endif">{{ trans('lang.factors') }}</a>
              <a href="{{ route('admin-configs') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'configs') active @endif">{{ trans('lang.configs') }}</a>
              <a href="{{ route('admin-security-settings') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'security-settings') active @endif">{{ trans('lang.security_settings') }}</a>
            </div>
            <br>
          </div>
          <div class="col-md-10">
            @include('extensions.alert')
            @yield('content')
          </div>
        </div>
      @else
        @yield('content')
      @endif
    </div>
  </main>
</div>
<script src="{{ asset('libs/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('libs/popper/popper.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script>
  $('.btn-popup').click(function (e) {
    e.preventDefault();
    popup($(this).attr('href'), '', 900, 800);
  });
</script>
@stack('scripts')
</body>

</html>
