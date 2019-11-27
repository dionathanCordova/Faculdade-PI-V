
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
                  <h3 class="box-title"><strong>Simulador de Valores</strong></h3>
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
                                <li class="active"><a data-toggle="tab" href="#home">SIMULADOR DE VALOR (DIÁRIA)</a></li>
                                <li><a data-toggle="tab" href="#menu1">SIMULADOR DE VALOR (UFMS)</a></li>
                            </ul>

                            <div class="tab-content container-fluid">   
                                <div id="home" class="tab-pane fade in active col-sm-12">   
                                    <form action="#" method="POST" class='form_diaria col-sm-12'>    
                                       
                                        <div class="form-group col-sm-12 box-msg" style='display:none'>
                                            <div class="alert alert-danger alert-dismissible col-sm-12">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                <p id='msg'></p>
                                            </div>
                                        </div>

                                        <div class='col-sm-6 form-group'>                                            
                                            <div class='form-group'>
                                                <label for="estado_destino">Estado Destino</label>
                                                <select class='form-control data_saida' name="estado_destino" id="estado_destino">
                                                    <?php echo $estado?>
                                                </select>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label for="cidade_destino">Selecione a cidades</label>
                                                <select class='form-control cidade_destino' name="cidade_destino" id="cidade_destino">
                                                    <option value="">Selecione a Cidade</option>
                                                </select>
                                            </div>
                                           

                                            <div class="small-box bg-green box-indicador col-lg-5  col-xs-12"  id='box-valor' style='display:none'>
                                                <div class="">
                                                    <!-- <i class="ion ion-stats-bars "></i> -->
                                                    <i class="icon ion-cash"></i>
                                                </div>
                                                
                                                <div class="inner">
                                                    <h3>R$ <sup style="font-size: 20px" id="valor-diaria">0,00</sup></h3>
                                                    <p id="Legenda-diaria">Valor Simulado</p>
                                                </div>                        
                                            </div>

                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            <div class="form-group col-sm-6 no-padding">
                                                <label>Data de Saídas:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="datepicker_saida" name='data_saida_ufm' >
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
                                            
                                            <div class="form-group">  
                                                <label for="curso">Motivo da Diária: </label>
                                                <input type="radio" id='curso' name='curso'> <label for="curso">Curso</label>
                                                <input type="radio" id='outros' name='outros' checked> <label for="curso">Outros</label></label><br>
                                            </div>

                                           
                                            <div class="form-group">
                                                <div id='retorno_adicional'></div>
                                            </div>

                                            <div class="form-group">
                                                <a href="#"><button class='btn btn-success' id='btn-simular-diaria' type='button'>Simular</button></a><br><br>
                                            </div>
                                        </div> 
                                    </form>
                                </div>   

                                <div id="menu1" class="tab-pane fade">
                                    <form action="#" method='POST' class='form_diaria col-sm-12' id='form-urm'>                                       

                                        <div class='col-sm-6 form-group'>                                            
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
                                           

                                            <div class="small-box bg-green box-indicador col-sm-8  col-xs-12"  id='box-valor-ufm' style='display:none'>
                                                <div class="">
                                                    <!-- <i class="ion ion-stats-bars "></i> -->
                                                    <i class="icon ion-cash"></i>
                                                </div>
                                                
                                                <div class="inner">
                                                    <h3>R$ <sup style="font-size: 20px" id="valor">0,00</sup></h3>
                                                    <p id="Legenda-ufm">Valor Simulado</p>
                                                </div>                        
                                            </div>

                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            
                                            <div class="form-group">
                                                <label for="servidor">Valor Atual UFM: </label><br>
                                                <input class='form-control' type="number" step='0.01' name="valor_ufm" id='valor_ufm' value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor']: ''?>" required>
                                            </div>
                                                                                      

                                            <div class="form-group col-sm-6 no-padding">
                                                <label>Data de Saídas:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="datepicker_saida2" name='data_saida_ufm' >
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                    
                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>Hora Saída:</label>

                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id='hora_saida_ufm' name="hora_saida_ufm" value='__:__' required >
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

                                           
                                            <div class="form-group">
                                                <div id='retorno_adicional'></div>
                                            </div>

                                            <div class="form-group">
                                                <a href="#"><button class='btn btn-success' id='btn-simular-ufm' type='button'>Simular</button></a><br><br>
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

        $('#btn-simular-diaria').click(function() {
            var hora_saida = $('#hora_saida').val();
            var datepicker_saida = $('#datepicker_saida').val();
            var hora_retorno = $('#hora_retorno').val();
            var data_retorno = $('#datepicker_retorno').val();
            var valor_ufm = $('#valor_ufm').val();
            var cidade_destino = $('#cidade_destino').val();
            var estado_destino = $('#estado_destino').val();
            var curso = $('#curso').val();

            var valor = $('#valor-diaria');

            $.post('/simulador/diarias', {
                hora_saida : hora_saida,
                data_saida : datepicker_saida,
                hora_retorno: hora_retorno,
                data_retorno: data_retorno,
                valor_ufm: valor_ufm,
                cidade_destino: cidade_destino,
                estado_destino: estado_destino,
                curso: curso
            }, function(data) {
                var obj = JSON.parse(data);               
               
                if(obj['msg'] != 'Simulação diária') {
                    console.log(obj['msg']);
                    $('.box-msg').show();
                    $('#msg').text(obj['msg'])
                }else{
                    $('.box-msg').hide();
                    $('#box-valor').fadeIn(1000);
                    valor.text(obj['valor_total']);
                    $('#Legenda-diaria').text('Total de diárias : ' + obj['horas_consedidas']);
                }
            }) 
        })

        $('#btn-simular-ufm').click(function() {
            var hora_saida_ufm = $('#hora_saida_ufm').val();
            var datepicker_saida2 = $('#datepicker_saida2').val();
            var hora_retorno = $('#hora_retorno2').val();
            var data_retorno = $('#datepicker_retorno2').val();
            var valor_ufm = $('#valor_ufm').val();
            var cidade_destino = $('#cidade_destino2').val();
            var estado_destino = $('#estado_destino2').val();

            var valor = $('#valor');

            $.post('/simulador/ufms', {
                hora_saida : hora_saida_ufm,
                data_saida : datepicker_saida2,
                hora_retorno: hora_retorno,
                data_retorno: data_retorno,
                valor_ufm: valor_ufm,
                cidade_destino: cidade_destino,
                estado_destino: estado_destino
            }, function(data) {
                var obj = JSON.parse(data);
                console.log(obj);

                $('#box-valor-ufm').fadeIn(1000);
                valor.text(obj['valor_total']);
                $('#Legenda-ufm').text('Total de UFMS : ' + obj['horas_consedidas']);
                
            }) 
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

        $('#hora_saida_ufm').keyup(function() {
            $('#hora_saida_ufm').inputmask({                                        
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

    
    });
</script>