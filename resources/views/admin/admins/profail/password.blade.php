@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop

@section('content')



    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">

                <div class="card-body">
                    @if (session('msg'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('msg') }}
                    </div>
                    @endif
                    <form  enctype="multipart/form-data" action="{{ route('admin.profile.update_password')  }}"  method="POST">
                        @csrf


                        <div class="mb-2 form-group">
                            <label class="form-label">كلمة المرور القديمة </label>
                            <input placeholder="كلمة المرور القديمة"  name="password" class="form-control" type="password">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">كلمة المرور الجديدة </label>
                            <input   placeholder="كلمة المرور الجديدة"  name="new_password" class="form-control" type="password">
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


            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
                },
                ajax: {
                    url: "{{ route('admin.subscription.getdataaccepted') }}",
                },

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name_dis",
                        name: "name_dis",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "name",
                        name: "name",
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
                        data: "status",
                        name: "status",
                        orderable: true,
                        searchable: true
                    },

                    {
                        data: "start",
                        name: "start_sub",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "end",
                        name: "end_sub",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "actions",
                        name: "actions",
                        orderable: true,
                        searchable: true
                    },
                ]
            });





    </script>

@stop






