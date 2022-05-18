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
                      <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $label }}</a></li>
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
                  <div class="card-header">
                    <div class="row">
                      <div class="col-lg-3">
                        {!! Form::open(['method'=>'GET','url'=>'/grouping/export_excel','role'=>'search'])  !!}
                          <input type="text" class="form-control float-left" name="mode" value="{{ $mode }}" style="display:none">
                          <button title="Download Data" type="submit" class="btn btn-sm btn-info float-left">Download Data Rekapitulasi</button>
                        {!! Form::close() !!}
                      </div>
                      {{-- <div class="col-lg-6">
                        {!! Form::open(['method'=>'GET','url'=>'/search-rekapitulasi','role'=>'search'])  !!}
                          <div class="input-group" style="float: left; width: 300px; margin-right: 10px">
                            <input type="text" class="form-control float-left" name="search" placeholder="Satuan Kerja .....">
                          </div>
                          <button title="Pencarian" style="float: left; margin-right: 5px" class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        {!! Form::close() !!}
                      </div> --}}
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-responsive-md">
                        <thead>
                          <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 200px">SATKER/SATWIL/DIVISI</th>
                            <th style="width: 200px">Kasus Selesai</th>
                            <th style="width: 200px">Kasus Belum Selesai</th>
                            <th style="width: 200px">Jumlah Kasus</th>
                            <th style="width: 200px">Persentase Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($rekaps as $i=>$grouping)
                            <tr>
                              <td>{{ $i + 1 }}</td>
                              <td>{{ $grouping->name }}</td>
                              <td>{{ $grouping->kasus_selesai }}</td>
                              <td>{{ $grouping->kasus_progress }}</td>
                              <td>{{ $grouping->total }}</td>
                              <td>{{ $grouping->kasus_selesai > 0 ? number_format(($grouping->kasus_selesai/$grouping->total)*100) : 0 }}%</td>
                            </tr>
                            @endforeach
                            <tr>
                              <td>#</td>
                              <td style="text-align: center"><b>TOTAL</b></td>
                              <td style="font-size: 17px"><span class="badge light badge-success">{{ $count_kasus_selesai }}</span></td>
                              <td style="font-size: 17px"><span class="badge light badge-danger">{{ $count_kasus_belum_selesai }}</span></td>
                              <td>{{ $count_kasus }}</td>
                              <td style="background-color: #343A40"><span class="badge bg-info"></span></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- end container-fluid -->
  </div>
  <!-- end page-content-wrapper -->
</div>

@endsection