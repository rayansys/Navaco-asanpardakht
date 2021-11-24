@extends('layouts.admin')

@section('page-title'){{ trans('lang.update') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">{{ trans('lang.update') }}</div>
    <div class="card-body">
      @if($latestRelease)
        <a href="{{ route('admin-update-install') }}" class="btn btn-success" id="btn-update" data-loading-text="{{ trans('lang.updating') }}">{{ trans('lang.install_update') }}</a>
      @else
        <p>{{ trans('lang.you_are_using_latest_version') }}</p>
      @endif
      <a href="" class="btn btn-primary">{{ trans('lang.check') }}</a>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $('#btn-update').on('click', function () {
      $(this).text($(this).data('loading-text')).addClass('disabled').attr('disabled', 'disabled');
    });
  </script>
@endpush
