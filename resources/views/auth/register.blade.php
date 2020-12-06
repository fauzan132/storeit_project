<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('login_assets/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/images/icons/favicon.ico') }}vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('login_assets/images/img-01.png') }}" alt="IMG">
				</div>
                @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Login') }}">
                @csrf
					<span class="login100-form-title">
						Daftar
					</span>
                    <div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
						<input class="input100 form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukan nama anda">
                        @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                        
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukan email anda">
                        @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                        
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Must be Telephone Format">
						<input class="input100 form-control{{ $errors->has('telp') ? ' is-invalid' : '' }}" id="telp" type="text" name="telp" value="{{ old('telp') }}" required autofocus placeholder="Masukan No. Telephone">
                        @if ($errors->has('telp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telp') }}</strong>
                                    </span>
                                @endif
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</span>
                        
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" name="password" required placeholder="Masukan kata sandi anda">
                        @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
						<input class="input100 form-control" id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Konfirmasi kata sandi anda">

						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
  <label class="col-md-4 control-label">Pilih Role</label> 
  <div class="col-md-6">
	<select name="role" class="form-control">
		<option value="Admin">Admin</option>
		<option value="Public">Public</option>
		<option value="Expert ITB">Expert ITB</option>
		<option value="Expert EWINDO">Expert EWINDO</option>
		<option value="Expert BALITSA">Expert BALITSA</option>
	</select>
	</div>
</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Daftar
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
                        </span>
                        @if (Route::has('password.request'))
                        <a class="txt2" href="{{ route('password.request') }}">
							Password?
						</a>
                        @endif
						
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="{{ route('login') }}">
							Sudah memiliki akun? klik disini
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset('login_assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('login_assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="{{ asset('login_assets/js/main.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>