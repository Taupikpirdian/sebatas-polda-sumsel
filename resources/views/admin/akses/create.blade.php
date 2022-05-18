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
                      <li class="breadcrumb-item active">Tambah Akses User</li>
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
                  {{ Form::open(array('url' => '/akses/create', 'files' => true, 'method' => 'post')) }}
                    <div class="card-body">
                      <table class="table table-striped table-hover">
                        <tr>
                          <div class='form-group clearfix'>
                              {{ Form::label("user_id", "User", ['class' => 'col-md-2 control-label']) }}
                              <div class='col-md-12'>
                              {{ Form::select('user_id', $users, null,['class' => 'form-control', 'required', 'value'=>'']) }}
                              </div>
                          </div> 
                        </tr>
                        <tr>
                          <div class='form-group clearfix'>
                              {{ Form::label("sakter_id", "Satker", ['class' => 'col-md-2 control-label']) }}
                              <div class='col-md-12'>
                              {{ Form::select('sakter_id', $satker, null,['class' => 'form-control', 'required', 'value'=>'']) }}
                              </div>
                          </div>  
                        </tr>
                      </table>
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