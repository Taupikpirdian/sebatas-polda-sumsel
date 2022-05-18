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
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Logs Data</a></li>
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
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>No LP</th>
                                        <th>Akun</th>
                                        <th>Waktu</th>
                                        <th>Aktivitas</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($logs as $key=>$log)
                                        <tr class="btn-reveal-trigger">
                                          <td class="py-2">
                                            <a href="#">{{ $log->no_lp }}</a>
                                          </td>
                                          <td class="py-2">{{ $log->name }}</td>
                                          <td class="py-2">{{ $log->age_of_data }}</td>
                                          @if($log->status == 1)
                                          <td class="py-2"><span class="badge light badge-primary">Menambahkan data Crime</span></td>
                                          @elseif($log->status == 2)
                                          <td class="py-2"><span class="badge light badge-info">Update status Crime</span></td>
                                          @elseif($log->status == 3)
                                          <td class="py-2"><span class="badge light badge-danger">Edit data Crime</span></td>
                                          @elseif($log->status == 4)
                                          <td class="py-2"><span class="badge light badge-success">Update anggaran Crime</span></td>
                                          @endif
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="col-md-12">
                              {{ $logs->links() }}
                            </div>
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
@section('js')
@endsection