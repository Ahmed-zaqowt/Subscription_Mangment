@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop

@section('content')

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">@lang('الاعدادات')</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('msg'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('msg') }}
                    </div>
                    @endif
                    <form enctype="multipart/form-data" action="{{ route('admin.setting.storOrupdate')  }}"  method="POST">
                        @csrf
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("سعر الاشتراك الشهري")</label>
                            <input value="{{ $setting->price ?? null}}" placeholder="@lang('سعر الاشتراك الشهري')"  name="price" class="form-control" type="text" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info col-12">@lang("save")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
    </script>

@stop





