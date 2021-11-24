@extends('layouts.home')

@section('page-title')
  {{ trans('lang.payment_receipt') }}
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-6 offset-md-3">
        <div class="card mt-5">
          <div class="card-body">
            <h4 class="card-title mb-4">{{ trans('lang.receipt') }}</h4>
            @if($transaction && $transaction->status && $transaction->verified)
              <div class="table-responsive">
                <table class="table table-bordered text-center" style="table-layout: fixed;">
                  <tbody>
                  <tr>
                    <td>
                      {{ trans('lang.id') }}
                    </td>
                    <td>{{ $transaction->id }}</td>
                  </tr>
                  <tr>
                    <td>
                      {{ trans('lang.amount') }}
                    </td>
                    <td>{{ custom_money_format($transaction->amount) }}</td>
                  </tr>
                  <tr>
                    <td>
                      {{ trans('lang.status') }}
                    </td>
                    <td>{{ $transaction->status ? trans('lang.success') : trans('lang.failed') }}</td>
                  </tr>
                  <tr>
                    <td>
                      {{ trans('lang.payment_transaction_id') }}
                    </td>
                    <td>{{ $transaction->payment_info['trans_id'] }}</td>
                  </tr>
                  <tr>
                    <td>
                      {{ trans('lang.card_number') }}
                    </td>
                    <td style="direction: ltr">
                      <span>{{ $transaction->payment_info['card_number'] }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      {{ trans('lang.date') }}
                    </td>
                    <td>{{ $transaction->full_jalali_created_at }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-danger">
                {{ trans('lang.transaction_failed') }}
              </div>
              @if($transaction)
                <a href="{{ route('pg-pay', ['id' => $transaction->id]) }}" class="btn btn-primary">{{ trans('lang.repay') }}</a>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
