@extends('layouts.home')

@section('page-title')
  {{ trans('lang.not_found') }}
@endsection

@section('content')
  <div class="text-center py-5">
    <h1>{{ trans('lang.not_found') }}</h1>
  </div>
@endsection
