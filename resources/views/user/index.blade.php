@extends('layouts.app')

@section('content')


    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Users</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Shreyu</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Starter</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">List of Users</div>

                        <div class="card-body">
                            <div id="table-data-toolbar">
                                <a class="btn btn-primary" id="btn-create" href="{{ route('user.create') }}"><i
                                        class="fa fa-plus"></i> Create new</a>
                            </div>
                            <table id="table-data"></table>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->


        <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" id="form-delete">

                    @csrf
                    @method('DELETE')

                    <input type="hidden" name="id" id="id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-deleteLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span class="identifier-delete"></span> data?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div> <!-- content -->

@endsection

@section('scripts')

    <script>
        $(function() {
            $("#table-data").bootstrapTable({
                toolbar: "#table-data-toolbar",
                classes: "table table-striped table-no-bordered",
                search: true,
                showRefresh: true,
                iconsPrefix: "fa",
                // showToggle: true,
                // showColumns: true,
                // showExport: true,
                // showPaginationSwitch: true,
                pagination: true,
                pageList: [10, 25, 50, 100, "ALL"],
                // showFooter: false,
                sidePagination: "server",
                url: "{{ URL::to('/user/table_data') }}",
                columns: [{
                        field: "id",
                        title: "Action",
                        class: "text-nowrap",
                        formatter: function(id, row, index) {
                            var html =
                                `<a class="btn btn-sm btn-primary btn-edit" href="{{ URL::to('user') }}/${id}/edit"><i class="fa fa-edit"></i> Edit</a> `;
                            html +=
                                `<a class="btn btn-sm btn-danger btn-delete" href="#" data-id="${id}" data-identifier="${row.name}"><i class="fa fa-trash"></i> Delete</a>`;

                            return html;
                        },
                    },

                    {
                        field: "email",
                        title: "Email",
                        sortable: true,
                    },
                    {
                        field: "roles",
                        title: "Roles",
                        sortable: true,
                        formatter: function(roles) {
                            var html = '';
                            html += roles.length > 0 ? roles.map(role =>
                                '<span class="badge bg-primary">' + role.name + '</span>').join(
                                ' ') : '-';
                            return html;
                        }
                    },



                    {
                        field: "created_at",
                        title: "Created at",
                        sortable: true,
                    },

                    {
                        field: "updated_at",
                        title: "Updated at",
                        sortable: true,
                    },
                ],
            });


            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                var btn_delete = $(this);
                var id = btn_delete.data('id');
                var modal_delete = $('#modal-delete');
                var form_delete = $('#form-delete');

                $.ajax({
                    url: "{{ URL::to('/user') }}/" + id,
                    type: 'GET',
                    success: function(result) {
                        console.log(result);

                        const {
                            status,
                            message,
                            data
                        } = result;

                        if (status) {
                            const {
                                user
                            } = data;

                            if (user) {
                                modal_delete.modal('show');
                                $.each(user, function(key, value) {
                                    form_delete.find('#' + key).val(value);
                                });
                                modal_delete.find('#identifier-delete').html(user.name);
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            $('#form-delete').on('submit', function(e) {
                e.preventDefault();

                var form_delete = $(this);
                var modal_delete = $('#modal-delete');

                $.ajax({
                    url: "{{ URL::to('/user') }}/" + form_delete.find('#id').val(),
                    type: 'POST',
                    data: form_delete.serialize(),
                    success: function(result) {

                        const {
                            status,
                            data,
                            errors,
                            message
                        } = result;

                        console.log(status, data, errors, message);

                        if (status) {
                            Swal.fire({
                                title: 'Success!',
                                text: message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function(result) {
                                modal_delete.modal('hide');

                                $('#table-data').bootstrapTable('refresh');
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                        }

                        $('#modal-loading').modal('hide');
                    }
                })
            });
        })
    </script>
@endsection
