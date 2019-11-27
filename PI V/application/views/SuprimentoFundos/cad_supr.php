<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
    $(document).ready(function(){

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
                  <h3 class="box-title"><strong> Cadastro de Adiantamento de Valores </strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
                    <div class="panel-body no-padding">
                        <!--  -->
                    </div>


                    <div class="container col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Registrar Adiantamento <span class='text-success'>(Servidores cadastrados)</span></a></li>
                                <li><a data-toggle="tab" href="#menu1">Registrar Adiantamento  <span class='text-warning'>(Servidores sem cadastrados)</span> </a></li>
                            </ul>

                            <div class="tab-content container-fluid">   
                                <div id="home" class="tab-pane fade in active col-sm-12">   
                                    <form action="<?php echo base_url('SuprimentoFundos/cadAdiantamento');?>" method="POST" class='form_diaria col-sm-12'>                                        
                                        <?php if($msg != '') :?>
                                        <div class="form-group col-sm-12">
                                            <div class="alert alert-danger alert-dismissible col-sm-12">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                <?php echo $msg?>
                                            </div>
                                        </div>
                                        <?php endif?>
                                       
                                        <?php if($_SESSION['nivel'] == 5): ?>
                                            <div class="form-group container-fluid">
                                                <label for="servidor">Secretaría de Dotação: </label><br>
                                                <select class='form-control' type="text" name="id_select_secretaria" id='id_select_secretaria' required>
                                                    <?php echo $secretaria; ?>
                                                </select>
                                            </div>                 
                                        <?php endif?>

                                        <div class='col-sm-6 form-group'>                                              

                                            <div class="form-group">
                                                <label for="servidor">Selecione o Servidor: </label><br>
                                                <select class='form-control' type="text" name="id_servidor" id="id_servidor" required>
                                                    <?php echo $servidores_registrados; ?>
                                                </select>
                                            </div>     

                                            <div class="form-group">                
                                                <label for="valor">Valor: </label><br>
                                                <input class='form-control valor1' type="number" step='0.01' name="valor" id='valor' value="<?php echo isset($postinmemoria) ? $postinmemoria['valor'] : ''?>" required>
                                            </div>

                                        </div>

                                        <div class='col-sm-6 form-group'>                                            
                                            <div class="form-group">  
                                                <label for="motivo">Motivo do adiantamento: </label><br>
                                                <input class='form-control' type="text" name="motivo"  value="<?php echo isset($postinmemoria) ? $postinmemoria['motivo'] : ''?>"required>
                                            </div>                                                                          
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <a href="#"><button class='btn btn-success' id='submit'>Enviar</button></a><br><br>
                                        </div>   
                                    </form>
                                </div>
                            

                                <div id="menu1" class="tab-pane fade">
                                    <form action="<?php echo base_url('SuprimentoFundos/cadAdiantamento');?>" method="POST" class='form_diaria col-sm-12'>                                        
                                        <?php if($msg != '') :?>
                                        <div class="form-group col-sm-12">
                                            <div class="alert alert-danger alert-dismissible col-sm-12">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                <?php echo $msg?>
                                            </div>
                                        </div>
                                        <?php endif?>

                                        <?php if($_SESSION['nivel'] == 5): ?>
                                        <div class="form-group col-sm-12">
                                            <label for="servidor">Secretaría de Dotação: </label><br>
                                            <select class='form-control' type="text" name="id_select_secretaria" required>
                                                <?php echo $secretaria; ?>
                                            </select>
                                        </div>                 
                                        <?php endif?>

                                        <div class='col-sm-6 form-group'>
                                            <div class="form-group">
                                                <label for="servidor">Nome do Servidor: </label><br>
                                                <input class='form-control' type="text" name="servidor" value="<?php echo isset($postinmemoria) ? $postinmemoria['servidor'] : ''?>" required>
                                            </div>

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
                                                <label for="servidor">Banco: </label><br>
                                                <input class='form-control' type="text" name="banco" value="<?php echo isset($postinmemoria) ? $postinmemoria['banco'] : ''?>" required>
                                            </div>

                                            <div class="form-group">  
                                                <label for="servidor">Agência: </label><br>
                                                <input class='form-control' type="text" name="agencia"  value="<?php echo isset($postinmemoria) ? $postinmemoria['agencia'] : ''?>"required>
                                            </div>

                                            <div class="form-group">  
                                                <label for="servidor">Conta: </label><br>
                                                <input class='form-control' type="text" name="conta"  value="<?php echo isset($postinmemoria) ? $postinmemoria['conta'] : ''?>"required>
                                            </div>
                                          
                                        </div>

                                        <div class='col-sm-6 form-group'>
                                            <div class='form-group'>
                                                <label for="matricula">Matricula do Servidor: </label>
                                                <input class='form-control' type="text" name='matricula'  value="<?php echo isset($postinmemoria) ? $postinmemoria['portaria_matricula'] : ''?>"required>
                                            </div>
                                        
                                            <div class="form-group">
                                                <label for="servidor">CPF do servidor: </label><br>
                                                <input class='form-control' type="text" name="cpf" id='CPF' value="<?php echo isset($postinmemoria) ? $postinmemoria['cpf'] : ''?>"required>
                                            </div>

                                            <div class="form-group">
                                                <label for="servidor">Cargo do servidor: </label><br>
                                                <input class='form-control' type="text" name="cargo"  value="<?php echo isset($postinmemoria) ? $postinmemoria['cargo'] : ''?>"required>
                                            </div>

                                            <div id='campovazio2' class="form-group col-sm-12 no-padding" style='color:red; display:none'>
                                                <span  class='col-sm-12 text-left'></span>
                                            </div>

                                            <div class="form-group">
                                                <div id='retorno_adicional'></div>
                                            </div>

                                            <div class="form-group">  
                                                <label for="motivo">Motivo do adiantamento: </label><br>
                                                <input class='form-control' type="text" name="motivo"  value="<?php echo isset($postinmemoria) ? $postinmemoria['motivo'] : ''?>"required>
                                            </div>

                                            
                                            <div class="form-group">                
                                                <label for="valor">Valor: </label><br>
                                                <input class='form-control valor2' type="number" step='0.01' name="valor" id='valor' value="<?php echo isset($postinmemoria) ? $postinmemoria['valor'] : ''?>" required>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group col-sm-12">
                                            <a href="#"><button class='btn btn-success' id='submit1'>Enviar</button></a><br><br>
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

<script>
    $(document).ready(function() {
        
        // MASCARA PARA O CPF DO CADASTRO DO MODAL
        $('#CPF').keyup(function() {
            $('#CPF').inputmask({
                // mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                mask: ["999.999.999-99"],
                keepStatic: true
            });
        });
      
        $("#submit").click(function() {   
            if($('#id_servidor').val() == "Selecione o Servidor:") {
                $('#id_servidor').focus();
                $("#campovazio").css("display", "inline").show();  
                $("#campovazio").text("Informe o servidor"); 
                return false;
            }

            if($("#veiculo").val() == "" && ($("#modelo").val() == "" || $("#placa").val() == "")) {
                $("#campovazio").css("display", "inline").show();  
                $("#campovazio").text("Informe o veículo"); 
                return false;
            }

            if($('#datepicker_saida').val() == "" || $('#datepicker_retorno').val() == "" ) {
                $("#campovazio").css("display", "inline").show();    
                $("#campovazio").text("Informe as datas de saída e retorno.");           
                return false
            }else{
                $("#campovazio").hide();
            }

            if($('#hora_saida').val() == "__:__" || $('#hora_retorno').val() == "__:__") {
                $("#campovazio").css("display", "inline").show();
                $("#campovazio").text("Informe horário de saída e de retorno");
                return false
            }else{
                $("#campovazio").hide();
            }
        });
        
          
        $("#submit1").click(function() {   
            if($("#veiculo-particular").val() == "" && ($("#modelo2").val() == "" || $("#placa2").val() == "")) {
                $("#campovazio2").css("display", "inline").show();  
                $("#campovazio2").text("Informe o veículo"); 
                return false;
            }

            if($('#datepicker_saida2').val() == "" || $('#datepicker_retorno2').val() == "" ) {
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
        });
        
         
        $('.valor1').keyup(function() {
            //let valor = $('.valor1').val();
           // $('.valor1').val(valor.replace('.'. ','));
            let valor = $('.valor1').val().replace(',', '.');
            console.log(valor);
        })
        
       $('.valor2').keyup(function() {
            //let valor = $('.valor2').val();
            //$('.valor2').val(valor.replace('.'. ','));
            console.log($('.valor2').val());
            
        })

    })
</script>