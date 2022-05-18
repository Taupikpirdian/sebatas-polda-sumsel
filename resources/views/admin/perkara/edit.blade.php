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
                      <li class="breadcrumb-item active">Update Status Data</li>
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

              <div id="accordion">
                {!! Form::model($perkara,['files'=>true,'method'=>'put','action'=>['admin\PerkaraController@update',$perkara->id]]) !!}
                <div class="card">
                    @error('dokumen')
                      <div class="card-header">
                        <div id="alert-danger" class="alert alert-danger alert-dismissible fade show" style="position: absolute; right: 0px">
                          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                          <strong>Error! {{ $message }}</strong> {{Session::get('flash-danger')}}.
                          <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                          </button>
                        </div>
                      </div>
                    @enderror
                  <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Detail Kasus
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nomer LP</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->no_lp }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Satker</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->satuan }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label>Uraian Singkat Kejadian</label>
                        <textarea class="form-control color-grey" rows="3" name="desc" placeholder="Masukan Uraian Singkat Kejadian" disabled>{{ $perkara->uraian }}</textarea>
                      </div>

                      <div class="form-group">
                        <label for="name">Nama Petugas</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->nama_petugas }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Pangkat</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->pangkat }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Jenis Pidana</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->pidana }}" disabled="">
                      </div>

                      @if($perkara->jenis_pidana == 32)
                      <div class="form-group">
                        <label for="name">Jenis Narkoba</label>
                        <input type="text" class="form-control color-grey" name="material" value="{{ $perkara->narkobas }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Berat (gram)</label>
                        <input type="text" class="form-control color-grey" name="qty" value="{{ $perkara->qty }}" disabled="">
                      </div>
                      @endif

                      <div class="form-group">
                        <label for="name">Nama Korban</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->korban }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Saksi</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->saksi }}" disabled="">
                      </div>

                      <div class="form-group">
                        <label for="name">Pelaku</label>
                        <input type="text" class="form-control color-grey" id="no_lp" name="no_lp" placeholder="Data kosong" value="{{ $perkara->pelaku }}" disabled="">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Update Status Data
                      </button>
                    </h5>
                  </div>
              
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Tanggal Surat Sprint Penyidik<label style="color: red">*</label></label>
                        <input type="text" class="form-control datepicker-here" data-language="en" id="tanggal_surat_sprint_penyidik" name="tanggal_surat_sprint_penyidik" placeholder="Masukan Tanggal" value="{{old('tanggal_surat_sprint_penyidik')}}" readonly="readonly" required />
                        @error('tanggal_surat_sprint_penyidik')
                          <div class="col-md-5 input-group mb-1" style="color:red">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                      
                      <div class="form-group">
                        <label>Status<label style="color: red">*</label></label>
                        {{ Form::select('status', $status, null,['class' => 'form-control', 'required' => 'required']) }}
                      </div>

                      <div class="form-group">
                        <label for="name">Dokumen</label>
                        <input type="file" class="form-control" id="dokumen" name="dokumen">
                        <p style="color: red; font-size:13">Note: Hanya File PDF dengan ukuran maksimal 5 Mb</p>
                        
                      </div>

                      <div class="form-group">
                        <label for="name">Tanggal Dokumen</label>
                        <input type="text" class="form-control datepicker-here" data-language="en" id="tgl_doc" name="tgl_doc" placeholder="Masukan Tanggal Update Status Perkara" value="{{old('tgl_doc')}}" readonly="readonly" />
                        @error('tgl_doc')
                          <div class="col-md-5 input-group mb-1" style="color:red">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan" placeholder="Masukan Keterangan Update Status Perkara">{{Request::old('keterangan')}}</textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <a title="Kembali" href="{{ url()->previous() }}" style="margin-right:20px;" class="btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left" aria-hidden="true"></i>   Kembali</a>
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
<script>
setTimeout(function() {
    $('#alert-danger').fadeOut('fast');
}, 7000);

setTimeout(function() {
    $('#alert-warning').fadeOut('fast');
}, 7000);
</script>
@endsection