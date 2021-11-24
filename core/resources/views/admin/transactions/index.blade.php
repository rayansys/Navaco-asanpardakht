@extends('layouts.admin')

@section('page-title'){{ trans('lang.transactions') }}@endsection

@section('content')
<div class="card mb-4">
  <div class="card-header">{{ trans('lang.filter') }}</div>
  <div class="card-body">
    <form action="{{ route('admin-transactions-filter') }}" class="form-inline">
      <div class="form-group mb-2">
        <label for="txt-id" class="sr-only">{{ trans('lang.id') }}</label>
        <input type="text" name="id" class="form-control" id="txt-id" placeholder="{{ trans('lang.id') }}" value="@if(isset($inputs['id'])){{ $inputs['id'] }}@endif">
      </div>
      <div class="form-group mx-2 mb-2">
        <label for="txt-card-number" class="sr-only">{{ trans('lang.card_number') }}</label>
        <input type="text" name="card_number" class="form-control" id="txt-card-number" placeholder="{{ trans('lang.card_number') }}" value="@if(isset($inputs['card_number'])){{ $inputs['card_number'] }}@endif" title="0000-0000-0000-0000">
      </div>
      <div class="form-group mx-2 mb-2">
        <button class="btn btn-primary">{{ trans('lang.filter') }}</button>
      </div>
    </form>
  </div>
</div>
<div class="card">
  <div class="card-header">{{ trans('lang.transactions') }}</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table text-center table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>{{ trans('lang.id') }}</th>
            <th>{{ trans('lang.amount') }}</th>
            <th>{{ trans('lang.date') }}</th>
            <th>{{ trans('lang.status') }}</th>
            <th>{{ trans('lang.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ custom_money_format($transaction->amount) }}</td>
            <td>{{ $transaction->full_jalali_created_at }}</td>
            <td>
              <span class="{{ $transaction->status && $transaction->verified ? 'text-success' : 'text-danger' }}">{{ $transaction->status && $transaction->verified ? trans('lang.success') : trans('lang.failed') }}</span>
            </td>
            <td>
              <a href="{{ route('admin-transactions-detail', ['id' => $transaction->id]) }}" class="btn-popup">{{ trans('lang.details') }}</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {!! $transactions->render() !!}
  </div>
</div>
@endsection
