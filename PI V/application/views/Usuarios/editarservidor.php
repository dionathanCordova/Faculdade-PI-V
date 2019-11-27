<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">                
                  <h3 class="box-title"><strong> Editar Servidor</strong></h3>
                  <a href="<?php echo base_url('home/profile')?>"><button class='pull-right btn btn-primary'>voltar</button></a>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
					<div class="panel-body no-padding">
						<div class='col-sm-12 '>
							<div class=''>
                                <div class=' no-padding'>
                                    <form action="<?php echo base_url('home/editarservidor/'.$id_usuario)?>" method='POST' class='form_diaria col-sm-12'>
                                        <div class='col-sm-6 form-group'>
                                           <div class="form-group">
                                                <label for="servidor">Nome Completo: </label><br>
                                                <input class='form-control' type="text" name="nome" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['nome'] : ''?>" required>
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Cargo: </label>
                                                <input class='form-control' type="text" name='cargo' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['cargo']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Banco: </label>
                                                <input class='form-control' type="text" name='banco' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['banco']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Conta: </label>
                                                <input class='form-control' type="text" name='cc' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['cc']: ''?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="veiculo">Veículo Ofificial Designado: </label>
                                                <input type="radio" id='cargo-motorista' name='Cadastrar' style='margin-left:3vmin'> <label for="Cadastrar"> Cargo motorista</label>
                                                <input type="radio" id='cargo-outros' style='margin-left:3vmin'> <label for="Selecionar"> Outros </label></label><br>
                                                
                                                <div class='cargo-motorista col-xs-12 form-group' style='display:none'>
                                                    <div class='col-xs-6'>
                                                        <input class='form-control col-xs-6' type="text" name='modelo' id="modelo" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['modelo']: ''?>" placeholder='Informe Modelo e Placa ex: Gol'>
                                                    </div>
                                                    <div class='col-xs-6'>
                                                        <input class='form-control col-xs-6' type="text" name='placa' id="placa" value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['placa']: ''?>" placeholder='Informe Placa ex: MMM - 1111'>
                                                    </div>
                                                </div>

                                                <p class='cargo-outros'>
                                                    <input class='form-control' type="text" name='veiculo' disabled id="veiculo" placeholder='Veiculos são adicionados apenas para Motoristas'>
                                                </p>
                                            </div>	
                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            <div class='clearfix'></div>                                            
                                            <div class='form-group'>
                                                <label for="matricula">Matricula: </label>
                                                <input class='form-control' type="text" name='matricula' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['matricula']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">CPF: </label>
                                                <input class='form-control' type="text" name='cpf' id='CPF' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['cpf']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Agencia: </label>
                                                <input class='form-control' type="text" name='agencia' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['agencia']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Telefone: </label>
                                                <input class='form-control' type="text" name='telefone' id='TELEFONE' value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['telefone']: ''?>">
                                            </div>

                                            <div class='form-group'>
                                                <label for="estado_destino">E-mail: </label>
                                                <input class='form-control' type="text" name="email" placeholder="Email"  value="<?php echo isset($postinmemoria) ? $postinmemoria[0]['telefone']: ''?>">
                                            </div>

                                            
                                        </div>                                      
                                            <div class="form-group col-sm-8">
												<div class="col-sm-offset-20 col-sm-10">
												<button type="submit" class="btn btn-danger">Submit</button>
												</div>
											</div>
                                        </fieldset>
                                      
                                           

                                            <br><br> <br><br> <br><br>

                                       
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
				$("#campovazio").css("display", "inline").fadeOut(3000);				
                return false;
			}          
		});

        $(".submit").click(function() {
            if($("#veiculo").val() == 'Selecione o veículo:' || $("#veiculo").val() ==""){
                $("#campovazio").css("display", "inline").fadeOut(3000);
            
                return false;
            }
        });

        $('#Cadastrar').on('change', function() {
            $('.select').hide();
            $('.cadastro').show();
            $('#Selecionar').prop('checked', false);
        })

        $('#Selecionar').on('change', function() {
            // $('.select').attr('display', 'block');
            $('.cadastro').hide();
            $('.select').show();
            $('#Cadastrar').prop('checked', false);
        })

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