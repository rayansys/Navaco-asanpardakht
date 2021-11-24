<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $transaction->id }}</title>
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body class="window">
<div>
  <br>
  <h2 class="text-center text-info"><b>{{ trans('lang.transaction_details') }}</b></h2>
  <br>
  <div class="table-responsive">
    <table class="table table-bordered text-center" style="table-layout: fixed;">
      <tbody>
      <tr>
        <td width="200">
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
        <td>
          <span class="{{ $transaction->status && $transaction->verified ? 'text-success' : 'text-danger' }}">{{ $transaction->status && $transaction->verified ? trans('lang.success') : trans('lang.failed') }}</span>
        </td>
      </tr>
      @if(isset($transaction->payment_info['trans_id']))
        <tr>
          <td>
            {{ trans('lang.payment_transaction_id') }}
          </td>
          <td>
            {{ $transaction->payment_info['trans_id'] }}
          </td>
        </tr>
      @endif
      @if(isset($transaction->payment_info['card_number']))
        <tr>
          <td>
            {{ trans('lang.card_number') }}
          </td>
          <td style="direction: ltr">
            <span>{{ $transaction->payment_info['card_number'] }}</span>
          </td>
        </tr>
      @endif
      @if($transaction->type == \App\Transaction::$type['form'] && $transaction->form())
        <tr>
          <td>{{ trans('lang.form_details') }}</td>
          <td>
            <a href="{{ route('form', ['id' => $transaction->form()->id]) }}" target="_blank">{{ $transaction->form()->title }}</a>
          </td>
        </tr>
        @if($transaction->details && isset($transaction->details['form_fields']))
          <tr>
            <td>
              {{ trans('lang.inputs') }}
            </td>
            <td>
              @foreach ($transaction->details['form_fields'] as $input)
                <b>{{ $input['label'] }} : </b> {{ $input['value'] }} <br>
              @endforeach
            </td>
          </tr>
        @endif
      @endif
      @if($transaction->type == \App\Transaction::$type['factor'] && $transaction->factor())
        <tr>
          <td>{{ trans('lang.title') }}</td>
          <td>
            <a href="{{ route('admin-factors-filter', ['id' => $transaction->factor()->id]) }}" target="_blank">{{ $transaction->factor()->title }}</a>
          </td>
        </tr>
        @if($transaction->details && isset($transaction->details['factor_items']))
          <tr>
            <td>
              {{ trans('lang.factor') }}
            </td>
            <td>
              <table class="table text-center table-hover table-striped table-bordered">
                <thead>
                <tr>
                  <th>{{ trans('lang.row') }}</th>
                  <th>{{ trans('lang.item_name') }}</th>
                  <th>{{ trans('lang.item_count') }}</th>
                  <th>{{ trans('lang.item_price') }}</th>
                  <th>{{ trans('lang.item_description') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction->details['factor_items'] as $key => $item)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>{{ $item['price'] }}</td>
                    <td>{{ $item['description'] }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              <table class="table text-center table-hover table-striped table-bordered">
                <tbody>
                <tr>
                  <th>{{ trans('lang.tax') }}</th>
                  <td>{{ $transaction->factor()->tax }}</td>
                  <th>{{ trans('lang.total_amount') }}</th>
                  <td>{{ custom_money_format($transaction->factor()->amount) }}</td>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
        @endif
      @endif
      <tr>
        <td>
          {{ trans('lang.date') }}
        </td>
        <td>{{ $transaction->full_jalali_created_at }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
</body>
