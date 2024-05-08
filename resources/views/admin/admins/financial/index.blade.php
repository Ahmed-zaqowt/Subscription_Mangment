@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop

@section('content')

    <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('update') @lang('user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form_add" id="form_add" enctype="multipart/form-data" action="{{ route('admin.admin.store')  }}"  method="POST">
                        @csrf
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("name")</label>
                            <input  placeholder="@lang('name')"  name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("user_name") <small>(@lang('must_be_unique'))</small></label>
                            <input  placeholder="@lang('user_name')"  name="username" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("mobile")</label>
                            <input  placeholder="@lang('mobile')"  name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("password")</label>
                            <input  placeholder="@lang('password')"  name="password" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang("close")</button>
                            <button type="submit" class="btn btn-info">@lang("save")</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('update') @lang('user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form_edit" id="form_edit" enctype="multipart/form-data" action="{{ route('admin.admin.update')  }}"  method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id"  class="form-control">
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("name")</label>
                            <input id="edit_name" placeholder="@lang('name')"  name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("user_name")</label>
                            <input id="edit_username" placeholder="@lang('user_name')"  name="username" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("mobile")</label>
                            <input id="edit_mobile" placeholder="@lang('mobile')"  name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("password")</label>
                            <input  placeholder="@lang('password')"  name="password" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang("close")</button>
                            <button type="submit" class="btn btn-info">@lang("save")</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="show-followers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('show') @lang('followers')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list_followers">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="show-posts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('show') @lang('followers')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="list_posts">
                  </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">@lang('الموزعين')</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li data-bs-toggle="modal" data-bs-target="#add-modal"><a class="dropdown-item">@lang('add')</a>
                                        </li>
                                    </ul>
                                </div>
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
                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('name')</th>
                                <th>@lang('user_name')</th>
                                <th>@lang('mobile')</th>
                                <th>@lang('portfolio')</th>
                                <th>@lang('actions')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
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




            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
                },
                ajax: {
                    url: "{{ route('admin.financial.getdata') }}",
                },

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name",
                        name: "name",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "email",
                        name: "username",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "mobile",
                        name: "mobile",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "portfolio",
                        name: "portfolio",
                        orderable: true,
                        searchable: true
                    },

                    {
                        data: "actions",
                        name: "actions",
                        orderable: false,
                        searchable: false
                    },
                ]
            });




    </script>

@stop






