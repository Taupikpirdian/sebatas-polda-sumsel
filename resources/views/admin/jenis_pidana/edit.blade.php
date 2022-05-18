@extends('layouts.app')

@section('content')
@if ($message = Session::get('flash-store'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>{{ $message }}</strong>
  </div>
@endif

@if ($message = Session::get('flash-update'))
  <div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>{{ $message }}</strong>
  </div>
@endif

@if ($message = Session::get('flash-destroy'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>{{ $message }}</strong>
  </div>
@endif

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
                  {!! Form::model($jenispidana,['method'=>'put', 'files'=> 'true', 'action'=>['admin\JenisPidanaController@update',$jenispidana->id]]) !!}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nama<label style="color: red">*</label></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Jenis Pidana" value="{{{$jenispidana->name}}}" required>
                      </div>

                      <div class="form-group">
                        <label for="name">Divisi<label style="color: red">*</label></label>
                        <select class="form-control" name="kategori_jns_pidana" required>
                          <option value="">=== Pilih Salah Satu Divisi ===</option>
                          <option value="0" @if($jenispidana->kategori_jns_pidana == '0') selected @endif>Satreskrim</option>
                          <option value="1" @if($jenispidana->kategori_jns_pidana == '1') selected @endif>Satnarkoba</option>
                        </select>
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