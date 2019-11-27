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
                  <h3 class="box-title"><strong> Editar Adiantamento de Valores </strong></h3>
                  <a href="<?php echo base_url('SuprimentoFundos/adiantamento')?>"><button class='pull-right btn btn-primary btn-xs'>Voltar</button></a>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
                    <div class="panel-body no-padding">
                        <!--  -->
                    </div>

                    <div class="container col-md-12">
                        <form action="<?php echo base_url('SuprimentoFundos/edit_adiantamento/'.$id);?>" method="POST" class='form_diaria col-sm-12'>                                        
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
                                    <label for="servidor">Nome do Responsável: </label><br>
                                    <input class='form-control' type="text" name="servidor" value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['responsavel'] : ''?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Telefone do Servidor::</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="telefone"  data-inputmask='"mask": "(99) 9 9999-9999"' data-mask  value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['telefone'] : ''?>" required>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for="matricula">Matricula do Servidor: </label>
                                    <input class='form-control' type="text" name='matricula'  value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['matricula'] : ''?>"required>
                                </div>
                            
                                <div class="form-group">
                                    <label for="servidor">CPF do servidor: </label><br>
                                    <input class='form-control' type="text" name="cpf" id='CPF' value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['cpf'] : ''?>"required>
                                </div>

                                <div class='form-group'>
                                    <label for="matricula">Valor: </label>
                                    <input class='form-control' type="number" name='valor' step='0.01' value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['valor_solicitacao'] : ''?>"required>
                                </div>
                                
                                
                            </div>
                            
                            <div class='col-sm-6 form-group'>
                                <div class="form-group">                
                                    <label for="servidor">Banco: </label><br>
                                    <input class='form-control' type="text" name="banco" value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['banco'] : ''?>" required>
                                </div>
                                
                                <div class="form-group">  
                                    <label for="servidor">Agência: </label><br>
                                    <input class='form-control' type="text" name="agencia"  value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['agencia'] : ''?>"required>
                                </div>
                                
                                <div class="form-group">  
                                    <label for="servidor">Conta: </label><br>
                                    <input class='form-control' type="text" name="conta"  value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['conta'] : ''?>"required>
                                </div>
                            
                                <div id='campovazio2' class="form-group col-sm-12 no-padding" style='color:red; display:none'>
                                    <span  class='col-sm-12 text-left'></span>
                                </div>

                                <div class="form-group">
                                    <div id='retorno_adicional'></div>
                                </div>
                                
                                <div class="form-group">  
                                    <label for="servidor">Motivo: </label><br>
                                    <input class='form-control' type="text" name="motivo"  value="<?php echo isset($dados_adiantamento[0]) ? $dados_adiantamento[0]['motivo'] : ''?>"required>
                                </div>

                            </div>

                            
                            <div class="form-group col-sm-12 pull-left">
                                    <a href="#"><button class='btn btn-success' id='submit1'>Enviar</button></a><br><br>
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
       
        // MASCARA PARA O CPF DO CADASTRO DO MODAL
        $('#CPF').keyup(function() {
            $('#CPF').inputmask({
                // mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                mask: ["999.999.999-99"],
                keepStatic: true
            });
        });

      
        $("#submit").click(function() {   
            if($("#veiculo").val() == "" && ($("#modelo").val() == "" || $("#placa").val() == "")) {
                $("#campovazio").css("display", "inline").fadeOut(3000);  
                return false;
            }
        });

    })
</script>