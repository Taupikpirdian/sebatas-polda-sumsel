@extends('layouts.login')

@section('content')
<div class="account-pages my-2 pt-sm-2">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center mb-4">
					<a href="index.html" class="logo"><img src="assets/images/logo-poldasumsel.png" height="120" alt="logo"></a>
					<a href="index.html" class="logo"><img src="assets/images/logo-bareskrim.png" height="120" alt="logo"></a>
					<a href="index.html" class="logo"><img src="assets/images/maskot.png" height="120" alt="logo"></a>
				</div>
				<div class="text-center mb-3">
					<h5 class="font-size-16 text-white-50 mb-4">Aplikasi Kriminal</h5>
				</div>
			</div>
		</div>
		<!-- end row -->

		<div class="row justify-content-center">
			<div class="col-xl-5 col-sm-8">
				<div class="card">
					<div class="card-body p-4">
						<div class="p-2">
							<h5 class="mb-5 text-center">Sign in to continue.</h5>
							<form method="POST" action="{{ route('login') }}">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
										<div class="form-group form-group-custom mb-4">
											<input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
											@if ($errors->has('email'))
												<span class="help-block">
													<strong>{{ $errors->first('email') }}</strong>
												</span>
											@endif
											<label for="username">Email</label>
										</div>

										<div class="form-group form-group-custom mb-4">
											<input type="password" class="form-control" name="password" placeholder="Password" required>
											@if ($errors->has('password'))
												<span class="help-block">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
											<label for="userpassword">Password</label>
										</div>
									
										<div class="mt-4">
											<button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
</div>
@endsection
