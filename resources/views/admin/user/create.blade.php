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
                      <li class="breadcrumb-item active">Tambah Data User</li>
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
                  {{ Form::open(array('url' => '/user/create', 'files' => true, 'method' => 'post')) }}
                    <div class="card-body">
                      <table class="table table-striped table-hover">
                        <tr>
                          <div class='form-group clearfix'>
                              <label for="name">Nama<label style="color: red">*</label></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama" required>
                          </div> 
                        </tr>
            
                        <tr>
                          <div class='form-group clearfix'>
                              <label for="email">Email<label style="color: red">*</label></label>
                              <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email" required>
                          </div> 
                        </tr>
            
                        <tr>
                          <div class='form-group clearfix'>
                              <label for="password">Password<label style="color: red">*</label></label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="new-password" required>
                          </div> 
                        </tr>
            
                        <tr>
                          <div class='form-group clearfix'>
                              <label for="password">Confirm Password<label style="color: red">*</label></label>
                              <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Repeat Password" required>
                          </div> 
                        </tr>
            
                        <tr>
                          <div class='form-group clearfix'>
                              <label for="">Role User<label style="color: red">*</label></label>
                              <select class="form-control" id="test" name="user_group_id" onchange="showDiv(this)" required>
                                  <option value="">=== Pilih Salah Satu ===</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                              </select>
                          </div> 
                        </tr>
            
                        <div class="form-group" id="hidden_div" style="display:none;">
                          <label>Divisi<label style="color: red">*</label></label>
                          <div class="input-group">
                            <select class="form-control" name="divisi_polda" id="req_polda">
                                <option value="">=== Pilih Salah Satu ===</option>
                                <option value="Ditreskrimsus">Ditreskrimsus</option>
                                <option value="Ditreskrimum">Ditreskrimum</option>
                                <option value="Ditresnarkoba">Ditresnarkoba</option>
                            </select>
                          </div>
                        </div>
            
                        <div class="form-group" id="hidden_div2" style="display:none;">
                          <label>Divisi<label style="color: red">*</label></label>
                          <div class="input-group">
                            <select class="form-control" name="divisi_polres" id="req_polres">
                                <option value="">=== Pilih Salah Satu ===</option>
                                <option value="Satreskrim">Satreskrim</option>
                                <option value="Satnarkoba">Satnarkoba</option>
                            </select>
                          </div>
                        </div>
            
                        <div class="form-group" id="hidden_div3" style="display:none;">
                          <label>Divisi<label style="color: red">*</label></label>
                          <div class="input-group">
                            <select class="form-control" name="divisi_polsek" id="req_polsek">
                                <option value="">=== Pilih Salah Satu ===</option>
                                <option value="Unit Reskrim">Unit Reskrim</option>
                            </select>
                          </div>
                        </div>
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
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  function showDiv(select){
     if(select.value==2){
        document.getElementById('hidden_div').style.display = "block";
        document.getElementById('hidden_div2').style.display = "none";
        document.getElementById('hidden_div3').style.display = "none";
        // enable required divisi polda
        $("#req_polda").prop('required',true);
     } else if(select.value==3){
        document.getElementById('hidden_div2').style.display = "block";
        document.getElementById('hidden_div').style.display = "none";
        document.getElementById('hidden_div3').style.display = "none";
        // enable required divisi polres
        $("#req_polres").prop('required',true);
     } else if(select.value==4){
        document.getElementById('hidden_div3').style.display = "block";
        document.getElementById('hidden_div').style.display = "none";
        document.getElementById('hidden_div2').style.display = "none";
        // enable required divisi polsek
        $("#req_polsek").prop('required',true);
     }else{
        // disable required
        $("#req_polda").prop('required',false);
        $("#req_polres").prop('required',false);
        $("#req_polsek").prop('required',false);

        document.getElementById('hidden_div').style.display = "none";
        document.getElementById('hidden_div2').style.display = "none";
        document.getElementById('hidden_div3').style.display = "none";
     }
  } 
</script>
@endsection