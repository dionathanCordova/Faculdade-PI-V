<!-- <html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main/login.css')?>">
</head>
<body>
     <main>
        <img src="<?php echo base_url('assets/images/bandeiraEntrada.png')?>" alt="">
        <form action="" method="POST">
            <div class='form-group'>
                <input class='form-control ' type="text" require placeholder="Usuario" name="user_login"><br>
                <input class='form-control' type="password" require placeholder="Senha" name="user_password"><br>
                <button class='btn btn-success btn-lg btn-block'>Entrar</button>
            </div> 
        </form>
    </main>
</body>
</html> -->



<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="icon" href="<?php echo base_url('/assets/images/bandeira.png')?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo base_url('/assets/images/bandeira.png')?>" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/iconic/css/material-design-iconic-font.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/animate/animate.css')?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css-hamburgers/hamburgers.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/animsition/css/animsition.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/select2/select2.min.css')?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/daterangepicker/daterangepicker.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/util.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css')?>">
<!--===============================================================================================-->
</head>
<body>

	
	<div class="limiter" style='margin-top: -20vmin'>
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form"  method='POST'>
					<span class="login100-form-title p-b-70">
						<!-- Login -->
					</span>

					<input type="hidden" name='token' id='token' value="<?php echo $_SESSION['token'] ?>">
			
					<div class="img-bandeira-login">
						<img src="<?php echo base_url('assets/images/logobrasao.png')?>" alt="AVATAR">
					</div>

					
					<?php if($tempoBloqueado == true):?>
						<div class='acessoBloqueado'>
							<div class="alert alert-warning" style='margin-top:10vmin' id='acessoBlock'>
								<strong>Warning! </strong> <span>Acesso bloqueado, tente novamente dentro de alguns minutos</span>
							</div>

							<div class="container-login100-form-btn">
								<a href="<?php echo base_url('/Home/sair')?>">
									<button class="login100-form-btn">
										Voltar
									</button>
								</a>
							</div>
						</div>
					<?php else:?>

						<div class='container'>
							<div class='acessoBloqueado' hidden>
								<div class="alert alert-warning" style='margin-top:10vmin' id='acessoBlock'>
									<strong>Warning! </strong> <span></span>
								</div>
	
								<div class="container-login100-form-btn">
									<a href="<?php echo base_url('/Home/sair')?>">
										<button class="login100-form-btn" id='tempoEspera' disabled>
											Voltar
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class='acessoLiberado'>
							<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
								<input class="input100" type="email" name="email" id='email'>
								<span class="focus-input100" data-placeholder="E-mail"></span>
							</div>

							<div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
								<input class="input100" type="password" name="password" id='password'>
								<span class="focus-input100" data-placeholder="Password"></span>
							</div>

							<div class="container-login100-form-btn">
								<button class="login100-form-btn" type='button' id='btnLogin'>
									<img src="<?php echo base_url('assets/images/loading.gif')?>" alt="" width='40vmin' id='imgloading' hidden>
									Login
								</button>
							</div>
							
							<div class='pull-center text-center'>
							
							
							</div>
							<div class="alert alert-warning" style='margin-top:1vmin' id='warning' hidden>
								<strong>Warning! </strong><span>Email ou senha incorretos</span> 
							</div>
						</div>
					<?php endif?>
					
					<!-- <ul class="login-more p-t-20">
						<li class="m-b-8">
							<span class="txt1">
								Forgot
							</span>

							<a href="<?php echo base_url('welcome/ForgotAccount');?>" class="txt2">
								Username / Password?
							</a>
						</li>

						<li>
							<span class="txt1">
								Don’t have an account?
							</span>

							<a href="<?php echo base_url('welcome/CreateAccount');?>" class="txt2">
								Sign up
							</a>
						</li>
					</ul> -->
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.2.1.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/animsition/js/animsition.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/bootstrap/js/popper.js')?>"></script>
	<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/select2/select2.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/daterangepicker/moment.min.js')?>"></script>
	<script src="<?php echo base_url('assets/vendor/daterangepicker/daterangepicker.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/vendor/countdowntime/countdowntime.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url('assets/js/main.js')?>"></script>

	<script>
     $(document).ready(function() {

		let cont = 0;
		$('#btnLogin').click(function() {
			$('#imgloading').attr('hidden', false);

			let email = $('#email').val();
			let password = $('#password').val();
			let token = $('#token').val();
			 
			if(email == '' || password == '') {
				$('#warning').attr('hidden', false);
				$('#warning span').text('Campo de Email ou Senha estão em branco ou incorretos');
			}else{
				$('#warning').attr('hidden', true);
			}
				
			url = "<?php echo base_url(); ?>Home/entrar";
			$.ajax({
				url: url,
				method:"POST",
				data: {email: email, password: password, token:token, tentativasLogin: cont},
				dataType:"json",
				success:function(data) {
					$('#imgloading').attr('hidden', true);
					console.log(data);
					if(data.redirect != null) {
						window.location = "<?php echo base_url(); ?>Home/lei";
					}

					if(data.tentativas_login == 0) {
						cont += 1;
						console.log('cont: ' + cont);
					}

					if(cont >= 6) {
						$('#warning').attr('hidden', false);
						$('.acessoLiberado').attr('hidden', true);
						$('.acessoBloqueado').attr('hidden', false);
						$('#acessoBlock span').text('Acesso bloqueado, tente novamente dentro de alguns minutos');
						
						let minutos = 0;
						let segundos = 60;

						setInterval(() => {
							if(segundos == 1) {
								minutos -= 1;
							}
							if(segundos == 1) {
								segundos = 60;
							}

							segundos -= 1;
							var seg = segundos < 10 ? '0' + segundos : segundos;
							if(minutos >= 0 && segundos >= 1) {
								console.log(segundos, seg);
								$('#tempoEspera').text(minutos + ':' + seg);
							}else if(minutos < 0) {
								$('.acessoLiberado').attr('hidden', false);
								$('.acessoBloqueado').attr('hidden', true);
							}
						}, 1000);
					}
				}
			});
		})
     })
	</script>

</body>
</html>