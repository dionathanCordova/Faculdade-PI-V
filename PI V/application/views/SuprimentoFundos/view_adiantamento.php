<style>
    .alert-pdfs, .alert-confirmacao, .alert-deleteBalancete{
        display:none;
    }

    .hide-pfs{
        display:none;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid pull-center">
            <div class="box-header">
                <div class="form-group col-sm-12 alert-pdfs">
                    <div class="alert alert-danger alert-dismissible col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p id='response'>Os PDF´s estarão disponível somente após a finalização da proposta. <br> Finalize clicando no botão "Finalizar" listado nas opções. <br> Importante ressaltar que ao finalizar, a edição e exclusão da proposta não estarão mais disponíveis.</p>
                    </div>
                </div>

                <div class="form-group col-sm-12 alert-deleteBalancete">
                    <div class="alert alert-danger alert-dismissible col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p id='response'>Este adiantamento já foi analisado, não é mais possível deletar o balancete.</p>
                    </div>
                </div>

                <div class="form-group col-sm-12  alert-confirmacao">
                    <div class="alert alert-success alert-dismissible col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p>Proposta enviada.</p>
                    </div>
                </div>
                
                <h3 class="box-title"><strong> Pré-Visualização do adiantamento de valores </strong></h3>

                <div class="col-sm-12">
                    <?php if($_SESSION['nivel']):?>

                    <div class="btn-group pull-right col-sm-2" role="group" >
                        
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= 'Ações admin' ?>
                            <span class="caret"></span>
                        </button>
                            <ul class="dropdown-menu">
                                <a href="<?php echo base_url('SuprimentoFundos/adiantamento/1')?>">
                                <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="glyphicon glyphicon-home"></i> Voltar</button></a>
                            </a> 
                            
                      
                            <button type='button' class='btn btn-success col-sm-12 confirm-adiantamento' value="<?php echo $id;?>"><i class="fa fa-thumbs-up"></i> Deferir documento</button>
                            <button type='button' class='btn btn-warning col-sm-12 indefere-adiantamento' value="<?php echo $id;?>"><i class="fa fa-thumbs-down"></i> Indeferir documento</button>
                        </ul>
                    </div>
                    <?php endif ?>
                
                    <div class="btn-group pull-right" role="group" >
                        
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= 'Ações usuário' ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <a href="<?php echo base_url('SuprimentoFundos/adiantamento/1')?>">
                            <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="glyphicon glyphicon-home"></i> Voltar</button></a>
                            </a> 
                            <?php if($user_confirm_diaria == '1'):?>
                                <a href="<?php echo base_url('SuprimentoFundos/Pdfadiantamento/').$id?>" target='_blank'>
                                    <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> PDF Proposta</button></a>
                                </a>
                                <?php if($balancete_gerado == '1'):?>
                                <a href="<?php echo base_url('SuprimentoFundos/Pdfbalancete/').$id?>" target='_blank'>
                                        <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> PDF Balancete</button></a>
                                    </a>
                                    <?php else: ?>  
                                    <a href="<?php echo base_url('SuprimentoFundos/gerar_balancete/').$id?>" target='_blank'>
                                    <button type='submit' class='btn btn-warning col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> Gerar Balancete</button></a>
                                    </a>
                                <?php endif ?>  
                                <?php else: ?>  
                                <div class='hide-pfs'>
                                    <a href="<?php echo base_url('SuprimentoFundos/Pdfadiantamento/').$id?>" target='_blank'>
                                        <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> PDF Proposta</button></a>
                                    </a>
                                    <?php if($balancete_gerado == '1'):?>
                                        <a href="<?php echo base_url('SuprimentoFundos/Pdfbalancete/').$id?>" target='_blank'>
                                        <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> PDF Balancete</button></a>
                                    </a>
                                    <?php else: ?>  
                                        <a href="<?php echo base_url('SuprimentoFundos/gerar_balancete/').$id?>" target='_blank'>
                                            <button type='submit' class='btn btn-warning col-sm-12' name='btn_id' value="<?php echo $id;?>"><i class="fa fa-print"></i> Gerar Balancete</button></a>
                                        </a>
                                    <?php endif ?>  
                                </div>
                                
                                <div class='hide-pfs-2'>
                                    <button class='btn btn-default col-sm-12 disabled btn-aviso-confirmacao'><i class="fa fa-print"></i> PDF Proposta</button>
                                    <?php if($balancete_gerado == '1'):?>
                                        <button class='btn btn-default col-sm-12 disabled btn-aviso-confirmacao'><i class="fa fa-print"></i> PDF Balancete</button>
                                    <?php else: ?>  
                                        <button type='submit' class='btn btn-warning disabled col-sm-12 btn-aviso-confirmacao' name='btn_id' value="<?php echo $id;?>">Gerar Balancete</button></a>
                                        <?php endif ?>  
                                    
                                </div>
                            <?php endif ?>  
                            <?php if($user_confirm_diaria != '1'):?>
                                <?php if($confirmacao == '0'):?>                         
                                    <button  class='btn btn-danger col-sm-12 text-center remove-adiantamento' value="<?php echo $id?>" name='id_ufm-confirmar'><i class='glyphicon glyphicon-trash'></i> Deletar</button>
                                    
                                    <a href="<?php echo base_url('SuprimentoFundos/edit_adiantamento/').$id?>">
                                    <button type='submit' class='btn btn-primary col-sm-12 edit-diaria' name='btn_id' value="<?php echo $id;?>"><i class="glyphicon glyphicon-edit"></i> Editar</button></a>
                                    </a>

                                <?php endif ?>     
                            
                                <button type='button' class='btn btn-success col-sm-12 btn_confirm_adiantamento' value="<?php echo $id;?>"><i class="glyphicon glyphicon-ok"></i> Finalizar</button>
                                <?php endif ?>                
                                <?php if($confirmacao == '0' && $balancete_gerado == '1'):?>     
                                <button  class='btn btn-danger col-sm-12 text-center remove-balancete' value="<?php echo $id?>" name='id_ufm-confirmar'><i class='glyphicon glyphicon-trash'></i> Deletar Balancete</button>  
                                <?php endif ?>     
                        </ul>
                    </div> 
                </div>
            </div>
            <div class="box-body">
                <div class="panel box box-primary "> 
                    <article class="flex-container" >
                        <div class="informacoes_gerais col-xs-12 text-center">
                            <h3><strong> PROPOSTA DE CONCESSÃO DE ADIANTAMENTO DE VALORES</strong></h3>

                            <p> Lei Municipal nº 1.051/94; Fundamento Legal Lei n° 4.320/64 </p>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 1. PROPONENTE</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong> Nome: <?= $dados_adiantamento[0]['responsavel']?></strong></td>
                                        <td><strong> Banco: <?= $dados_adiantamento[0]['banco']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong>  CPF: <?= $dados_adiantamento[0]['cpf']?></strong></td>
                                        <td id="prop"><strong> Agência: <?= $dados_adiantamento[0]['agencia']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong>  Matrícula: <?= $dados_adiantamento[0]['matricula']?></strong></td>
                                        <td id="ap"><strong> Conta corrente: <?= $dados_adiantamento[0]['conta']?></strong></td>   
                                    </tr>
                                    <tr>
                                        <td id="mes"><strong> Telefone: <?= $dados_adiantamento[0]['telefone']?></strong></td>   
                                    </tr>
                                </table>
                            </div>                   
                        </div>   
                        
                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 2. CLASSIFICAÇÃO ORÇAMENTÁRIA</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Órgão: <?= $dados_adiantamento[0]['orgao'] . ' - ' . $dados_adiantamento[0]['fundo']?></strong></td>
                                        <td> </td>
                                    </tr>
                                    <!-- <tr>
                                        <td class='col-xs-12'><strong> Código Reduzido: <?= $dados_adiantamento[0]['codigo_reduzido'] ?></strong></td>
                                        <td id="prop"> </td>
                                    </tr> -->
                                    <tr>
                                        <td class='col-xs-12'><strong> Atividade: <?= $dados_adiantamento[0]['atividade']?></strong></td>
                                        <td id="ap"></td>   
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Elemento de Despesa: <?= $dados_adiantamento[0]['elemento_despesa']?> Adiantamento de Valores</strong></td>
                                        <td id="mes"> </td>   
                                    </tr>
                                </table>
                            </div>                   
                        </div> 
                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 3. VALOR SOLICITADO</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12 '><strong> Total: R$ <span class='bg-warning'> <?= number_format($dados_adiantamento[0]['valor_solicitacao'],'2', ',','')?></span><strong></td>
                                        <td id="prop"> </td>
                                    </tr>
                                </table>
                            </div>                   
                        </div> 

                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 4. MOTIVO</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12 '><strong> Fim a que se destina:  <span class='bg-warning'> <?= $dados_adiantamento[0]['motivo'] ?></span><strong></td>
                                        <td id="prop"> </td>
                                    </tr>
                                </table>
                            </div>                   
                        </div> 

                    </article>    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
    $(document).ready(function() {

        $('.btn_confirm_adiantamento').click(function() {
            var id = $(this).val()

            var conf = confirm('Deseja realmente enviar a proposta? Ao confirmar não será mais possível ( EDITAR / DELETAR ) a proposta`');

            if(conf == true) {
                $.ajax({
                    url: '/SuprimentoFundos/confirmar_adiantamento',
                    data: { id: id},
                    dataType: "json",
                    type: "POST",
                    success: function( data ) {
                        console.log(data);
                        $('.alert-confirmacao').show();    
                        $('.btn_confirm_adiantamento').hide();
                        $('.hide-pfs').show();
                        $('.hide-pfs-2').hide();
                        $('.remove-balancete').hide();
                        $('.remove-adiantamento').hide();
                        $('.edit-diaria').hide();
                    },
                    error: function() {
                        console.log('erro');
                    }
                });
            }            
        })

        $('.btn-aviso-confirmacao').click(function() {
            $('.alert-pdfs').show();
        })

        // DELETANDO ALGUM REGISTRO
        $('.remove-adiantamento').click(function(e) {           
            var r = confirm("Deseja realmente deletar este adiantamento?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/removeadiantamento',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data );
                    $('#'+ id).remove();
                    window.location = '/SuprimentoFundos/adiantamento/1';
                    
                },
                error: function() {
                    console.log('erro');
                }
            });
        })

         // DELETANDO ALGUM REGISTRO
         $('.remove-balancete').click(function(e) {           
            var r = confirm("Deseja realmente deletar este balancete?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/removebalancete',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data.response);
                    if(data.response == 1) {
                        $('#'+ id).remove();
                        window.location = '/SuprimentoFundos/adiantamento/1';
                    }else{
                        $('.alert-deleteBalancete').show();
                    }
                 
                },
                error: function() {
                    console.log('erro');
                }
            });
        })

        // DELETANDO ALGUM REGISTRO
        $('.indefere-adiantamento').click(function(e) {           
            var r = confirm("Deseja realmente indeferir este adiantamento?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/indefere_adiantamento',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data );
                    window.history.back();                 
                },
                error: function() {
                    console.log('erro');
                }
            });
        })

         // DELETANDO ALGUM REGISTRO
         $('.confirm-adiantamento').click(function(e) {    
            console.log('confirm adiantamento');
            var r = confirm("Deseja realmente confirmar este adiantamento?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/confirm_adiantamento',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data );
                    $('#'+ id).remove();     
                    window.history.back();        
                },
                error: function() {
                    console.log('erro');
                }
            });
        })
    })  
</script>
