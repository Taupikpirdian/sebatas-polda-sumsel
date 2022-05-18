<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Aplikasi Kriminal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
		<!-- Style -->
		@include('includes.style')
		@livewireStyles
		@yield('css')
		<!-- / Style -->
    </head>

    <body data-topbar="colored">
		<!-- Modal -->
		@include('includes.modal')

        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- ========== Left Navbar Start ========== -->
    		@include('includes.navbar')
            <!-- Left Navbar End -->
            
            <!-- ========== Left Sidebar Start ========== -->
			@include('includes.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
			<div class="main-content">

				@yield('content')

				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								2020 © Xoric.
							</div>
							<div class="col-sm-6">
								<div class="text-sm-right d-none d-sm-block">
									Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
								</div>
							</div>
						</div>
					</div>
				</footer>
			</div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

		<!-- Script -->
		<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

		@livewireScripts
		@include('includes.script')
		<!-- / Script -->
		@include('sweet::alert')
		<!-- bagian sidebar -->
		<script>
		setTimeout(function() {
				$('#alert-success').fadeOut('fast');
		}, 7000);
	
		setTimeout(function() {
				$('#alert-update').fadeOut('fast');
		}, 7000);
	
		setTimeout(function() {
				$('#alert-danger').fadeOut('fast');
		}, 7000);
		</script>
		<script>
		// select2
		$("#divisi").select2();
		$("#divisi2").select2();
		$("#polres").select2();
	
		if(jQuery('#ShareProfit').length > 0 ){
			//doughut chart
			const ShareProfit = document.getElementById("ShareProfit").getContext('2d');
			// ShareProfit.height = 100;
			new Chart(ShareProfit, {
				type: 'doughnut',
				data: {
					defaultFontFamily: 'Poppins',
					datasets: [{
						data: [10, 25, 20],
						borderWidth: 3, 
						borderColor: "rgba(255, 243, 224, 1)",
						backgroundColor: [
							"rgba(58, 122, 254, 1)",
							"rgba(255, 159, 0, 1)",
							"rgba(41, 200, 112, 1)"
						],
						hoverBackgroundColor: [
							"rgba(58, 122, 254, 0.9)",
							"rgba(255, 159, 0, .9)",
							"rgba(41, 200, 112, .9)"
						]
	
					}],
					
				},
				options: {
					weight: 1,	
					 cutoutPercentage: 65,
					responsive: true,
					maintainAspectRatio: false
				}
			});
		}
		</script>
		@stack('scripts')
		@yield('js')
		
    </body>
</html>
