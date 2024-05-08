@extends('admin.master')

@php
    use App\Models\User;

@endphp
@section('title' , 'Admin | Home')

@section('css')

    @stop

@section('content')

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        @php
                           $user = User::where('id' , $id)->first();

                        @endphp
                        <div class="col">
                            <h5 class="mb-0">@lang('مشتركين الموزع')  "{{ $user->name }}"</h5>
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
                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('name')</th>
                                <th>@lang('mobile')</th>
                                <th>@lang('start_sub')</th>
                                <th>@lang('end_sub')</th>
                                <th>@lang('status')</th>
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
                    url: "{{ route('admin.admin.getdatasub') }}",
                    data:{
                        id:"{{ $id }}"
                    }
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
                        data: "mobile",
                        name: "mobile",
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
                        data: "status",
                        name: "status",
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
                    $('#edit_username').val(button.data('username'))
                    $('#edit_mobile').val(button.data('mobile'))
                    //$('#image_preview').src(button.data('image'))
                    var imageURL = button.data('image');

                    // اعثر على عنصر الصورة باستخدام الهوية وقم بتعيين الرابط
                    var imagePreview = document.getElementById('image_preview');
                    imagePreview.src = imageURL;
                });
            });
    </script>

@stop






