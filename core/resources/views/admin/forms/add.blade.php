@extends('layouts.admin')

@section('page-title'){{ trans('lang.add_new_form') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      {{ trans('lang.add_new_form') }}
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="txt-title" class="label">{{ trans('lang.title') }} ({{ trans('lang.required') }})</label>
              <input type="text" class="form-control" id="txt-title" name="title" value="{{ old('title') }}">
            </div>
            <div class="form-group">
              <label for="txt-description" class="label">{{ trans('lang.description') }} ({{ trans('lang.optional') }})</label>
              <textarea name="description" id="txt-description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
              <label for="txt-amount" class="label">{{ trans('lang.amount') }} ({{ trans('lang.optional') }})</label>
              <input type="text" class="form-control" id="txt-amount" name="amount" value="{{ old('amount') }}" placeholder="{{ trans('lang.to_optional_amount_leave_empty') }}">
            </div>
            <div id="advanced" style="display: none">
              <div class="form-group">
                <label for="txt-pay-limit" class="label">{{ trans('lang.pay_limit') }} ({{ trans('lang.optional') }})</label>
                <input type="text" class="form-control" id="txt-pay-limit" name="pay_limit" value="{{ old('pay_limit') }}" placeholder="{{ trans('lang.to_unlimited_payment_leave_empty') }}">
              </div>
              <div class="form-group">
                <label for="file-image" class="label">{{ trans('lang.image') }} ({{ trans('lang.optional') }})</label>
                <input type="file" class="form-control" id="file-image" name="image" accept="image/*">
              </div>
              <div class="form-group py-3 px-3" style="background: oldlace">
                <label class="label">{{ trans('lang.fields') }} ({{ trans('lang.optional') }})</label>
                <a href="javascript:" class="float-right" onclick="addNewField()">{{ trans('lang.add_new_field') }}</a>
                <div id="fields">
                  <div class="form-group" id="field0">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text">
                          <input type="checkbox" name="required_fields[]" value="required_0" class="mr-1"> {{ trans('lang.required_field') }}
                        </label>
                      </div>
                      <input type="text" name="fields[]" class="form-control" placeholder="عنوان فیلد - مثال: شماره موبایل">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <a id="btn-advanced" href="javascript:" onclick="showAdvanced()">{{ trans('lang.advanced') }}</a>
            </div>
            <div class="form-group">
              <button class="btn btn-success">{{ trans('lang.add') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .field {
      position: relative;
    }

    .delete-field {
      position: absolute;
      left: 0;
      top: 0;
    }
  </style>
@endpush

@push('scripts')
  <script>
    let fields = 1;

    function showAdvanced() {
      $('#advanced').show();
      $('#btn-advanced').hide();
    }

    function addNewField() {
      $('#fields').append('<div class="form-group field" id="field' + (fields + 1) + '"><div class="input-group"><div class="input-group-prepend"><label class="input-group-text"><input type="checkbox" name="required_fields[]" value="required_' + fields + '" class="mr-1"> فیلد اجباری</label></div><input type="text" name="fields[]" class="form-control" placeholder="عنوان فیلد"><a href="javascript:" class="btn btn-danger delete-field">حذف</a></div></div>')
      fields++;
    }

    $('#fields').on('click', '.delete-field', function () {
      $(this).parent().parent('.field').remove();
    })
  </script>
@endpush
