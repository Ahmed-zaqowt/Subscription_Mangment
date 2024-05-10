@extends('admin.master')

@section('title', 'Admin | Home')

@section('css')

@stop

@section('content')


    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الطلب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form_edit" id="form_edit" enctype="multipart/form-data"
                        action="{{ route('dist.order.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" class="form-control">
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("name")</label>
                            <input  id="edit_name" placeholder="@lang('name')"  name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("mobile")</label>
                            <input id="edit_mobile" placeholder="@lang('mobile')"  name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("رقم الهوية")</label>
                            <input id="edit_id_number"  placeholder="@lang('رقم الهوية')"  name="id_number" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("الرقم التسلسلي للشريحة")</label>
                            <input id="edit_serial_number" placeholder="@lang('الرقم التسلسلي للشريحة')"  name="serial_number" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("بداية الاشتراك")</label>
                            <input id="edit_start"  placeholder="@lang('بداية الاشتراك')"  name="start" class="form-control" type="date">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("نهاية الاشتراك")</label>
                            <input id="edit_end"  placeholder="@lang('نهاية الاشتراك')"  name="end" class="form-control" type="date">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("حالة الرقم التسلسلي")</label>
                            <select name="status_mobile" id="edit_status_mobile" class="form-control" >
                             <option disabled selected>حالة الرقم التسلسلي</option>
                             <option value="6">قديم</option>
                             <option value="7">جديد</option>
                            </select>
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
                            <h5 class="mb-0">@lang(' الطلبات المعلقة  ')</h5>
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
                                    <th>@lang('status_number')</th>
                                    <th>@lang('id_number')</th>
                                    <th>@lang('serial_number')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('start')</th>
                                    <th>@lang('end')</th>
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
        $(document).ready(function() {
            $(document).on('change', '.select_status', function(event) {
                if (confirm("هل تريد فعلا تعديل حالة الطلب ؟؟ ")) {
                    var form = document.getElementById("form_status");
                    var data = new FormData(form);
                    let url = $(form).attr('action');
                    var method = $(form).attr('method');
                    $.ajax({
                        type: method,
                        cache: false,
                        contentType: false,
                        processData: false,
                        url: url,
                        data: data,

                        beforeSend: function() {},
                        success: function(result) {
                            toastr.success(result.success);
                            table.draw()
                        },
                        error: function(data) {
                            if (data.status === 422) {
                                var response = data.responseJSON;
                                $.each(response.errors, function(key, value) {
                                    var str = (key.split("."));
                                    if (str[1] === '0') {
                                        key = str[0] + '[]';
                                    }
                                    $('[name="' + key + '"], [name="' + key + '[]"]')
                                        .addClass(
                                            'is-invalid');
                                    $('[name="' + key + '"], [name="' + key + '[]"]')
                                        .closest(
                                            '.form-group').find('.invalid-feedback')
                                        .html(value[0]);
                                });
                            } else {
                                console.log('ahmed');
                            }
                        }
                    });
                } else {
                    document.getElementById("form_status").reset();
                }

            });
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
            },
            ajax: {
                url: "{{ route('dist.order.getdata') }}",
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
                        data: "status_number",
                        name: "status_mobile",
                        orderable: true,
                        searchable: true
                    },
                {
                    data: "id_number",
                    name: "id_number",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "serial_number",
                    name: "serial_number",
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
                    name: "start",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "end",
                    name: "end",
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
                $(document).on('click', '.edit_btn', function(event) {
                    $('input').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                    event.preventDefault();
                    var button = $(this)
                    var id = button.data('id');
                    $('#id').val(id);
                    $('#edit_name').val(button.data('name'))
                    $('#edit_id_number').val(button.data('id_number'))
                    $('#edit_serial_number').val(button.data('serial_number'))
                    $('#edit_mobile').val(button.data('mobile'))
                    $('#edit_start').val(button.data('start'))
                    $('#edit_end').val(button.data('end'))
                    $('#edit_status_mobile').val(button.data('status_mobile'))

                });
            });
    </script>

@stop
