@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">{{ trans('lang.login') }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}
              @include('extensions.alert')
              <div class="form-group">
                <label for="email">{{ trans('lang.email') }}</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              </div>
              <div class="form-group">
                  <label for="password">{{ trans('lang.password') }}</label>
                  <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember">
                    {{ trans('lang.remember_me') }}
                  </label>
                </div>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                  {{ trans('lang.login') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
