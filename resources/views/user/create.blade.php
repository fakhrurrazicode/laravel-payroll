<?php 
use App\Dokter;
use App\Pegawai;
use Spatie\Permission\Models\Role;
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
                    <div class="card-header">Create new Users</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{route('user.store')}}">

                            @csrf

                            <div class="row mb-3">
                                <label for="role_id" class="col-lg-2 col-form-label text-lg-end">Role</label>
                                <div class="col-lg-5">
                                    <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id"  >
                                        <option value=""></option>
                                        @foreach(Role::all() as $role)
                                            <option {{old('role_id') == $role->id ? 'selected=""' : ''}} value="{{$role->id}}">{{$role->name}} ({{$role->guard_name}})</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pegawai_id" class="col-lg-2 col-form-label text-lg-end">Pegawai</label>
                                <div class="col-lg-5">
                                    <select class="form-select @error('pegawai_id') is-invalid @enderror" id="pegawai_id" name="pegawai_id"  >
                                        <option value=""></option>
                                        @foreach(Pegawai::where('flag', 'dokter')->orderBy('nama')->get() as $pegawai)
                                            <option {{old('pegawai_id') == $pegawai->id ? 'selected=""' : ''}} value="{{$pegawai->id}}">{{$pegawai->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('pegawai_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-lg-2 col-form-label text-lg-end">Email Address</label>
                                <div class="col-lg-5">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" style="display: none;">
                                <label for="name" class="col-lg-2 col-form-label text-lg-end">Name</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-lg-2 col-form-label text-lg-end">Password</label>
                                <div class="col-lg-5">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror " id="password" name="password" value="{{old('password')}}" >
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-lg-2 col-form-label text-lg-end">Password Confirmation</label>
                                <div class="col-lg-5">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{old('password_confirmation')}}" >
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 offset-lg-2">
                                    
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{route('user.index')}}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
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
        $(function(){
            
        })
    </script>

@endsection
