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
                      <li class="breadcrumb-item active">Detail Data</li>
                  </ol>
              </div>
          </div>
      </div>
  </div>
  <!-- end page title end breadcrumb -->

  <!-- Modal -->
  <div class="modal fade" id="modal-upload-pdf">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Dokumen Update Status Perkara!</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            {!! Form::model($perkara,['files'=>true,'method'=>'put','action'=>['admin\PerkaraController@uploadPdf',$perkara->id]]) !!}
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Tanggal Surat Sprint Penyidik<label style="color: red">*</label></label>
                <input type="date" class="form-control" id="tanggal_surat_sprint_penyidik" name="tanggal_surat_sprint_penyidik" placeholder="Masukan Tanggal" value="{{ $perkara->tanggal_surat_sprint_penyidik }}"  required>
              </div>
              <div class="form-group">
                <label for="name">Dokumen</label>
                <input type="file" class="form-control" id="dokumen" name="dokumen" placeholder="Masukan Dokumen Update Status Perkara">
                <p style="color: red; font-size:13">Note: Hanya File PDF dengan ukuran maksimal 5 Mb</p>
              </div>
              <div class="form-group">
                <label for="name">Tanggal Dokumen</label>
                <input type="date" class="form-control" id="tgl_doc" name="tgl_doc" placeholder="Masukan Tanggal Update Status Perkara" value="{{old('tgl_doc')}}" >
              </div>
              <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" rows="3" name="keterangan" placeholder="Masukan Keterangan Update Status Perkara">{{Request::old('keterangan')}}</textarea>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Upload</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

  <div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="profile-tab">
                      <div class="custom-tab-1">
                        <div class="tab-content">
                          <div id="profile-settings" class="tab-pane fade active show">
                            <div class="pt-3">
                              <div class="settings-form">
                                <form>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">User Input</label>
                                      <input type="text" class="form-control color-grey" value=" {{{$perkara->user->name}}}"  disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">No LP</label>
                                      <input type="text" class="form-control color-grey" value=" {{{$perkara->no_lp}}}"  disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Tanggal LP</label>
                                      <input type="text" class="form-control color-grey" value=" {{Carbon\Carbon::parse($perkara->date_no_lp)->formatLocalized('%d %B %Y')}}"  disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Satuan</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->satuan->name}}}" disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Satuan Kerja (Satker)</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->satker->name}}}"  disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Divisi</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->divisi}}}" disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feLastName">Uraian Kejadian</label>
                                      <textarea class="form-control color-grey" rows="3" disabled="">{{{$perkara->uraian}}}</textarea>
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feLastName">Modus Operasi</label>
                                      <textarea class="form-control color-grey" rows="3" disabled="">{{{$perkara->modus_operasi}}}</textarea>
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Nama Petugas</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->nama_petugas}}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Pangkat</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->pangkat}}}"  disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">No Telepon</label>
                                      <input type="text" class="form-control color-grey" value="{{{$perkara->no_tlp}}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Jenis Pidana</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->pidana ? $perkara->pidana->name : '' }}}"  disabled> 
                                    </div>
                                  </div>
          
                                  @if($perkara->jenis_pidana == '32')
                                    <div class="form-row">
                                    @if($perkara->jenis_narkoba)
                                      <div class="form-group col-md-6">
                                        <label for="feLastName">Jenis Narkoba</label>
                                        <input type="text" class="form-control color-grey" value="{{{ $perkara->jenis_narkoba ? $perkara->jenis_narkoba->name : '' }}}" disabled> 
                                      </div>
                                    @else
                                      <div class="form-group col-md-6">
                                        <label for="feLastName">Jenis Narkoba</label>
                                        <input style="color: red" type="text" class="form-control color-grey" value="Belum ada data" disabled> 
                                      </div>
                                    @endif
                                    @if($perkara->qty)
                                      <div class="form-group col-md-6">
                                        <label for="feFirstName">Berat (gram)</label>
                                        <input type="text" class="form-control color-grey" value="{{{$perkara->qty}}}"  disabled> 
                                      </div>
                                    @else
                                      <div class="form-group col-md-6">
                                        <label for="feFirstName">Berat (gram)</label>
                                        <input style="color: red" type="text" class="form-control color-grey" value="Belum ada data" disabled> 
                                      </div>
                                    @endif
                                    </div>
                                  @endif
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Tanggal Kejadian</label>
                                      <input type="text" class="form-control color-grey" value=" {{Carbon\Carbon::parse($perkara->date)->formatLocalized('%d %B %Y')}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Waktu Kejadian</label>
                                      <input type="time" class="form-control color-grey" value="{{{$perkara->time}}}"  disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Nama Korban</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->nama : '' }}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Umur Korban</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->umur_korban : '' }}}" disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Pendidikan Korban</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->pendidikan_korban : '' }}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Pekerjaan Korban</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->pekerjaan_korban : '' }}}" disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Asal Korban</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->asal_korban : '' }}}" disabled> 
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Saksi</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->korban ? $perkara->korban->saksi : '' }}}"  disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feLastName">Pelaku</label>
                                      <textarea class="form-control color-grey" rows="3" disabled="">{{{ $perkara->korban ? $perkara->korban->pelaku : '' }}}</textarea>
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feLastName">Barang Bukti</label>
                                      <textarea class="form-control color-grey" rows="3" disabled="">{{{ $perkara->korban ? $perkara->korban->barang_bukti : '' }}}</textarea>
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Tanggal Surat Sprint Penyidik</label>
                                      @if($perkara->tanggal_surat_sprint_penyidik != null)
                                      <input type="text" class="form-control color-grey" value=" {{Carbon\Carbon::parse($perkara->tanggal_surat_sprint_penyidik)->formatLocalized('%d %B %Y')}}"  disabled> 
                                      @else
                                      <input type="text" class="form-control color-grey" value="-"  disabled> 
                                      @endif
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Status</label>
                                      <input type="text" class="form-control color-grey" value="{{{ $perkara->status ? $perkara->status->name : '' }}}" disabled> 
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Tanggal Update Status Perkara</label>
                                      @if($perkara->tgl_document != null)
                                      <input type="text" class="form-control color-grey" value=" {{Carbon\Carbon::parse($perkara->tgl_document)->formatLocalized('%d %B %Y')}}"  disabled> 
                                      @else
                                      <input type="text" class="form-control color-grey" value="-"  disabled> 
                                      @endif
                                    </div>
          
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Dokumen Update Status Perkara</label>
                                      @if($perkara->status->name == "Progress")
                                      <a class="form-control" style=" color: red" href="#">Dokumen belum ada <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                      @else
                                        @if($perkara->document)
                                        <a class="form-control color-grey" target="_blank" style=" color: #00AFEF" href="{{route('show-pdf', $perkara->id)}}">View Dokumen <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                        @else
                                        <a class="form-control" style="color: #00AFEF" href="#" data-toggle="modal" data-target="#modal-upload-pdf" class="ai-icon" aria-expanded="false"><label style="color: red">Tidak ada dokumen</label>, Upload Dokumen?</a>
                                        @endif
                                      @endif
                                    </div>
                                  </div>
          
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feLastName">Keterangan update Status Perkara</label>
                                      <textarea class="form-control color-grey" rows="3" disabled="">{{{$perkara->keterangan}}}</textarea>
                                    </div>
                                  </div>
          
                                </form>
                                <a title="Kembali" href="{{ url()->previous() }}" style="margin-right:20px;" class="btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left" aria-hidden="true"></i>   Kembali</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYiwleTNi8Ww0Un6Jna9LuQyWGvdFYEcI&callback=initMapShow"
async defer></script>

<script>
function initMapShow() {
  var options = {
      zoom:8,
      center:{lat:{{ $perkara->lat }},lng:{{ $perkara->long }}}
  }

  var locations = [
      [new google.maps.LatLng(
        {{$perkara->lat}}, 
        {{$perkara->long}}), 
        '<a target="_blank" href="http://www.google.com/maps/place/{{ $perkara->lat }},{{ $perkara->long }}">Go to Google Maps</a>'],
  ];

  var map_show = new google.maps.Map(document.getElementById('map_show'), options);

  var infowindow = new google.maps.InfoWindow();

  for (var i = 0; i < locations.length; i++) {
    var marker = new google.maps.Marker({
      position: locations[i][0],
      map: map_show,
    });

    // Register a click event listener on the marker to display the corresponding infowindow content
    google.maps.event.addListener(marker, 'click', (function(marker, i) {

      return function() {
        infowindow.setContent(locations[i][1]);
        infowindow.open(map_show, marker);
      }

    })(marker, i));
  }
}
</script>
@endsection