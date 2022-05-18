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
                      <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                  </ol>
              </div>
          </div>

      </div>
  </div>
  <div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                          <div class="col-8">
                            <a title="Tambah Data" href="{{URL::to('/user/create')}}" class="btn btn-info waves-effect waves-light mb-2"><i class="fa fa-plus-circle" aria-hidden="true"></i>   Tambah Data</a>
                          </div>
                            <div class="col-3 text-right" style="left: 30px">
                              <form url="/user/index" method="get">
                              <input type="text" class="form-control" name="search" placeholder="Cari data ...">
                            </div>
                            <div class="col-1 text-right">
                              <button class="btn btn-info waves-effect waves-light mb-2"><i class="fa fa-search" aria-hidden="true"></i></button>
                              </form>
                            </div>
                        </div>

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Lembaga</th>
                                        <th>Divisi</th>
                                        <th style="width: 50px">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($users as $i=>$user)
                                      <tr>
                                        <td>{{ ($users->currentpage()-1) * $users->perpage() + $i + 1 }}</td>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td>
                                        <td> {{ $user->group_name }} </td>
                                        <td> {{ $user->divisi }} </td>
                                        <td>
                                          <div class="btn-group mt-1 mr-1 dropleft">
                                            <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href='{{URL::action("admin\UserController@edit",array($user->id))}}'>Edit</a>
                                                <a class="dropdown-item" href="javascript:;" id="deleteForm" data-toggle="modal" onclick="deleteData({{$user->id}})" data-target="#myModal" method="post">Delete</a>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                      <!-- Modal -->
                                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                        <form action='{{URL::action("admin\UserController@destroy",array($user->id))}}' id="deleteForm" method="post">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <h5 class="mt-0" style="align:center;">WARNING !!!</h5>
                                              <p>Data Ini Akan Terhapus Secara Permanen! Apakah Anda Yakin ?</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                              <button type="button" class="btn btn-danger" onclick="formSubmit()">Delete</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- End Modal -->
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- end container-fluid -->
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  function deleteData(id)
  {
      var id = id;
      var url = '{{ route("user.destroy", ":id") }}';
      url = url.replace(':id', id);
      $("#deleteForm").attr('action', url);
  }

  function formSubmit()
  {
      $("#deleteForm").submit();
  }
</script>
@endsection