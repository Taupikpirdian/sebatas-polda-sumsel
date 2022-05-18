<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<!-- datepicker -->
<script src="{{asset('assets/libs/air-datepicker/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/air-datepicker/js/i18n/datepicker.en.js')}}"></script>
{{-- daterange --}}
<!-- momment js is must -->
<script src="{{ asset('assets/vendor/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- apexcharts -->
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<script src="{{asset('assets/libs/jquery-knob/jquery.knob.min.js')}}"></script> 

<!-- Jq vector map -->
<script src="{{asset('assets/libs/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/libs/jqvmap/maps/jquery.vmap.usa.js')}}"></script>

<script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<!-- Sweet Alerts js -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Sweet alert init js-->
<script src="{{asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
<script type="text/javascript">
  if ("{{Session::get('flash-store')}}") {
      Swal.fire({
        title: 'Good job!',
        text: '{{Session::get('flash-store')}}',
        icon: 'success',
        confirmButtonColor:"#f46a6a",
        cancelButtonColor:"#3051d3"
      })
  }

  if ("{{Session::get('flash-update')}}") {
      Swal.fire({
        title: 'Good job!',
        text: '{{Session::get('flash-update')}}',
        icon: 'success',
        confirmButtonColor:"#f46a6a",
        cancelButtonColor:"#3051d3"
      })
  }

  if ("{{Session::get('flash-error')}}") {
      Swal.fire({
        title: 'Gagal!',
        text: '{{Session::get('flash-error')}}',
        icon: 'error',
        confirmButtonColor:"#f46a6a",
        cancelButtonColor:"#3051d3"
      })
  }
</script>

<!-- Chart JS -->
<script src="{{asset('assets/libs/chart.js/Chart.bundle.min.js')}}"></script>
{{-- <script src="{{asset('assets/js/pages/chartjs.init.js')}}"></script> --}}

<!-- Selectize -->
<script src="{{asset('assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
@yield('js')