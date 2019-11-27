
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

            $('#cidade_destino_2').html('<option>Carregando...</option>');

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
            var url = '/Ufms/servidores_option';

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
                  <h3 class="box-title"><strong>Cadastro de UFM para Agente Político </strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
					
					<div class="panel-body no-padding">
						<div class='col-sm-12 container'>
							<div class=''>
                                <div class=''>
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Registrar Diária de Servidores Cadastrados</a></li>
                                <li><a data-toggle="tab" href="#menu1">Cadastrar Diária e Servidor</a></li>
                            </ul>

                            <div class="tab-content container-fluid">   
                                <div id="home" class="tab-pane fade in active col-sm-12">   
                                    <form action="<?php echo base_url('Ufms/cadUfmsServidorCadastrado');?>" method="POST" class='form_diaria col-sm-12'>                                        
                                        <?php if($msg != '') :?>
                                        <div class="form-group col-sm-12">
                                            <div class="alert alert-danger alert-dismissible col-sm-12">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                <?php echo $msg?>
                                            </div>
                                        </div>
                                        <?php endif?>
                                        
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
                                                <select class='form-control' type="text" name="id_select_secretaria" id="id_select_secretaria" required>
                                                    <?php echo $secretaria; ?>
                                                </select>
                                            </div>                 
                                        <?php endif?>

                                        <div class='col-sm-6 form-group'>                                              

                                            <div class="form-group">
                                                <label for="servidor">Selecione o Servidor: </label><br>
                                                <select class='form-control' type="text" name="id_servidor" id='id_servidor' required>
                                                    <?php echo $servidores_registrados; ?>
                                                </select>
                                            </div>              

                                            <div class='form-group'>
                                                <label for="estado_destino">Estado Destino</label>
                                                <select class='form-control data_saida' name="estado_destino" id="estado_destino" required   value="<?php echo isset($postinmemoria) ? $postinmemoria['estado_destino'] : ''?>">
                                                    <?php echo $estado?>
                                                </select>
                                            </div>
                                
                                            <div class="form-group">
                                                <label for="veiculo">Veículo Oficial: </label>
                                                <input type="radio" id='cargo-motorista' name='Cadastrar' style='margin-left:2vmin'> <label for="Cadastrar"> Informar</label>
                                                <input type="radio" id='cargo-outros' style='margin-left:1vmin'> <label for="Selecionar"> Possui veículo vinculado</label></label><br>
                                                
                                                <div class='cargo-motorista col-xs-12 form-group'>
                                                    <div class='col-xs-6'>
                                                        <input class='form-control col-xs-6' type="text" name='modelo' id="modelo" placeholder='Modelo ex: Gol'>
                                                    </div>
                                                    <div class='col-xs-6'>
                                                        <input class='form-control col-xs-6' type="text" name='placa' id="placa" placeholder='Placa ex: MMM - 1111'>
                                                    </div>
                                                </div>

                                                <p class='cargo-outros' style='display:none'>
                                                    <input class='form-control' type="text" name='veiculo' value='' disabled id="veiculo" placeholder='Servidor com veiculo vinculado em seu cadastro'>
                                                </p>
                                            </div>	

                                            <div class="form-group">  
                                                <label for="servidor">Motivo da Diária: </label><br>
                                                <input class='form-control' type="text" name="motivo" value="<?php echo isset($postinmemoria) ? $postinmemoria['motivo']: ''?>"required>
                                            </div>
                                        </div>

                                        <div class='col-sm-6 form-group'>

                                            <div class="form-group">
                                                <label for="servidor">Valor Atual UFM: </label><br>
                                                <input class='form-control' type="number" step='0.01' name="valor_ufm" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>" required>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label for="cidade_destino">Selecione a cidades</label>
                                                <select class='form-control cidade_destino' name="cidade_destino" id="cidade_destino"  value="<?php echo isset($postinmemoria) ? $postinmemoria['cidade_destino'] : ''?>">
                                                    <option value="">Selecione a Cidade</option required>
                                                </select>
                                            </div>
                                        
                                            <div class="form-group col-sm-6 no-padding">
                                                <label>Data de Saídas:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="datepicker_saida" name='data_saida' >
                                                </div>
                                            </div>
                                    
                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>Hora Saída:</label>

                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id='hora_saida' name="hora_saida" value='__:__' required >
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
                                                    <input type="text" class="form-control pull-right" id="datepicker_retorno" name='data_retorno' required>
                                                </div>
                                            </div>
                                    
                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>Hora Retorno:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id='hora_retorno' name="hora_retorno" value='__:__' required >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id='campovazio' class="form-group col-sm-12 no-padding" style='color:red; display:none'>
                                                <span  class='col-sm-12 text-left'></span>
                                            </div>

                                            <div class="form-group">
                                                <div id='retorno_adicional'></div>
                                            </div>   
                                            
                                            <div class="form-group col-sm-12">
                                                <a href="#"><button class='btn btn-success' id='submit'>Enviar</button></a><br><br>
                                            </div>                                           
                                        </div>
                                    </form>
                                </div>
                                <button class='btn btn-success' id='submit_teste'>teste</button></a><br><br>

                                <div id="menu1" class="tab-pane fade">
                                    <form action="<?php echo base_url('/Ufms/cad_ufms')?>" method='POST' class='form_diaria col-sm-12'>                                       
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
                                            <?php if($_SESSION['nivel'] == 5): ?>
                                            <div class="form-group">
                                                <label for="servidor">Secretaría de Dotação: </label><br>
                                                <select class='form-control' type="text" name="id_select_secretaria" required>
                                                    <?php echo $secretaria; ?>
                                                </select>
                                            </div>                 
                                            <?php endif?>

                                            <div class="form-group">
                                                <label for="servidor">Nome do Servidor: </label><br>
                                                <input class='form-control' type="text" name="servidor" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor'] : ''?>" required>
                                            </div>

                                            <div class='form-group'>
                                                <label for="matricula">Matricula do Servidor: </label>
                                                <input class='form-control' type="number" name='matricula' value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>">
                                            </div>
                                            
                                            <div class="form-group">                
                                                <label for="servidor">Banco: </label><br>
                                                <input class='form-control' type="text" name="banco" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>" required>
                                            </div>

                                            <div class="form-group">  
                                                <label for="servidor">Agência: </label><br>
                                                <input class='form-control' type="text" name="agencia" value="<?php echo isset($postinmemoria) ? $postinmemoria['agencia']: ''?>"required>
                                            </div>

                                            <div class="form-group">  
                                                <label for="servidor">Conta: </label><br>
                                                <input class='form-control' type="text" name="conta" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>" required>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label for="estado_destino">Estado Destino</label>
                                                <select class='form-control data_saida' name="estado_destino" id="estado_destino2">
                                                    <?php echo $estado?>
                                                </select>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label for="cidade_destino">Selecione a cidades</label>
                                                <select class='form-control cidade_destino' name="cidade_destino" id="cidade_destino2">
                                                    <option value="">Selecione a Cidade</option>
                                                </select>
                                            </div>
                                           

                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            <div class="form-group">
                                                <label>Telefone do Servidor::</label>
                                                <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input type="text" class="form-control" name="telefone"  data-inputmask='"mask": "(99) 9 9999-9999"' data-mask  value="<?php echo isset($postinmemoria) ? $postinmemoria['telefone'] : ''?>" required>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="servidor">Valor Atual UFM: </label><br>
                                                <input class='form-control' type="number" step='0.01' name="valor_ufm" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>" required>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="servidor">CPF do servidor: </label><br>
                                                <input class='form-control' type="text" name="cpf"  id='CPF' value="<?php echo isset($postinmemoria) ? $postinmemoria['cpf']: ''?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="servidor">Cargo do servidor: </label><br>
                                                <input class='form-control' type="text" name="cargo" value="<?php echo isset($postinmemoria) ? $postinmemoria['cargo']: ''?>" required>
                                            </div>
                                            
                                            <div class="form-group">  
                                                <label for="servidor">Motivo da Diária: </label><br>
                                                <input class='form-control' type="text" name="motivo" value="<?php echo isset($postinmemoria) ? $postinmemoria['motivo']: ''?>"required>
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

                                            <div class="form-group">
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
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
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
            $('#veiculo').val('');
            $('.cargo-outros').hide();
			$('.cargo-motorista').show();	
		})

		$('#cargo-outros').on('change', function() {
			$('.cargo-outros').show();
            $('#veiculo').val('Cadastrado');
			$('#cargo-motorista').prop('checked', false)
			$('.cargo-motorista').hide();
		})
        // FIM
   
        function RetornaData(DataSaida, DataRetorno){
            if(DataSaida == "" || DataRetorno == "") {
                return 'erro';
            }else{
                var DataS = DataSaida.split('/');
                var DiaDataS = DataS[0],
                    MesDataS = DataS[1],
                    AnoDataS = DataS[2];
                    
                var DataR = DataRetorno.split('/');
                var DiaDataR = DataR[0],
                    MesDataR = DataR[1],
                    AnoDataR = DataR[2];
                
                let retorno = '';
                if(AnoDataS <= AnoDataR) {
                    if(MesDataS <= MesDataR && AnoDataS == AnoDataR) {
                        retorno = 'done';
                        if(MesDataS == MesDataR && DiaDataS > DiaDataR) {
                            retorno = 'erro';
                        }
                    }else if (MesDataS >= MesDataR && AnoDataS < AnoDataR){
                        retorno = 'done';
                    }else{
                        retorno = 'erro';
                    }
                }else{
                    retorno = 'erro';
                }

                console.log('retorno: ' + retorno);
                console.log('Data_saida: ' + DataSaida);
                console.log('Data_retorno: ' + DataRetorno);
                return retorno;
            }
        }
        
        $("#submit").click(function() { 

            if($("#veiculo").val() == "" && ($("#modelo").val() == "" || $("#placa").val() == "")) {
                $("#campovazio").css("display", "inline").fadeOut(3000);  
                return false;
            }
          
            let comparadatas = RetornaData($('#datepicker_saida').val(), $('#datepicker_retorno').val());
            if(comparadatas == 'erro') {
                $("#campovazio").css("display", "inline").show();    
                $("#campovazio").text("A data de saída deve ser infefior à data de retorno");           
                return false;
            }else{
                $("#campovazio").hide();
            }

            // if($('#datepicker_saida').val() > $('#datepicker_retorno').val() || $('#datepicker_saida').val() == "" || $('#datepicker_retorno').val() == "" ) {
            //     $("#campovazio").css("display", "inline").show();    
            //     $("#campovazio").text("A data de saída deve ser infefior à data de retorno");           
            //     return false
            // }else{
            //     $("#campovazio").hide();
            // }

            if($('#hora_saida').val() == "__:__" || $('#hora_retorno').val() == "__:__") {
                $("#campovazio").css("display", "inline").show();
                $("#campovazio").text("Informe horário de saída e de retorno");
                return false
            }else{
                $("#campovazio").hide();
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
                $("#campovazio2").text("Favor Informar o Veículo");
                return false;
            }else{
                $("#campovazio2").hide();
            }

            let comparadatas2 = RetornaData($('#datepicker_saida2').val(), $('#datepicker_retorno2').val());
            console.log(comparadatas2);
            if(comparadatas2 == 'erro') {
                $("#campovazio2").css("display", "inline").show();    
                $("#campovazio2").text("A data de saída deve ser infefior à data de retorno");           
                return false;
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
        });
    
    });
</script>