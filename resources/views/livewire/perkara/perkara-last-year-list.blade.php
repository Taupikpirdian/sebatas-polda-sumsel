<div class="page-content-wrapper">
  <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                        <div class="col-lg-1" style="margin-right: 10px;">
                          <label style="color: #87949F">Show:</label>
                          <select wire:model='perPage' class="form-control" id="perPage" style="width: 80px">
                              <option value="10">10</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="200">200</option>
                          </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-4">
                                <label style="color: #87949F">Filter Date Range by Tanggal Lp:</label>
                                <input type="text" wire:model='query_daterange' id="query_daterange" class="form-control" data-range="true" data-multiple-dates-separator=" - " data-language="en" />
                            </div>
                        </div>
                      </div>

                      <div class="table-rep-plugin">
                          <div class="table-responsive mb-0" data-pattern="priority-columns">
                              <table id="tech-companies-1" class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 10px"></th>
                                      <th><input wire:model='query_no_lp' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      <th><input wire:model='query_tgl_lp' type="date" class="form-control" aria-describedby="button-addon2"></th>
                                      @if($role_group == 'Admin')
                                      <th><input wire:model='query_satker' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      @endif
                                      <th><input wire:model='query_petugas' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      <th><input wire:model='query_bukti' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      <th><input wire:model='query_kejadian' type="date" class="form-control" aria-describedby="button-addon2"></th>
                                      <th><input wire:model='query_pidana' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      <th><input wire:model='query_status' type="text" class="form-control" aria-describedby="button-addon2"></th>
                                      <th style="width: 10px"></th>
                                    </tr>
                                  </thead>
                                  <thead>
                                    <tr>
                                      <th style="width: 10px">#</th>
                                      <th>No LP</th>
                                      <th>Tanggal LP</th>
                                      @if($role_group == 'Admin')
                                      <th>Satker</th>
                                      @endif
                                      <th>Nama Petugas</th>
                                      <th>Barang Bukti</th>
                                      <th>Waktu Kejadian</th>
                                      <th>Jenis Pidana</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($perkaras as $i=>$perkara)
                                    <tr>
                                        <td>{{ ($perkaras->currentpage()-1) * $perkaras->perpage() + $i + 1 }}</td>
                                        <td> {{ $perkara->no_lp }} </td>
                                        <td> {{Carbon\Carbon::parse($perkara->date_no_lp)->formatLocalized('%d %B %Y')}}</td>
                                        @if($role_group == 'Admin')
                                        <td> {{ $perkara->satuan }} </td>
                                        @endif
                                        <td> {{ $perkara->nama_petugas }} </td>
                                        <td> {!! str_limit($perkara->barang_bukti, 25) !!} <a title="{{ $perkara->barang_bukti }}" href="#">[...]</a></td>
                                        <td> {{Carbon\Carbon::parse($perkara->date)->formatLocalized('%d %B %Y')}}, {{ $perkara->time }}</td>
                                        <td> {{ $perkara->pidana }} </td>
                                        @if($perkara->status_id == 1)
                                        <td><span class="badge badge-info">{{ $perkara->status }}</span></td>
                                        @else
                                        <td><span class="badge badge-success">{{ $perkara->status }}</span></td>
                                        @endif
                                      <td>
                                        <div class="btn-group mt-1 mr-1 dropleft">
                                          <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                          </button>
                                          <div class="dropdown-menu">
                                            @if($perkara->status_id != 1)
                                            @else
                                            <a class="dropdown-item" href='{{URL::action("admin\PerkaraController@edit",array($perkara->id))}}'>Update Status Perkara</a>
                                            @endif
                                            <a target="_blank" class="dropdown-item" href='{{URL::action("admin\PerkaraController@show",array($perkara->id))}}'>Detail Perkara</a>
                                            <a class="dropdown-item" href='{{URL::action("admin\PerkaraController@updateData",array($perkara->id))}}'>Edit Perkara</a>
                                            @if(Auth::user()->hasAnyRole('Delete Perkara'))
                                            <a class="dropdown-item" href="javascript:;" id="deleteForm" data-toggle="modal" onclick="deleteData({{$perkara->id}})" data-target="#DeleteModal" method="post">Hapus Perkara</a>
                                            @endif
                                          </div>
                                        </div>
                                    
                                      </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                      <form action='{{URL::action("admin\PerkaraController@destroy",array($perkara->id))}}' id="deleteForm" method="post">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Hapus Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}
                                          <p class="text-center">Data Ini Akan Terhapus Secara Permanen! Apakah Anda Yakin ?</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Ya, Hapus</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    @empty
                                        <td colspan="10" style="text-align: center">
                                          Data Kosong
                                        </td>
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <br>
                          <div class="col-md-12">
                            {{ $perkaras->links() }}
                          </div>
                          <p class="col-sm-12" style="text-align: left;"> 
                            {{ $paginate_content }}
                          </p>
                      </div>
                  </div>
              </div>
          </div> <!-- end col -->
      </div> <!-- end row -->
  </div>
  <!-- end container-fluid -->
</div>

@section('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // date range
      $('#query_daterange').daterangepicker({
        locale: {
          format: 'YYYY/MM/DD'
        },
        singleDatePicker: false,
      })
      $('#query_daterange').on('change', function (e) {
        @this.set('query_daterange', e.target.value);
      });
  });

  function deleteData(id)
  {
      var id = id;
      var url = '{{ route("perkara.destroy", ":id") }}';
      url = url.replace(':id', id);
      $("#deleteForm").attr('action', url);
  }

  function formSubmit()
  {
      $("#deleteForm").submit();
  }
</script>
@endsection