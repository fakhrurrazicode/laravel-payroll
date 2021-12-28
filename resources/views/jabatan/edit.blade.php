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



                            <form method="POST" action="{{ route('jabatan.update', $jabatan->id) }}">

                                @csrf
                                @method('PUT')



                                <div class="row mb-3">
                                    <label for="nama" class="col-lg-2 col-form-label text-lg-end">Nama</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $jabatan->nama) }}">
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
                                            id="gaji_pokok" name="gaji_pokok"
                                            value="{{ old('gaji_pokok', $jabatan->gaji_pokok) }}">
                                        @error('gaji_pokok')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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

@endsection

@section('scripts')

    <script>
        $(function() {


        })
    </script>
@endsection
