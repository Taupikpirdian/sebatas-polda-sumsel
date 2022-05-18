@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="page-content">

  <!-- Page-Title -->
  <div class="page-title-box">
      <div class="container-fluid">
          <div class="row align-items-center">
              <div class="col-md-8">
                  <h4 class="page-title mb-1">SEBATAS</h4>
                  <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                  </ol>
              </div>
          </div>

      </div>
  </div>
  <!-- end page title end breadcrumb -->
  @livewire('dashboard.perkara-modal', ['params' => $params])
  <!-- end page-content-wrapper -->
</div>
@endsection
@section('js')
@endsection