<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">                
                <h3 class="box-title"><strong> Alterar dados da ninha conta</strong></h3>
                <a href="<?php echo base_url('home/profile')?>"><button class='pull-right btn btn-primary'>voltar</button></a>
            </div>
                <div class="box-body">
                    <div class="panel box box-primary"> 
                        
                    <br>
					<div class="panel-body no-padding">
						<div class='col-sm-12 '>
							<div class=''>
                                <div class=' no-padding'>
                                    <form action="<?php echo base_url('home/editusuario/'.$id_usuario)?>" method='POST' class='form_diaria col-sm-12'>
                                        <div class='col-sm-6 form-group'>
                                           <div class="form-group">
                                                <label for="servidor">Novo nome de Usuário: </label><br>
                                                <input class='form-control' type="text" name="user" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['user'] : ''?>" required>
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Nova Senha: </label>
                                                <input class='form-control' type="password" name='password' id='password'  placeholder="********">
                                            </div>
                                            <h5 id='campovazio' style='color:red; display:none'>As senhas não estão compatíveis</h5>

                                            <?php if($_SESSION['nivel'] == 5):?>											
                                            <div class="form-group">
                                                <label for="servidor">Secretaría de Dotação: </label><br>
                                                <select class='form-control' type="text" name="fundo" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['id_secretaria']: ''?>">
                                                    <?php echo $secretaria; ?>
                                                </select>
                                            </div> 
											<?php endif?>
                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            <div class='clearfix'></div>
                                            
                                            <div class="form-group">                
                                                <label for="servidor">E-mail: </label><br>
                                                <input class='form-control' type="text" name="email" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['email']: ''?>" required>
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Confirme a Senha: </label>
                                                <input class='form-control' type="password" name='re-password' id='re-password' placeholder="********">
                                            </div>
                                        </div>
                                                                                 
                                        <div class="form-group  col-sm-7">
                                            <a href="#"><button class='btn btn-success submit-novaconta' name='submit'>Enviar</button></a><br><br>
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

<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
    $(document).ready(function(){
		

		$(".submit-novaconta").click(function() {
			if($("#re-password").val() != $("#password").val()){
				$("#campovazio").css("display", "inline").fadeOut(5000);				
                return false;
			}          
		});   

    
    });
</script>