@extends('layouts.app')
@section('content')

<div class="page-content">
  <!-- Page-Title -->
  <div class="page-title-box">
      <div class="container-fluid">
          <div class="row align-items-center">
              <div class="col-md-8">
                  <h4 class="page-title mb-1">SEBATAS</h4>
                  <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Data Kriminal</a></li>
                      <li class="breadcrumb-item active">Edit Data</li>
                  </ol>
              </div>
          </div>
      </div>
  </div>
  <!-- end page title end breadcrumb -->

  <div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  {!! Form::model($jenis_narkoba,['method'=>'put', 'files'=> 'true', 'action'=>['admin\JenisNarkobaController@update',$jenis_narkoba->id]]) !!}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nama<label style="color: red">*</label></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Jenis Narkoba" value="{{{$jenis_narkoba->name}}}" required>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  {!! Form::close() !!}
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
  </div> 
  <!-- end page-content-wrapper -->
</div>

@endsection