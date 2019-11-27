<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong>Editar / Cadastrar dados  </strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
					<div class="row">
						<div class="col-md-12 ">
							<div class="box box-primary bg-light-blue color-palette">
							<!-- <div> -->
								<div class="box-body box-profile">
									<div class="profile-main  col-sm-6 text-center">
										<?php foreach ($dados_usuario_logado as $info):?>
										<div class='bg-light-blue-active color-palette container-fluid'>
										<br>
										<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/dist/img/avatar.png')?>" alt="User profile picture">
										<!-- <img src="<?php echo base_url('assets/dist/img/avatar.png')?>" width='60' class="img-circle" alt="Avatar"> -->
										<h4 class="name profile-username text-center col-sm-12"><?php echo $info['user'];?></h4>
										<!-- <span class="online-status status-available">Available</span> -->
										<div class="col-xs-4 stat-item">
												45 <span>Diárias</span>	
											</div>
											<div class="col-xs-4 stat-item">
												15 <span>Ufms</span>
											</div>
											<div class="col-xs-4 stat-item">
												2174 <span>Total</span><br><br>
											</div>
										</div>										
									</div>
									
									<div class="profile-info bg-secondary text-white col-sm-6">
																		
										<h4 class="heading text-center">Dados Cadastrados</h4>
										<ul class="list-unstyled list-justify  bg-dark text-white"><br>
											
											<div class='pull-center conteiner-fluid'>
												<div class='col-xs-12'>
													<p class='col-xs-6 text-left'>Name</p>
													<span class=' text-right'><?php echo $info['user'];?></span>
												</div>
												<div class='col-xs-12'>
													<p class='col-xs-6 text-left'>Email</p>
													<span class=' text-right'><?php echo $info['email']?></span>
												</div>

												<div class='col-xs-12'>
													<p class='col-xs-6 text-left'>Password</p>
													<span class=' text-right'>************</span>
												</div>
												<div class='col-xs-12'>
												<div class=" col-sm-6 btn_Edit_profile "><a href="<?php echo base_url('home/editusuario/'.$_SESSION['id_user'])?>" class="btn btn-success btn-xs">Editar Perfil</a></div>
													<!-- <?php if($_SESSION['nivel'] == 5):?>
														<div class="col-sm-6 btn_Cad_profile  no-padding"><a href="#" class="btn btn-success btn-xs">Cadastrar User</a></div>
													<?php endif?> -->
												</div>
											</div>
										</div>
										</ul><br><br><br>
										<?php endforeach;?>									
										
									</div>		
										

									<!-- <div class="profile-detail no-padding">		
										<div class="profile-info text-center">
											<h4 class="heading">Social</h4>
											<ul class="list-inline social-icons">
												<li><a href="#" ><i class="fa fa-facebook"></i></a></li>
												<li><a href="#" ><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
												<li><a href="#" ><i class="fa fa-github"></i></a></li>
											</ul>
										</div>
									</div> -->

									
								</div>
							</div>
						</div>


						<div class="container col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#home">Servidores Cadastrados</a></li>
									<li><a data-toggle="tab" href="#menu1">Cadastrar Servidores</a></li>
									
									<?php if($_SESSION['nivel'] == 5):?>
									<li><a data-toggle="tab" href="#menu2">Usuarios Cadastrados</a></li>
									<li><a data-toggle="tab" href="#menu3">Cadastro de Usuários</a></li>
									<?php endif?>
								</ul>

								<div class="tab-content container-fluid">
									<div id="home" class="tab-pane fade in active">
										<?php if($_SESSION['nivel'] == 5):?>
										<form class="form-inline" action="" method="POST">
											<div class="form-group">
												<option value="">Secretaria</option>
												<select class='form-control' type="text" name="id_select_secretaria" required>
													<?php echo $secretaria; ?>
												</select>
												<a href="/home/inicio"><button class='btn btn-success btn-md'><span class='	glyphicon glyphicon-search'></span></button> </a>
											</div>
										</form>
										<?php endif?>
										<div class="post">
											<table class="table project-table usuarios-registrad table-responsive">
												<thead>
													<tr>
														<th>Nome Completo</th>
														<th>Cargo</th>														
														<th>Matricula</th>														
														<th>CPF</th>
														<th>Banco</th>														
														<th>Agencia</th>
														<th>Conta</th>
														<th>Telefone</th>											
														<!-- <th>Veículo Oficial</th> -->
													</tr>
												</thead>
												<tbody>
													<?php foreach($dados_servidores_geral as $info2):?>
													<tr>
														<td><?php echo $info2['nome']?></td>		
														<td><?php echo $info2['cargo']?></td>	
														<td><?php echo $info2['matricula']?></td>		
														<td><?php echo $info2['cpf']?></td>	
														<td><?php echo $info2['banco']?></td>		
														<td><?php echo $info2['agencia']?></td>	
														<td><?php echo $info2['cc']?></td>		
														<td><?php echo $info2['telefone']?></td>	
														<!-- <td><?php echo $info2['veiculos']?></td> -->																											
														<td>
															<form action="<?php echo base_url('home/profile')?>" method='POST'>
																<button class='btn btn-danger btn-xs btn-delete-user' name='delete_servidor' value='<?php echo $info2['id_servidor']?>'>DELETE</button>
															</form>
														</td>
														<td><a href="<?php echo base_url('home/editarservidor/'.$info2['id_servidor'])?>"><button class='btn btn-primary btn-xs id_user_altera' name='user' value='<?php echo $info2['id_servidor']?>'>EDITAR CADSTRO</button></a></td>
													
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>

										<div>
											<ul class="list-inline">
												<!-- <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
												<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a></li> -->
												<li class="pull-right">
													<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Usuários <span class="badge"><?php echo $count_servidores;?></span></a>
												</li>
												<!-- <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments (5)</a></li> -->
											</ul>
										</div>
									</div>

									<div id="menu1" class="tab-pane fade">
										<form action="<?php echo base_url('home/CreateServidores');?>" method="POST" class='form_diaria col-sm-12'>                                        
																				
											<?php if(isset($secretaria_selecionada) && $_SESSION['nivel'] == 5) :?>
											<div class="form-group col-sm-12">
												<div class="alert alert-success alert-dismissible col-sm-12">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
													<h4><i class="icon fa fa-ban"></i> Alert!</h4>
													<?php echo "Secretaria Selecionada: " . $secretaria_selecionada['secretaria_nome']?>
												</div>
											</div>
											<?php endif?>

											<?php if($_SESSION['nivel'] == 5): ?>
												<div class="form-group container-fluid">
													<label for="servidor">Secretaría de Dotação: </label><br>
													<select class='form-control' type="text" name="id_select_secretaria" required>
														<?php echo $secretaria; ?>
													</select>
												</div>                 
											<?php endif?>

											<div class='col-sm-6 form-group'>                                             

												<div class="form-group">
													<label for="servidor">Nome Completo: </label><br>
													<input class='form-control' type="text" name="nome" placeholder="Nome Completo" required>
												</div>              

												<div class='form-group'>
													<label for="estado_destino">E-mail: </label>
													<input class='form-control' type="text" name="email" placeholder="Email" required>
												</div>
									
												<!-- <div class="form-group">
													<label for="veiculo">Veículo Ofificial Designado: </label>
													<input type="radio" id='Cadastrar' name='Cadastrar' style='margin-left:3vmin'> <label for="Cadastrar"> Cadastrar</label>
													<input type="radio" id='Selecionar' name='Selecionar'> <label for="Selecionar"> Selecionar</label></label><br>
													<p class='select'>
														<select class='form-control' name="veiculo" id="veiculo">
															<?php echo $veiculo?>
														</select>
														<span id='campovazio' style='color:red; display:none'>Favor Informar o Veículo</span>
													</p>
													<p class='cadastro' style='display:none'>
														<input class='form-control' type="text" name='veiculo' id="veiculo" placeholder='Informe Modelo e Placa ex: Gol MMM - 1111'>
													</p>
												</div> -->

												<div class="form-group">
													<label for="veiculo">Veículo Ofificial Designado: </label>
													<input type="radio" id='cargo-motorista' name='Cadastrar' style='margin-left:3vmin'> <label for="Cadastrar"> Vincular veículo</label>
													<input type="radio" id='cargo-outros' style='margin-left:1vmin' checked> <label for="Selecionar"> Não vincular </label></label><br>
													
													<div class='cargo-motorista col-xs-12 form-group' style='display:none'>
														<div class='col-xs-6'>
															<input class='form-control col-xs-6' type="text" name='modelo' id="modelo" placeholder='Informe Modelo e Placa ex: Gol'>
														</div>
														<div class='col-xs-6'>
															<input class='form-control col-xs-6' type="text" name='placa' id="placa" placeholder='Informe Placa ex: MMM - 1111'>
														</div>
													</div>

													<p class='cargo-outros'>
														<input class='form-control' type="text" name='veiculo' disabled id="veiculo" placeholder='Veiculos são adicionados apenas para Motoristas'>
													</p>
												</div>											
												

												<div class="form-group">  
													<label for="curso">Cargo: </label>
													<input class='form-control' type="text" name="cargo" placeholder="Cargo" required>
												</div>
												
												<div class="form-group">  
													<label for="curso">Matricula: </label>
													<input class='form-control' type="text" name="matricula" placeholder="Matricula"  required>
												</div>
											</div>

											<div class='col-sm-6 form-group'>

											
												<div class="form-group">  
													<label for="curso">Banco: </label>
													<input class='form-control' type="text" name="banco" placeholder="Banco" required>
												</div>	

												<div class="form-group">  
													<label for="curso">Conta: </label>
													<input class='form-control' type="text" name="cc" placeholder="Conta" required>
												</div>												
										
												<div class="form-group">  
													<label for="curso">Agencia: </label>
													<input class='form-control' type="text" name="agencia" placeholder="Agencia"  required>
												</div>
											
												<div class="form-group">  
													<label for="curso">Telefone: </label>
													<input class='form-control' type="text" name="telefone" id="TELEFONE" placeholder="Telefone"  required>
												</div>
										
												<div class="form-group">  
													<label for="curso">CPF: </label>
													<input class='form-control' type="text" name="cpf" id='CPF' placeholder="CPF" required>
												</div>												
												                                        
											</div>		

											<div class="form-group col-sm-12">
												<a href="#"><button class='btn btn-success submit'>Enviar</button></a><br><br>
											</div>   
										</form>
									</div>

									<div id="menu2" class="tab-pane fade">
										<?php if($_SESSION['nivel'] == 5):?>
										<div class="post">
											<table class="table project-table usuarios-registrad table-responsive" >
												<thead>
													<tr>
														<th>Usuário</th>
														<th>E-mail</th>
														<?php if($_SESSION['nivel'] == 5):?>  
														<th>Delete</th>														
														<th>Atualizar</th>
														<?php endif?>
													</tr>
												</thead>
												<tbody>
													<?php foreach($dados_usuarios_geral as $info2):?>
													<tr>
														<td><a href="#"><img src="<?php echo base_url('assets/dist/img/avatar-null-mini.png')?>" alt="Avatar" class="avatar img-circle"> <a href="#"><?php echo $info2['user'];?></a></td>
														<td><?php echo $info2['email']?></a></td>	
														<?php if($_SESSION['nivel'] == 5):?>  													
														<td>
															<form action="<?php echo base_url('home/profile')?>" method='POST'>
																<?php if($_SESSION['usuario'] == $info2['user']):?> 
																<button class='btn btn-danger btn-xs btn-delete-user' disabled name='delete_user'  value='<?php echo $info2['id_usuario']?>'>DELETE</button>
																<?php else:?>
																<button class='btn btn-danger btn-xs btn-delete-user'  name='delete_user' value='<?php echo $info2['id_usuario']?>'>DELETE</button>
																<?php endif ?>
															</form>
														</td>
														<td><a href="<?php echo base_url('home/editusuario/'.$info2['id_usuario'])?>"><button class='btn btn-primary btn-xs id_user_altera' name='user' value='<?php echo $info2['id_usuario']?>'>EDITAR CADSTRO</button></a></td>
														<?php endif?>
													</tr>
													<?php endforeach;?>
												</tbody><br>						
											</table>
										</div>
										<ul class="list-inline">
											<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
											<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a></li>
											<li class="pull-right">
												<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Usuários <span class="badge"><?php echo $count_users;?></span></a></li>
												<!-- <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments (5)</a></li> -->
										</ul>
										<?php endif?>
									</div>


									<div id='menu3' class='tab-pane fade'>
										<form class="form-horizontal" action="<?php echo base_url('home/CreateAccount')?>" method='POST'>
											<div class="form-group">
												<label for="inputName" class="col-sm-2 control-label">User</label>

												<div class="col-sm-4">
													<input class='form-control' type="text" name="user" placeholder="User" required>
												
												</div>
											</div>

											<div class="form-group">
												<label for="inputEmail" class="col-sm-2 control-label">Email </label>

												<div class="col-sm-4">
													<input class='form-control' type="text" name="email" placeholder="Email" required>
												
												</div>
											</div>

											<div class="form-group">
												<label for="inputExperience" class="col-sm-2 control-label">Password</label>

												<div class="col-sm-4">
													<input class='form-control' type="password" name="password" placeholder="Password" required>
												</div>
											</div>

											
											<div class="form-group">
												<label for="inputExperience" class="col-sm-2 control-label">Password</label>

												<div class="col-sm-4">
													<input type="password" class="form-control" name='re-password' value="<?php echo isset($dados_usuario_logado) ? $dados_usuario_logado[0]['password'] : ''?>" >
												</div>
											</div>

											<?php if($_SESSION['nivel'] == 5):?>
											<div class="form-group">
												<label for="inputSkills" class="col-sm-2 control-label">Secretaría de Dotação</label>

												<div class="col-sm-4">
													<select class='form-control' type="text" name="id_secretaria" required>
														<?php echo $secretaria; ?>
													</select>
												</div>
											</div>
											<?php endif?>

											<div class="form-group col-sm-12">
												<a href="#"><button class='btn btn-success submit'>Enviar</button></a><br><br>
											</div> 

										</form>		
									</div>

								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
    $(document).ready(function(){
		$('.id_user_altera').click(function(data) {
			var id_user_altera = $('.id_user_altera').val();
						
			$.post('profile', {id: id_user_altera}, function(result) {
				console.log(result);
				$('.teste').html(result);
			})
		})    

		// VEICULO INPUT
		$('#Cadastrar').on('change', function() {
			$('.select').hide();
			$('.cadastro').show();
			$('#Selecionar').prop('checked', false);
		})

		// VEICULO IMPUT
		$('#Selecionar').on('change', function() {
			// $('.select').attr('display', 'block');
			$('.cadastro').hide();
			$('.select').show();
			$('#Cadastrar').prop('checked', false);
		})

		// CRIAÇÂO DE NOVO CADASTRO DE USER
		$(".submit-novaconta").click(function() {
			if($(".re-password").val() != $(".password").val()){
				$("#campovazio").css("display", "inline").fadeOut(3000);				
				return false;
			}
		});

		$('.btn-delete-user').click(function() {
			var r = confirm("Deseja realmente deletar este usuário");
			if (r == false) {
				return false
			}
		});    

		// MASCARA PARA O CPF DO CADASTRO DO MODAL
        $('#CPF').keyup(function() {
            $('#CPF').inputmask({
                // mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                mask: ["999.999.999-99"],
                keepStatic: true
            });
        });

        $('#TELEFONE').keyup(function() {
            $('#TELEFONE').inputmask({
                mask: ["(99) 9999-9999", "(99) 9 9999-9999", ],
                keepStatic: true
            });
        });

		$('#placa').keyup(function() {
			$(this).inputmask({
				mask: ['AAA - 9999'],
				keepStatic: true
			})			
		})

		// INPUT DE VEICULO NO CASO DE CARGO MOTORISTA OU OUTROS
		$('#cargo-motorista').on('change', function() {
			$('.cargo-motorista').show();
			$('#cargo-outros').prop('checked', false)
			$('.cargo-outros').hide();
		})

		$('#cargo-outros').on('change', function() {
			$('.cargo-outros').show();
			$('#cargo-motorista').prop('checked', false)
			$('.cargo-motorista').hide();
		})
		// FIM
    });
</script>
