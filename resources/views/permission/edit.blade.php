@extends('layouts.app')

@section('content')


<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Permission</h4>
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
                    <div class="card-header">Edit Permission</div>
    
                    <div class="card-body">

                        

                        <form method="POST" action="{{route('permission.update', $permission->id)}}">

                            @csrf
                            @method('PUT')

                            

                            <div class="row mb-3">
                                <label for="name" class="col-lg-2 col-form-label text-lg-end">Name</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $permission->name)}}" >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="guard_name" class="col-lg-2 col-form-label text-lg-end">Guard Name</label>
                                <div class="col-lg-5">
                                    <select class="form-select @error('guard_name') is-invalid @enderror" name="guard_name" id="guard_name">
                                        <option {{old('guard_name', $permission->guard_name) == 'web' ? 'selected=""' : ''}} value="web">Web</option>
                                        <option {{old('guard_name', $permission->guard_name) == 'api' ? 'selected=""' : ''}} value="api">Api</option>
                                    </select>
                                    @error('guard_name')
                                        <span class="invalid-feedback" permission="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 offset-lg-2">
                                    
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{route('permission.index')}}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
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
            ClassicEditor
                .create( document.querySelector( '#descriptions' ) )
                .then( editor => {
                    console.log( editor );
                } )
                .catch( error => {
                    console.error( error );
                } );
            
            $('#start_time').bootstrapMaterialDatePicker({  format : 'HH:mm', date: false });
            $('#end_time').bootstrapMaterialDatePicker({  format : 'HH:mm', date: false });
           
        })
    </script>
@endsection
