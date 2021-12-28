<?php
use App\Jabatan;
?>
@extends('layouts.app')

@section('content')


    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Jabatan</h4>
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
                        <div class="card-header">Create new Jabatan</div>

                        <div class="card-body">



                            <form method="POST" action="{{ route('jabatan.store') }}">

                                @csrf



                                <div class="row mb-3">
                                    <label for="nama" class="col-lg-2 col-form-label text-lg-end">Nama</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="gaji_pokok" class="col-lg-2 col-form-label text-lg-end">Gaji Pokok</label>
                                    <div class="col-lg-5">
                                        <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                            id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}">
                                        @error('gaji_pokok')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tunjangan" class="col-lg-2 col-form-label text-lg-end">Tunjangan</label>
                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div id="table-data-tunjangan-toolbar">

                                                    <button type="button" class="btn btn-primary" id="btn-create-tunjangan">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <table id="table-data-tunjangan"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 offset-lg-2">

                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Save</button>
                                        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary"><i
                                                class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->


    </div> <!-- content -->

    <div class="modal fade" id="modal-tunjangan" tabindex="-1" aria-labelledby="modal-tunjangan-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="form-tunjangan" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-tunjangan-label">Tambah Tunjangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="tunjanganable_type" id="tunjanganable_type" value="{{ Jabatan::class }}">
                    <input type="hidden" name="tunjanganable_id" id="tunjanganable_id" value="0">

                    <div class="row mb-3">
                        <label for="nama" class="col-lg-3 col-form-label text-lg-end">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="deskripsi" class="col-lg-3 col-form-label text-lg-end">Deskripsi</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nilai" class="col-lg-3 col-form-label text-lg-end">Nilai</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="nilai" name="nilai">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(function() {

            $("#table-data-tunjangan").bootstrapTable({
                toolbar: "#table-data-tunjangan-toolbar",
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
                url: "{{ URL::to('/tunjangan/table_data') }}",
                columns: [{
                        field: "id",
                        title: "Action",
                        class: "text-nowrap",
                        formatter: function(id, row, index) {
                            var html =
                                `<a class="btn btn-sm btn-primary btn-edit" href="{{ URL::to('jabatan') }}/${id}/edit"><i class="fa fa-edit"></i> Edit</a> `;
                            html +=
                                `<a class="btn btn-sm btn-danger btn-delete" href="#" data-id="${id}" data-identifier="${row.name}"><i class="fa fa-trash"></i> Delete</a>`;

                            return html;
                        },
                    },

                    {
                        field: "nama",
                        title: "Nama",
                        sortable: true,
                    },
                    {
                        field: "deskripsi",
                        title: "Deskripsi",
                        sortable: true,
                    },
                    {
                        field: "nilai",
                        title: "Nilai",
                        sortable: true,
                        formatter: function(nilai) {
                            return 'Rp. ' + number_format(nilai, 0, ',', '.')
                        }
                    },
                ],
            });

            $('#btn-create-tunjangan').on('click', function(e) {
                e.preventDefault();
                $('#modal-tunjangan').modal('show');
            })
        })
    </script>
@endsection
