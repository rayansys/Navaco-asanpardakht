@extends('layouts.admin')

@section('page-title'){{ trans('lang.configs') }}@endsection

@section('content')
<div class="card">
  <div class="card-header">{{ trans('lang.configs') }}</div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4 offset-md-4">
        <form method="post" action="{{ route('admin-configs') }}">
          {{ csrf_field() }}
          @foreach($configs as $config)
            <div class="form-group">
              <label>{{ $config->label }}</label>
              <input type="text" class="form-control" name="{{ $config->key }}" value="{{ $config->value }}">
            </div>
          @endforeach
          <button type="submit" class="btn btn-primary">{{ trans('lang.save') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
