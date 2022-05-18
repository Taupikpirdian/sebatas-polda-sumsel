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
                    <h4 class="page-title mb-1">Dashboard Polres {{ $nama_polres }} - {{ $label }}</h4>
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
                <div class="@if($label == 'Satnarkoba') col-xl-8 @else col-xl-12 @endif">
                    <div class="card" style="background-image: url('{{ asset('assets/images/red-background.jpg')}}');">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="color-white">Hallo Operator !</h5>
                                    <p class="text-muted color-white">Selamat Datang di Dashboard Polres {{ $nama_polres }} - {{ $label }}</p>

                                    <div class="mt-4">
                                        @if(Auth::user()->groups()->where("name", "!=", "Admin")->first())
                                        <a target="_blank" href="{{URL::to('/perkara/create')}}" class="btn btn-light btn-sm"><i class="mdi mdi-plus-thick"></i> Data Kasus</a>
                                        @endif
                                        <a href="{{URL::to('/')}}" class="btn btn-light btn-sm"><i class="mdi mdi-home"></i> Dashboard Utama</a>
                                    </div>
                                </div>

                                <div class="col-5 ml-auto">
                                    <div>
                                        <img src="{{ asset('assets/images/widget-img.png')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- when data is narkoba --}}
                @if($label == 'Satnarkoba')
                <div class="col-xl-4">
                  <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                              <h6>Total Narkoba (gram)</h6>
                          </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/images/icon_narkoba.png')}}" alt="" class="img-fluid" style="width:40%">
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <p class="text-muted color-font-brown"><b>{{ $total_narkoba }} gram</b></p>
                        </div>
                      </div>
                  </div>
                </div>
                @endif

            </div>

            <div class="row">
              <div class="col-xl-3">
                <div class="card" style="background-image: url('{{ asset('assets/images/red-background.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">Total Kejahatan <a class="color-white" href="{{URL::to('/list-data?mode=total&&satker='.$kategori_bagian_id.'&&divisi='.$label.'&&jenis_kasus=&&tahun=&&bulan=' )}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus }}</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card" style="background-image: url('{{ asset('assets/images/blue-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <h6 class="color-white" style="font-size: 12px">Total Tunggakan <a class="color-white" href="{{URL::to('/list-data?mode=tunggakan&&satker='.$kategori_bagian_id.'&&divisi='.$label.'&&jenis_kasus=&&tahun=&&bulan=')}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus_lama }}</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card" style="background-image: url('{{ asset('assets/images/green-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                          <h6 class="color-white" style="font-size: 12px">Kejahatan Tahun {{ $year }} <a class="color-white" href="{{URL::to('/list-data?mode=perkara-tahun-ini&&satker='.$kategori_bagian_id.'&&divisi='.$label.'&&jenis_kasus=&&tahun=&&bulan=')}}" title="lihat data"><i class="mdi mdi-eye"></i></a></h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ $count_kasus_this_y }}</h5>
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card" style="background-image: url('{{ asset('assets/images/brown-bg.jpg')}}');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <h6 class="color-white" style="font-size: 12px">Persentase</h6>
                      </div>
                    </div>
                    <h5 class="mb-0 color-white">{{ number_format($percent_done, 2) }}% Selesai</h5>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">Data Perbandingan Kasus</h4>
                    <p class="card-title-desc">Perbandingan Data Kasus Selesai dan Progress Pada Tahun</p>
                    <canvas id="lineChart"></canvas>
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->

              <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">Kejahatan Index</h4>
                    <p class="card-title-desc">Berdasarkan Jenis Kejahatan</p>
                    @foreach($index_jenis_kejahatans as $key=>$index_jenis_kejahatan)
                      <hr>
                      <h6 class="card-title font-size-2">{{ $index_jenis_kejahatan->name }}</h6>
                      <p class="card-text font-size-1">{{ $index_jenis_kejahatan->total }} Kejahatan</p>
                    @endforeach
                  </div> <!-- end card-body-->
                </div> <!-- end card-->
              </div> <!-- end col -->
            </div>

            <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <h5 class="header-title mb-4">Rekapitulasi Kasus Polsek</h5>

                          <div class="table-responsive">
                              <table class="table table-centered table-hover mb-0">
                                  <thead>
                                      <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Satuan Kerja</th>
                                          <th scope="col">Kasus Selesai</th>
                                          <th scope="col">Kasus Belum Selesai</th>
                                          <th scope="col">Jumlah Kasus</th>
                                          <th scope="col">Persentase Selesai</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($rekap_polsek['rekaps'] as $key=>$item)
                                      <tr>
                                          <th scope="row">
                                              <a href="#">{{ $key + 1 }}</a>
                                          </th>
                                          <td>{{ $item['name'] }}</td>
                                          <td>{{ $item['kasus_selesai'] }}</td>
                                          <td>{{ $item['kasus_progress'] }}</td>
                                          <td>{{ $item['total'] }}</td>
                                          <td>{{ $item['kasus_selesai'] > 0 ? number_format(($item['kasus_selesai']/$item['total'])*100) : 0 }}%</td>
                                      </tr>
                                    @endforeach
                                    <tr>
                                      <td>#</td>
                                      <td style="text-align: center"><b>TOTAL</b></td>
                                      <td style="font-size: 17px"><span class="badge light badge-success">{{ $rekap_polsek['count_kasus_selesai'] }}</span></td>
                                      <td style="font-size: 17px"><span class="badge light badge-danger">{{ $rekap_polsek['count_kasus_belum_selesai'] }}</span></td>
                                      <td>{{ $rekap_polsek['count_kasus'] }}</td>
                                      <td style="background-color: #343A40"><span class="badge bg-info"></span></td>
                                    </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

          </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end page-content-wrapper -->
</div>
@endsection
@section('js')
<script>
// Row 2
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