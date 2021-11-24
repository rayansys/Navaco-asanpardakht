@extends('layouts.admin')

@section('page-title'){{ trans('lang.forms') }}@endsection

@section('content')
<div class="card">
  <div class="card-header">
    {{ trans('lang.forms') }}
    <a href="{{ route('admin-forms-add') }}" class="btn btn-success btn-sm float-right">{{ trans('lang.add_new_form') }}</a>
  </div>
  <div class="card-body">
    <div class="">
      <table class="table text-center table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>{{ trans('lang.id') }}</th>
            <th>{{ trans('lang.title') }}</th>
            <th>{{ trans('lang.amount') }}</th>
            <th>{{ trans('lang.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($forms as $form)
          <tr>
            <td>{{ $form->id }}</td>
            <td>
              <a href="{{ route('form', ['id' => $form->id]) }}" target="_blank">{{ $form->title }}</a>
              @if($form->default)
              <span class="badge badge-primary">{{ trans('lang.default') }}</span>
              @endif
            </td>
            <td>{{ $form->amount ? custom_money_format($form->amount) : 'دلخواه' }}</td>
            <td>
              <div class="btn-group">
                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ trans('lang.actions') }}
                </button>
                <div class="dropdown-menu">
                  @if(!$form->default)
                  <a href="{{ route('admin-forms-default', ['id' => $form->id]) }}" class="dropdown-item">{{ trans('lang.make_default') }}</a>
                  @endif
                  <a href="{{ route('admin-forms-edit', ['id' => $form->id]) }}" class="dropdown-item">{{ trans('lang.edit') }}</a>
                  <a href="{{ route('admin-forms-delete', ['id' => $form->id]) }}" class="dropdown-item">{{ trans('lang.delete') }}</a>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {!! $forms->render() !!}
  </div>
</div>
@endsection
