@extends('layouts.admin')

@section('page-title'){{ trans('lang.factors') }}@endsection

@section('content')
  <div class="card mb-4">
    <div class="card-header">{{ trans('lang.filter') }}</div>
    <div class="card-body">
      <form action="{{ route('admin-factors-filter') }}" class="form-inline">
        <div class="form-group mb-2">
          <label for="txt-id" class="sr-only">{{ trans('lang.id') }}</label>
          <input type="text" name="id" class="form-control" id="txt-id" placeholder="{{ trans('lang.id') }}" value="@if(isset($inputs['id'])){{ $inputs['id'] }}@endif">
        </div>
        <div class="form-group mx-2 mb-2">
          <button class="btn btn-primary">{{ trans('lang.filter') }}</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      {{ trans('lang.factors') }}
      <a href="{{ route('admin-factors-add') }}" class="btn btn-success btn-sm float-right">{{ trans('lang.add_new_factor') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table text-center table-hover table-striped table-bordered">
          <thead>
          <tr>
            <th>{{ trans('lang.id') }}</th>
            <th>{{ trans('lang.title') }}</th>
            <th>{{ trans('lang.amount') }}</th>
            <th>{{ trans('lang.status') }}</th>
            <th>{{ trans('lang.actions') }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($factors as $factor)
            <tr>
              <td>{{ $factor->id }}</td>
              <td>
                <a href="{{ route('factor', ['id' => $factor->id]) }}" target="_blank">{{ $factor->title }}</a>
              </td>
              <td>{{ custom_money_format($factor->amount) }}</td>
              <td>
                @if($factor->paid)
                  <span class="badge badge-success">{{ trans('lang.paid') }}</span>
                  <a href="{{ route('admin-transactions-detail', ['id' => $factor->transaction_id]) }}" class="btn-popup">{{ trans('lang.transaction_details') }}</a>
                @else
                  <span class="badge badge-danger">{{ trans('lang.not_paid') }}</span>
                @endif
              </td>
              <td>
                @if(!$factor->paid)
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ trans('lang.send_factor') }}
                    </button>
                    <div class="dropdown-menu">
                      <a href="https://t.me/share/url?url={{ site_config('site_url') . '/factor/' . $factor->id }}" class="dropdown-item" target="_blank">{{ trans('lang.telegram') }}</a>
                      <a href="https://api.whatsapp.com/send?text={{ site_config('site_url') . '/factor/' . $factor->id }}" class="dropdown-item" target="_blank">{{ trans('lang.whatsapp') }}</a>
                    </div>
                  </div>
                @endif
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans('lang.actions') }}
                  </button>
                  <div class="dropdown-menu">
                    @if(!$factor->paid)
                      <a href="{{ route('admin-factors-edit', ['id' => $factor->id]) }}" class="dropdown-item">{{ trans('lang.edit') }}</a>
                    @endif
                    <a href="{{ route('admin-factors-delete', ['id' => $factor->id]) }}" class="dropdown-item">{{ trans('lang.delete') }}</a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      {!! $factors->render() !!}
    </div>
  </div>
@endsection
