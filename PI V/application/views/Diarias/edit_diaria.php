<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
    $(document).ready(function(){

        $('#estado_destino').change(function() {
            var estado_destino = $('#estado_destino').val();
            // var url = $('.form_diaria').attr('action');
            var url = $('.url').html();
        
            $('#cidade_destino').html('<option>Carregando...</option>');

            $.post(url, {
                estado: estado_destino
            }, function(data) {
                $('#cidade_destino').html(data);
            })
        });

        $('#estado_destino2').change(function() {
            var estado_destino = $('#estado_destino2').val();
            // var url = $('.form_diaria').attr('action');
            var url = $('.url').html();

            $('#cidade_destino2').html('<option>Carregando...</option>');

            $.post(url, {
                estado: estado_destino
            }, function(data) {
                $('#cidade_destino2').html(data);
            })
        });

        $('#id_select_secretaria').change(function() {
            var servidor = $('#id_select_secretaria').val();
            console.log(servidor);
            // var url = $('.form_diaria').attr('action');
            var url = '/Diarias/servidores_option';

            $('#id_servidor').html('<option>Carregando...</option>');

            $.post(url, {
                servidor: servidor
            }, function(data) {
                $('#id_servidor').html(data);
            })
        });
    });
</script>
<p class='url' style='display:none'><?php echo base_url('home/municipio');?></p>
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong> Editar Diária </strong></h3>
                  <a href="<?php echo base_url('Diarias/diarias')?>"><button class='pull-right btn btn-primary btn-xs'>Voltar</button></a>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
                    <div class="panel-body no-padding">
                        <!--  -->
                    </div>

                    <div class="container col-md-12">
                        <form action="<?php echo base_url('Diarias/edit_diaria/'.$id_diaria);?>" method="POST" class='form_diaria col-sm-12'>                                        
                            <?php if($msg != '') :?>
                            <div class="form-group col-sm-12">
                                <div class="alert alert-danger alert-dismissible col-sm-12">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    <?php echo $msg?>
                                </div>
                            </div>
                            <?php endif?>

                            <div class='col-sm-6 form-group'>
                                <div class="form-group">
                                    <label for="servidor">Nome do Servidor: </label><br>
                                    <input class='form-control' type="text" name="servidor" value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['servidor'] : ''?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Telefone do Servidor::</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="telefone"  data-inputmask='"mask": "(99) 9 9999-9999"' data-mask  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['telefone'] : ''?>" required>
                                    </div>
                                </div>

                                <div class="form-group">                
                                    <label for="servidor">Banco: </label><br>
                                    <input class='form-control' type="text" name="banco" value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['banco'] : ''?>" required>
                                </div>

                                <div class="form-group">  
                                    <label for="servidor">Agência: </label><br>
                                    <input class='form-control' type="text" name="agencia"  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['agencia'] : ''?>"required>
                                </div>

                                <div class="form-group">  
                                    <label for="servidor">Conta: </label><br>
                                    <input class='form-control' type="text" name="conta"  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['conta'] : ''?>"required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="veiculo">Veículo: </label>
                                    <input type="radio" id='oficial' name='Cadastrar' style='margin-left:2vmin' checked> <label for="Cadastrar"> Oficial</label>
                                    <input type="radio" id='particular' style='margin-left:1vmin'> <label for="Selecionar"> Particular / Outros </label></label><br>
                                    
                                    <div class='oficial col-xs-12 form-group'>
                                        <div class='col-xs-6'>
                                            <input class='form-control col-xs-6' type="text" name='modelo' id="modelo2" placeholder='Modelo ex: Gol'>
                                        </div>
                                        <div class='col-xs-6'>
                                            <input class='form-control col-xs-6' type="text" name='placa' id="placa2" placeholder='Placa ex: MMM - 1111'>
                                        </div>
                                    </div>

                                    <p class='particular' style='display:none'>
                                        <input class='form-control' type="text" name='veiculo' disabled id="veiculo-particular"  placeholder='Veículo particular'>
                                    </p>
                                </div>

                                <div class="form-group">  
                                    <label for="curso">Motivo da Diária: </label>
                                        <input type="radio" id='curso' name='curso'> <label for="curso">Curso</label>
                                        <input type="radio" id='outros' name='outros' checked> <label for="curso">Outros</label></label><br>
                                    <input class='form-control' type="text" name="motivo" id='motivo' required>
                                </div>
                            
                            </div>

                            <div class='col-sm-6 form-group'>
                                <div class='form-group'>
                                    <label for="matricula">Matricula do Servidor: </label>
                                    <input class='form-control' type="text" name='matricula'  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['portaria_matricula'] : ''?>"required>
                                </div>
                            
                                <div class="form-group">
                                    <label for="servidor">CPF do servidor: </label><br>
                                    <input class='form-control' type="text" name="cpf" id='CPF' value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['cpf'] : ''?>"required>
                                </div>

                                <div class="form-group">
                                    <label for="servidor">Cargo do servidor: </label><br>
                                    <input class='form-control' type="text" name="cargo"  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['cargo'] : ''?>"required>
                                </div>

                                <div class='form-group'>
                                    <label for="estado_destino">Estado Destino</label>
                                    <select class='form-control data_saida' name="estado_destino" id="estado_destino2" required   value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['estado_destino'] : ''?>">
                                        <?php echo $estado?>
                                    </select>
                                </div>
                                
                                <div class='form-group'>
                                    <label for="cidade_destino">Selecione a cidades</label>
                                    <select class='form-control cidade_destino' name="cidade_destino" id="cidade_destino2"  value="<?php echo isset($dados_diaria[0]) ? $dados_diaria[0]['cidade_destino'] : ''?>">
                                        <option value="">Selecione a Cidade</option required>
                                    </select>
                                </div>
                            
                                <div class="form-group col-sm-6 no-padding">
                                    <label>Data de Saídas:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker_saida2" name='data_saida' >
                                    </div>
                                    <!-- /.input group -->
                                </div>
                        
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora Saída:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" id='hora_saida2' name="hora_saida" value='__:__' required >
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-sm-6 no-padding">
                                    <label>Data de Retorno:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker_retorno2" name='data_retorno' required>
                                    </div>
                                </div>
                        
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora Retorno:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id='hora_retorno2' name="hora_retorno" value='__:__' required >
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id='campovazio2' class="form-group col-sm-12 no-padding" style='color:red; display:none'>
                                    <span  class='col-sm-12 text-left'></span>
                                </div>

                                <div class="form-group">
                                    <div id='retorno_adicional'></div>
                                </div>

                                <div class="form-group col-sm-12 pull-left">
                                    <a href="#"><button class='btn btn-success' id='submit1'>Enviar</button></a><br><br>
                                </div>
                            </div>
                        </form>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#curso').on('change', function() {
            $('#outros').prop('checked', false);
            $('#curso').val('on');
            $('#outros').val('off');
        })

        $('#outros').on('change', function() {
            $('#curso').prop('checked', false);
            $('#outros').val('on');
            $('#curso').val('off');
        })
        
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

        $('#hora_saida').keyup(function() {
            $('#hora_saida').inputmask({                                        
                mask: ['99:99'],
                keepStatic: true
            })
        })

        $('#hora_retorno').keyup(function() {
            $('#hora_retorno').inputmask({                                        
                mask: ['99:99'],
                keepStatic: true
            })
        })

        $('#hora_saida2').keyup(function() {
            $('#hora_saida2').inputmask({                                        
                mask: ['99:99'],
                keepStatic: true
            })
        })

        $('#hora_retorno2').keyup(function() {
            $('#hora_retorno2').inputmask({                                        
                mask: ['99:99'],
                keepStatic: true
            })
        })

        $('#placa').keyup(function() {
			$(this).inputmask({
				mask: ['AAA - 9999'],
				keepStatic: true
			})			
		})

        $('#placa2').keyup(function() {
			$(this).inputmask({
				mask: ['AAA - 9999'],
				keepStatic: true
			})			
		})
        // INPUT DE VEICULO NO CASO DE CARGO MOTORISTA OU OUTROS
		$('#cargo-motorista').on('change', function() {
            $('#cargo-outros').prop('checked', false)
            $('.cargo-outros').hide();
            $('#veiculo').val('');
			$('.cargo-motorista').show();	
		})

		$('#cargo-outros').on('change', function() {
			$('.cargo-outros').show();
            $('#veiculo').val('Cadastrado');
			$('#cargo-motorista').prop('checked', false)
			$('.cargo-motorista').hide();
		})
		// FIM
      
        $("#submit").click(function() {   
            if($("#veiculo").val() == "" && ($("#modelo").val() == "" || $("#placa").val() == "")) {
                $("#campovazio").css("display", "inline").fadeOut(3000);  
                return false;
            }
        });
        
        // INPUT DE VEICULO NO CASO DE CARGO MOTORISTA OU OUTROS
        $('#oficial').on('change', function() {
            $('#particular').prop('checked', false)
            $('#veiculo-particular').val('');
            $('.particular').hide();
			$('.oficial').show();	
		})

		$('#particular').on('change', function() {
			$('.particular').show();
            $('#veiculo-particular').val('Veículo Particular');
			$('#oficial').prop('checked', false)
			$('.oficial').hide();
		})
		// FIM
               
        $("#submit1").click(function() {   
            if($("#veiculo-particular").val() == "" && ($("#modelo2").val() == "" || $("#placa2").val() == "")) {
                $("#campovazio2").css("display", "inline").show();  
                $("#campovazio2").text("Informe o veículo"); 
                return false;
            }

            if($('#datepicker_saida2').val() > $('#datepicker_retorno2').val() || $('#datepicker_saida2').val() == "" || $('#datepicker_retorno2').val() == "" ) {
                $("#campovazio2").css("display", "inline").show();    
                $("#campovazio2").text("A data de saída deve ser infefior à data de retorno");           
                return false
            }else{
                $("#campovazio2").hide();
            }

            if($('#hora_saida2').val() == "__:__" || $('#hora_retorno2').val() == "__:__") {
                $("#campovazio2").css("display", "inline").show();
                $("#campovazio2").text("Informe horário de saída e de retorno");
                return false
            }else{
                $("#campovazio2").hide();
            }


            if($('#estado_destino2').val() == "Selecione o Estado" || $('#estado_destino2').val() == "") {
                $("#campovazio2").css("display", "inline").show();
                $("#campovazio2").text("Selecione o estado");
                $('#estado_destino2').focus();
                return false
            }

            if($('#cidade_destino2').val() == "Selecione o Estado" || $('#cidade_destino2').val() == "") {
                $("#campovazio2").css("display", "inline").show();
                $("#campovazio2").text("Selecione o estado");
                $('#cidade_destino2').focus();
                return false
            }
        });

    })
</script>