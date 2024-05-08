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
                            <h5 class="mb-0">@lang('هذه الرابط محرم من الدخول له ')</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>  403 </div>
                </div>
            </div>
        </div>
    </div>

@stop





