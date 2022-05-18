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
                      <li class="breadcrumb-item active">Edit Data User</li>
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
                  {!! Form::model($user,['method'=>'put', 'autocomplete' => 'off', 'files'=> 'true', 'action'=>['admin\UserController@update',$user->id]]) !!}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nama<label style="color: red">*</label></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukan nama" value="{{{$user->name}}}" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                        <label>Email<label style="color: red">*</label></label>
                        <input type="text" class="form-control" name="email" placeholder="Masukan email" value="{{{$user->email}}}" autocomplete="off" required>
                      </div>
                      <div class="form-group input_fields_container_part">
                          <div class="btn btn-sm btn-primary add_more_button">Ubah Password</div><br>
                      </div>
                      <div class="form-group">
                        <label for="">Role<label style="color: red">*</label></label>
                          {{ Form::select('user_group_id', $groups, $user->group_id,['onchange'=> 'showDiv(this)','class' => 'form-control required', 'required' => 'required']) }}
                        </div>
        
                      <div class="form-group" id="hidden_div" style="display:block;">
                        <label>Divisi<label style="color: red">*</label></label>
                        <div class="input-group">
                          <select class="form-control" name="divisi_polda">
                            <option value="">=== Pilih Salah Satu ===</option>
                            <option value="Ditreskrimsus" @if($user->divisi == 'Ditreskrimsus') selected @endif>Ditreskrimsus</option>
                            <option value="Ditreskrimum" @if($user->divisi == 'Ditreskrimum') selected @endif>Ditreskrimum</option>
                            <option value="Ditresnarkoba" @if($user->divisi == 'Ditresnarkoba') selected @endif>Ditresnarkoba</option>
                          </select>
                        </div>
                      </div>
        
                      <div class="form-group" id="hidden_div2" style="display:none;">
                        <label>Divisi<label style="color: red">*</label></label>
                        <div class="input-group">
                          <select class="form-control" name="divisi_polres">
                            <option value="">=== Pilih Salah Satu ===</option>
                            <option value="Satreskrim" @if($user->divisi == 'Satreskrim') selected @endif>Satreskrim</option>
                            <option value="Satnarkoba" @if($user->divisi == 'Satnarkoba') selected @endif>Satnarkoba</option>
                            <option value="Unit Reskrim" @if($user->divisi == 'Unit Reskrim') selected @endif>Unit Reskrim</option>
                          </select>
                        </div>
                      </div>
        
                      <div class="form-group" id="hidden_div3" style="display:none;">
                        <label>Divisi<label style="color: red">*</label></label>
                        <div class="input-group">
                          <select class="form-control" name="divisi_polsek">
                            <option value="">=== Pilih Salah Satu ===</option>
                            <option value="Unit Reskrim" @if($user->divisi == 'Unit Reskrim') selected @endif>Unit Reskrim</option>
                          </select>
                        </div>
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
     } else if(select.value==4){
      document.getElementById('hidden_div3').style.display = "block";
      document.getElementById('hidden_div').style.display = "none";
      document.getElementById('hidden_div2').style.display = "none";
      // enable required divisi polres
      $("#req_polres").prop('required',true);
     }else{
      document.getElementById('hidden_div').style.display = "none";
      document.getElementById('hidden_div2').style.display = "none";
      document.getElementById('hidden_div3').style.display = "none";
      // enable required divisi polsek
      $("#req_polsek").prop('required',true);
     }
  } 

  $(document).ready(function() {
    var max_fields_limit      = 2; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container_part').append('<div><label>Password</label><input type="password" class="form-control" name="password" autocomplete="new-password"><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
        }
    });  
    $('.input_fields_container_part').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

    if({{ $user->group_id }} == 2){
      document.getElementById('hidden_div').style.display = "block";
      document.getElementById('hidden_div2').style.display = "none";
      document.getElementById('hidden_div3').style.display = "none";
     } else if({{ $user->group_id }} == 3){
      document.getElementById('hidden_div2').style.display = "block";
      document.getElementById('hidden_div').style.display = "none";
      document.getElementById('hidden_div3').style.display = "none";
     } else{
      document.getElementById('hidden_div').style.display = "none";
      document.getElementById('hidden_div2').style.display = "none";
      document.getElementById('hidden_div3').style.display = "none";
     }

  });
</script>
@endsection