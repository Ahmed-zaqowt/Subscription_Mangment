@extends('admin.master')

@section('title', 'Admin | Home')

@section('css')

@stop

@section('content')




<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تجديد الاشتراك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form_edit" id="form_edit" enctype="multipart/form-data" action="{{ route('dist.subscription.renewal')  }}"  method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="mb-2 form-group">
                        <label class="form-label">@lang("بداية الاشتراك")</label>
                        <input  placeholder="@lang('بداية الاشتراك')"  name="start" class="form-control" type="date">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-2 form-group">
                        <label class="form-label">@lang("نهاية الاشتراك")</label>
                        <input  placeholder="@lang('نهاية الاشتراك')"  name="end" class="form-control" type="date">
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

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">@lang('جميع الاشتراكات')</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('name')</th>
                                    <th>@lang('mobile')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('start_sub')</th>
                                    <th>@lang('end_sub')</th>
                                    <th>@lang('payment')</th>
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
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
            },
            ajax: {
                url: "{{ route('dist.subscription.getdata') }}",
            },

            columns: [{
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
                    data: "payment",
                    name: "payment",
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

        $(document).ready(function() {
            $(document).on('click', '.btn-renewal', function(event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this)
                var id = button.data('id');
                $('#id').val(id);
            });
        });
    </script>

@stop
