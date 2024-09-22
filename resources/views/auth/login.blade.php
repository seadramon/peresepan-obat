<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Medication Prescribing</title>

  	<!-- Google Font: Source Sans Pro -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  	<!-- icheck bootstrap -->
  	<link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  	<!-- Theme style -->
  	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
	<div class="container" id="container">
		<div class="form-container sign-in-container">
			<form method="post" action="{{ route('login.custom') }}" id="sign-in-container">
				@csrf
				<div class="hide" id="forgot">
					<div class="enter-email">
						<div class="enter-email-detail">
							<h1>Do you forgot ?</h1>
							<p>Just enter your email to retrieve your password</p>
							<div class="account-input ">
								<i class="far fa-envelope"></i>
								<input type="email" placeholder="Email" />
							</div>
							<div class="">
								<button class="signIn-form-button">Send</button>
							<p id="slideup" style="cursor: pointer"><u>close</u></p>
							</div>
							
						</div>
					</div>
				</div>
				<h1>Medication Prescribing</h1>
				
				<span style="margin-top: 10px;">Masuk untuk mengelola Peresepan Anda</span>

				<!-- Notifikasi -->
				@error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: red;">{{ $message }}</strong>
                    </span>
                @enderror
				<!-- ./notifikasi -->

				<div class="account-input ">
					<i class="far fa-envelope"></i>
					<input type="email"  name="email" placeholder="Email" />
				</div>
				<div class="account-input" style="margin-bottom: 10px;">
					<i class="fas fa-lock"></i>
					<input type="password" name="password" placeholder="Password" />
				</div>
				<!-- <p class="forgot" id="slidedown" > Forgot your password? </p> -->
				<button type="submit" class="signIn-form-button">Masuk</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="square"></div>
				<div class="triangle"></div>
				<div class="circle"></div>
				<div class="square2"></div>
				<div class="triangle2"></div>
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<!-- <button class="ghost" id="signIn">Sign In</button> -->
					
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hello, Friend!</h1>
					<p>Enter your personal details and start journey with us</p>
					<!-- <button class="ghost" id="signUp">Sign Up</button> -->
				</div>
				
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
	<script type="text/javascript">
		$('#slideup').click(function(){
			$('#forgot').slideUp(500);
			
		})
		$('#slidedown').click(function(){
			$('#forgot').slideDown(500);
			
		})

		const signUpButton = document.getElementById('signUp');
		const signInButton = document.getElementById('signIn');
		const forgot = document.getElementById('forgot');
		const container = document.getElementById('container');
		
		forgot.addEventListener('click', () => {
			container.classList.add("left-panel-active");
		});

		signUpButton.addEventListener('click', () => {
			container.classList.add("right-panel-active");
		});

		signInButton.addEventListener('click', () => {
			container.classList.remove("right-panel-active");
		});

	</script>
</body>
</html>