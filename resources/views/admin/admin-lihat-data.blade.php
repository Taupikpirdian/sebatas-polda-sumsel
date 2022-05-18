@extends('layouts.app')

@section('css')
<style>
.select2-selection__rendered {
  line-height: 32px !important;
}

.select2-selection {
  height: 34px !important;
}
</style>
@endsection

@section('content')
<div class="page-content">
    <!-- Page-Title -->
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Dashboard</h4>
                    <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Aplikasi Sebatas Kriminal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card" style="background-image: url('{{ asset('assets/images/red-background.jpg')}}');">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="color-white">Hallo Operator !</h5>
                                    <p class="text-muted color-white">Selamat Datang di Aplikasi Sebatas Kriminal</p>

                                    <div class="mt-4">
                                        @if(Auth::user()->groups()->where("name", "!=", "Admin")->first())
                                        <a target="_blank" href="{{URL::to('/perkara/create')}}" class="btn btn-light btn-sm"><i class="mdi mdi-plus-thick"></i> Data Kasus</a>
                                        @endif
                                        <a href="{{URL::to('/')}}" class="btn btn-light btn-sm"><i class="mdi mdi-home"></i> Dashboard</a>
                                    </div>
                                </div>

                                <div class="col-5 ml-auto">
                                    <div class="shadow-lg p-3 bg-white rounded">
                                      <img src="{{ asset('assets/images/widget-img.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                  <div class="card" style="height: 210px">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                              <h6>Profil</h6>
                          </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/images/badge.png')}}" alt="" class="img-fluid" style="width:30%">
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <p class="text-muted color-font-brown"><b>{{ Auth::user()->name }}</b></p>
                        </div>
                      </div>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                <!-- filter -->
                <div class="card">
                  <div class="card-header">
                      <h5 class="card-title">Lihat data</h5>
                  </div>
                  {!! Form::open(['method'=>'GET','url'=>'/lihat-data','role'=>'search'])  !!}
                  <div class="card-body">
                      <div class="basic-form">
                          <div class="row">
                              <div class="col-sm-6" style="margin-bottom: 12px">
                                <select class="form-control mb-2" name="satker" id="satker" @if(Auth::user()->divisi == null) @else required @endif>
                                  <option value="">Pilih SATKER @if(Auth::user()->divisi == null) @else <span style="color: red">*</span> @endif</option>
                                  @foreach($kategori_bagians as $i=>$satker)
                                  <option value="{{ $satker->id }}" @if($satker->id == $satker_param) selected @endif>{{ $satker->name }}</option>
                                  @endforeach
                                </select>

                                <select class="form-control mb-2" name="divisi" id="divisiSatker">
                                  <option value="">Pilih Divisi</option>
                                  {{-- from jquery --}}
                                </select>

                                <select class="form-control" name="jenis_kasus" id="jenis_kasus">
                                    <option value="">Pilih Jenis Tindak Pidana</option>
                                  @foreach($jenispidanas as $i=>$pidana)
                                    <option value="{{ $pidana->id }}" @if($pidana->id == $jenis_kasus_param) selected @endif>{{ $pidana->name }}</option>
                                  @endforeach
                                </select>
                              </div>
          
                              <div class="col-sm-6 mt-2 mt-sm-0" style="margin-bottom: 12px">
                                <select class="form-control mb-2" name="tahun" id="year-select2" required>
                                  <option value="">Pilih Tahun <span style="color: red">*</span></option>
                                  <option value="2015" @if($tahun_param == '2015') selected @endif>2015</option>
                                  <option value="2016" @if($tahun_param == '2016') selected @endif>2016</option>
                                  <option value="2017" @if($tahun_param == '2017') selected @endif>2017</option>
                                  <option value="2018" @if($tahun_param == '2018') selected @endif>2018</option>
                                  <option value="2019" @if($tahun_param == '2019') selected @endif>2019</option>
                                  <option value="2020" @if($tahun_param == '2020') selected @endif>2020</option>
                                  <option value="2021" @if($tahun_param == '2021') selected @endif>2021</option>
                                  <option value="2022" @if($tahun_param == '2022') selected @endif>2022</option>
                                  <option value="2023" @if($tahun_param == '2023') selected @endif>2023</option>
                                  <option value="2024" @if($tahun_param == '2024') selected @endif>2024</option>
                                  <option value="2025" @if($tahun_param == '2025') selected @endif>2025</option>
                                  <option value="2026" @if($tahun_param == '2026') selected @endif>2026</option>
                                  <option value="2027" @if($tahun_param == '2027') selected @endif>2027</option>
                                  <option value="2028" @if($tahun_param == '2028') selected @endif>2028</option>
                                  <option value="2029" @if($tahun_param == '2029') selected @endif>2029</option>
                                  <option value="2030" @if($tahun_param == '2030') selected @endif>2030</option>
                                </select>

                                <select class="form-control" name="bulan" id="month-select2">
                                    <option value="">Pilih Bulan</option>
                                    <option value="01" @if($bulan_param == '01') selected @endif>Januari</option>
                                    <option value="02" @if($bulan_param == '02') selected @endif>Februari</option>
                                    <option value="03" @if($bulan_param == '03') selected @endif>Maret</option>
                                    <option value="04" @if($bulan_param == '04') selected @endif>April</option>
                                    <option value="05" @if($bulan_param == '05') selected @endif>Mei</option>
                                    <option value="06" @if($bulan_param == '06') selected @endif>Juni</option>
                                    <option value="07" @if($bulan_param == '07') selected @endif>Juli</option>
                                    <option value="08" @if($bulan_param == '08') selected @endif>Agustus</option>
                                    <option value="09" @if($bulan_param == '09') selected @endif>September</option>
                                    <option value="10" @if($bulan_param == '10') selected @endif>Oktober</option>
                                    <option value="11" @if($bulan_param == '11') selected @endif>November</option>
                                    <option value="12" @if($bulan_param == '12') selected @endif>Desember</option>
                                </select>
                              </div>
          
                          </div>
                      </div>
                  </div>
          
                  <div class="card-footer d-sm-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Lihat</button>
                  </div>
                  {!! Form::close() !!}
                </div>
                <!-- end filter -->
              </div>
            </div>

            @if($satker_param || $jenis_kasus_param || $tahun_param || $bulan_param)
            <div class="row">
              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/red-background.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">TOTAL KEJAHATAN <a class="color-white" href="{{URL::to('/list-data?mode=total&&satker='.$satker_param.'&&divisi='.$divisi_param.'&&jenis_kasus='.$jenis_kasus_param.'&&tahun='.$tahun_param.'&&bulan='.$bulan_param )}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus_f_map }}</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/blue-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">KEJAHATAN SELESAI <a class="color-white" href="{{URL::to('/list-data?mode=perkara-selesai&&satker='.$satker_param.'&&divisi='.$divisi_param.'&&jenis_kasus='.$jenis_kasus_param.'&&tahun='.$tahun_param.'&&bulan='.$bulan_param )}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus_selesai_f_map }}</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/brown-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">KEJAHATAN PROGRESS <a class="color-white" href="{{URL::to('/list-data?mode=perkara-progress&&satker='.$satker_param.'&&divisi='.$divisi_param.'&&jenis_kasus='.$jenis_kasus_param.'&&tahun='.$tahun_param.'&&bulan='.$bulan_param )}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus_belum_f_map }}</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/red-background.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">RESIKO PENDUDUK TERKENA TINDAK PIDANA</h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">0</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/blue-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">SELANG WAKTU TERJADI KEJAHATAN (MENIT)</h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">0</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card" style="background-image: url('{{ asset('assets/images/brown-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <h6 class="color-white" style="font-size: 12px">PENYELESAIAN PERKARA</h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ number_format($percent_done_f_map) }}% Selesai</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">MAPPING PERKARA SUMATERA SELATAN</h4>
                    <p class="card-title-desc">Data Persebaran Kejahatan </p>
                    <div id="map" style="width:100%;height:380px;"></div>
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->
              
            </div>

            <div class="row">
              <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">Data Perbandingan Kasus</h4>
                    <p class="card-title-desc">Perbandingan Data Kasus Selesai dan Progress Pada Tahun </p>
                    <canvas id="lineChart"></canvas>
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->

              <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">Kejahatan Index</h4>
                    <p class="card-title-desc">Berdasarkan Jenis Kejahatan</p>
                      @foreach($top_kasus_filter as $key=>$index_jenis_kejahatan)
                      <hr>
                      <h6 class="card-title font-size-2">{{ $index_jenis_kejahatan->name }}</h6>
                      <p class="card-text font-size-1">{{ $index_jenis_kejahatan->total }} Kejahatan</p>
                      @endforeach
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->

              @if(Auth::user()->groups()->where("name", "=", "Admin")->first())
              <div class="col-xl-3">
                <div class="card">
                  <div class="card-body">
                    <h4 class="header-title">Kejahatan Index</h4>
                    <p class="card-title-desc">Berdasarkan Satker</p>
                    @foreach($top_kasus_satker_polda_filter as $key=>$top_polda)
                    <hr>
                    <h6 class="card-title font-size-2">Polda</h6>
                    <p class="card-text font-size-1">#1 {{ $top_polda->name }} ({{ $top_polda->total }} kasus)</p>
                    @endforeach

                    @foreach($top_kasus_satker_polres_filter as $key=>$top_polres)
                    <hr>
                    <h6 class="card-title font-size-2">Polres</h6>
                    <p class="card-text font-size-1">#1 {{ $top_polres->name }} ({{ $top_polres->total }} kasus)</p>
                    @endforeach

                    @foreach($top_kasus_satker_polsek_filter as $key=>$top_polsek)
                    <hr>
                    <h6 class="card-title font-size-2">Polsek</h6>
                    <p class="card-text font-size-1">#1 {{ $top_polsek->name }} ({{ $top_polsek->total }} kasus)</p>
                    @endforeach
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->
              @endif
            </div>
            @endif

          </div>
          
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end page-content-wrapper -->
</div>
@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Script -->
<script type='text/javascript'>
$(document).ready(function(){
  // Department Change
  $('#satker').change(function(){
      // Satker id
      var id = $(this).val();
      // Empty the dropdown
      $('#divisiSatker').find('option').not(':first').remove();
      // AJAX request 
      $.ajax({
        url: 'get-divisi/'+id,
        type: 'get',
        dataType: 'json',
        success: function(response){
          var len = 0;
          if(response['data'] != null){
            len = response['data'].length;
          }

          if(len > 0){
            // Read data and create <option >
            for(var i=0; i<len; i++){
              var name = response['data'][i];
              var option = "<option value='"+name+"'>"+name+"</option>";
              console.log(option);
              $("#divisiSatker").append(option); 
            }
          }

        }
    });
  });
});
</script>
<!-- google maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYiwleTNi8Ww0Un6Jna9LuQyWGvdFYEcI&callback=initMap"
async defer></script>
<script>
  function initMap() {
    var options = {
        zoom:8,
        center:{lat:-2.974166680534421,lng:104.76982727107811}
    }

    var locations = [
      @foreach($petas as $i=>$peta)
        @if($peta != null)
        [new google.maps.LatLng(
          {{$peta->lat}}, 
          {{$peta->long}}), 
          '{{$peta->divisi}}', 
          'No LP: {{ $peta->no_lp }}, <a target="_blank" href="{{URL::to('/perkara/show/'.$peta->id)}}">Detail</a>',
          '{{$peta->pin}}'],
        @endif
      @endforeach
    ];

    var map = new google.maps.Map(document.getElementById('map'), options);

    var infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < locations.length; i++) {
      var marker = new google.maps.Marker({
        position: locations[i][0],
        map: map,
        title: locations[i][1],
        icon: locations[i][3],
      });

      // Register a click event listener on the marker to display the corresponding infowindow content
      google.maps.event.addListener(marker, 'click', (function(marker, i) {

        return function() {
          infowindow.setContent(locations[i][2]);
          infowindow.open(map, marker);
        }

      })(marker, i));
    }
  }
</script>

<script>
  // Row 4
  !function(n) {
      n(function() {
          var e = n("#lineChart").get(0).getContext("2d");
          new Chart(e, {
              type: "line",
              data: {
                  labels: [
                      <?php foreach ($arr_month_progress as $data) { ?> "{{ $data[0] }}",
                      <?php } ?>
                  ],
                  datasets: [{
                      label: "Progress",
                      data: [
                        <?php foreach ($arr_month_progress as $data) { ?> "{{ $data[1] }}",
                        <?php } ?>
                      ],
                      borderColor: ["#f96565"],
                      borderWidth: 3,
                      fill: !1,
                      pointBackgroundColor: "#ffffff",
                      pointBorderColor: "#f96565"
                  }, {
                      label: "Selesai",
                      data: [
                        <?php foreach ($arr_month_done as $data) { ?> "{{ $data[1] }}",
                        <?php } ?>
                      ],
                      borderColor: ["#769530"],
                      borderWidth: 3,
                      fill: !1,
                      pointBackgroundColor: "#ffffff",
                      pointBorderColor: "#769530"
                  }]
              },
              options: {
                  scales: {
                      yAxes: [{
                          gridLines: {
                              drawBorder: !1,
                              borderDash: [3, 3],
                              zeroLineColor: "#7b919e"
                          },
                          ticks: {
                              min: 0,
                              color: "#7b919e"
                          }
                      }],
                      xAxes: [{
                          gridLines: {
                              display: !1,
                              drawBorder: !1,
                              color: "#ffffff"
                          }
                      }]
                  },
                  elements: {
                      line: {
                          tension: .2
                      },
                      point: {
                          radius: 4
                      }
                  },
                  stepsize: 1
              }
          })
      })
  }(jQuery);
</script>
@endsection