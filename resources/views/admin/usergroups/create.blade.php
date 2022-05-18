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
                      <li class="breadcrumb-item active">Tambah Data</li>
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
                  <div class="card-body">
                    {!! Form::open(['action' => 'admin\UserGroupController@store']) !!}
                    <table class="table table-striped table-hover">
          
                    <tr>
                      <div class='form-group clearfix'>
                        {{ Form::label("user_id", "User", ['class' => 'col-md-2 control-label']) }}
                          <div class='col-md-12'>
                            {{ Form::select('user_id', $users, null,['class' => 'form-control required']) }}
                          </div>
                      </div> 
                    </tr>
          
                    <tr>
                      <div class='form-group clearfix'>
                        {{ Form::label("group_id", "Group", ['class' => 'col-md-2 control-label']) }}
                          <div class='col-md-12'>
                            {{ Form::select('group_id', $groups, null,['class' => 'form-control required']) }}
                          </div>
                      </div> 
                    </tr>
          
                    </table>
          
                    <div class='form-group'>
                      <div class='col-md-4 '>
                        <button class='btn btn-primary' type='submit' name='save' id='save'><span class='glyphicon glyphicon-save'></span> Save</button>
                      </div>
                    </div>
                    {!! Form::close() !!}
                  </div>
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

@section('js')
<script>
  $(function() {
    $(".datepicker4").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '-80:+0',
    dateFormat: "yy-mm-dd"
    });
    $(".datepicker2").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '-80:+0',
    dateFormat: "yy-mm-dd"
    });
    $(".datepicker3").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '-80:+0',
    dateFormat: "yy-mm-dd"
    });
  });
</script>
@endsection