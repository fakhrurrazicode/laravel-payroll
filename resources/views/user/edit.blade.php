<?php 
use App\Dokter;
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
                    <div class="card-header">Edit Users</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{route('user.update', $user->id)}}">

                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="role_id" class="col-lg-2 col-form-label text-lg-end">Role</label>
                                <div class="col-lg-5">
                                    <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" value="{{old('role_id', $user->role_id)}}" >
                                        <option value=""></option>
                                        @foreach(Role::all() as $role)
                                            <option {{old('role_id', count($user->roles) ? $user->roles[0]->id : null) == $role->id ? 'selected=""' : ''}} value="{{$role->id}}">{{$role->name}} ({{$role->guard_name}})</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" id="row-dokter" style="display: none;">
                                <label for="dokter_id" class="col-lg-2 col-form-label text-lg-end">Dokter</label>
                                <div class="col-lg-5">
                                    <select class="form-select @error('dokter_id') is-invalid @enderror" id="dokter_id" name="dokter_id"  >
                                        <option value=""></option>
                                        @foreach(Dokter::all() as $dokter)
                                            <option {{old('dokter_id', $user->dokter_id) == $dokter->id ? 'selected=""' : ''}} value="{{$dokter->id}}">{{$dokter->nama_gelar}}</option>
                                        @endforeach
                                    </select>
                                    @error('dokter_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-lg-2 col-form-label text-lg-end">Email Address</label>
                                <div class="col-lg-5">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $user->email)}}" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-lg-2 col-form-label text-lg-end">Name</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}" >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            

                            <hr>

                            <div class="row">
                                <div class="col-lg-10 offset-lg-2">
                                    <p>Notes: Ignore / leave blank if you don't want to change the password</p>
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
            function roleIdChangeHandler(){
                
                var role_id = $('#role_id').val();
                if(role_id == 2){
                    $('#row-dokter').show();
                }else{
                    $('#row-dokter').hide();
                    $('#dokter_id').val('');
                }
            }
            $('#role_id').on('change', roleIdChangeHandler);
            roleIdChangeHandler();
        })
    </script>
@endsection
