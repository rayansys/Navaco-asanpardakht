@extends('layouts.admin')

@section('page-title'){{ trans('lang.edit_form') }}@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      {{ trans('lang.edit_form') }}
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="txt-title" class="label">{{ trans('lang.title') }} ({{ trans('lang.required') }})</label>
              <input type="text" class="form-control" id="txt-title" name="title" value="{{ $form->title }}">
            </div>
            <div class="form-group">
              <label for="txt-description" class="label">{{ trans('lang.description') }} ({{ trans('lang.optional') }})</label>
              <textarea name="description" id="txt-description" class="form-control" rows="3">{{ $form->description }}</textarea>
            </div>
            <div class="form-group">
              <label for="txt-amount" class="label">{{ trans('lang.amount') }} ({{ trans('lang.optional') }})</label>
              <input type="text" class="form-control" id="txt-amount" name="amount" value="{{ $form->amount }}" placeholder="{{ trans('lang.to_optional_amount_leave_empty') }}">
            </div>
            <div id="advanced">
              <div class="form-group">
                <label for="txt-pay-limit" class="label">{{ trans('lang.pay_limit') }} ({{ trans('lang.optional') }})</label>
                <input type="text" class="form-control" id="txt-pay-limit" name="pay_limit" value="{{ $form->pay_limit }}" placeholder="{{ trans('lang.to_unlimited_payment_leave_empty') }}">
              </div>
              <div class="form-group">
                <label for="file-image" class="label">{{ trans('lang.image') }} ({{ trans('lang.optional') }})</label>
                <input type="file" class="form-control" id="file-image" name="image" accept="image/*">
              </div>
              <div class="form-group py-3 px-3" style="background: oldlace">
                <label class="label">{{ trans('lang.fields') }} ({{ trans('lang.optional') }})</label>
                <a href="javascript:" class="float-right" onclick="addNewField()">{{ trans('lang.add_new_field') }}</a>
                <div id="fields">
                  @foreach($form->fields as $key => $field)
                    <div class="form-group field" id="field{{ $key }}">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label class="input-group-text">
                            <input type="checkbox" name="required_fields[]" value="required_{{ $key }}" class="mr-1" @if($field['required']) checked @endif> {{ trans('lang.required_field') }}
                          </label>
                        </div>
                        <input type="text" name="fields[]" class="form-control" value="{{ $field['label'] }}">
                        <a href="javascript:" class="btn btn-danger delete-field">حذف</a>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-success">{{ trans('lang.edit') }}</button>
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
      $('#fields').append('<div class="form-group field" id="field' + (fields + 1) + '"><div class="input-group field"><div class="input-group-prepend"><label class="input-group-text"><input type="checkbox" name="required_fields[]" value="required_' + fields + '" class="mr-1"> فیلد اجباری</label></div><input type="text" name="fields[]" class="form-control" placeholder="عنوان فیلد"><a href="javascript:" class="btn btn-danger delete-field">حذف</a></div></div>')
      fields++;
    }

    $('#fields').on('click', '.delete-field', function () {
      $(this).parent().parent('.field').remove();
    })
  </script>
@endpush
