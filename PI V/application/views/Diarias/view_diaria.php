<style>
    .alert-pdfs, .alert-confirmacao{
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
                <div class="form-group col-sm-12  alert-pdfs">
                    <div class="alert alert-danger alert-dismissible col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p>Os PDF´s estarão disponível somente após a finalização da proposta. <br> Finalize clicando no botão "Finalizar" listado nas opções. <br> Importante ressaltar que ao finalizar, a edição e exclusão da proposta não estarão mais disponíveis.</p>
                    </div>
                </div>

                <div class="form-group col-sm-12  alert-confirmacao">
                    <div class="alert alert-success alert-dismissible col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p>Proposta enviada.</p>
                    </div>
                </div>
                
                <h3 class="box-title"><strong> Pré-Visualização de diária </strong></h3>
               
                <div class="col-sm-12">
                    <?php if($_SESSION['nivel']):?>

                    <div class="btn-group pull-right col-sm-2" role="group" >
                        
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= 'Ações admin' ?>
                            <span class="caret"></span>
                        </button>
                            <ul class="dropdown-menu">
                                <a href="<?php echo base_url('Diarias/diarias')?>">
                                <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="glyphicon glyphicon-home"></i> Voltar</button></a>
                            </a> 
                            
                      
                            <button type='button' class='btn btn-success col-sm-12 confirm-documento' value="<?php echo $id_diaria;?>"><i class="fa fa-thumbs-up"></i> Deferir documento</button>
                            <button type='button' class='btn btn-warning col-sm-12 indefere-documento' value="<?php echo $id_diaria;?>"><i class="fa fa-thumbs-down"></i> Indeferir documento</button>
                        </ul>
                    </div>
                    <?php endif ?>

                    <div class="btn-group pull-right" role="group" >
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= 'Ações' ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <a href="<?php echo base_url('Diarias/diarias/1')?>">
                                <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="glyphicon glyphicon-home"></i> Voltar</button></a>
                            </a> 
                            <?php if($user_confirm_diaria == '1'):?>
                                <a href="<?php echo base_url('Diarias/Pdfdiaria/').$id_diaria?>" target='_blank'>
                                    <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="fa fa-print"></i> PDF Proposta</button></a>
                                </a>
                                <a href="<?php echo base_url('Diarias/Pdfrelatoriodiaria/').$id_diaria?>" target='_blank'>
                                    <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="fa fa-print"></i> PDF Relatório</button></a>
                                </a>
                            <?php else: ?>  
                                <div class='hide-pfs'>
                                    <a href="<?php echo base_url('Diarias/Pdfdiaria/').$id_diaria?>" target='_blank'>
                                        <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="fa fa-print"></i> PDF Proposta</button></a>
                                    </a>
                                    <a href="<?php echo base_url('Diarias/Pdfrelatoriodiaria/').$id_diaria?>" target='_blank'>
                                        <button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo $id_diaria;?>"><i class="fa fa-print"></i> PDF Relatório</button></a>
                                    </a>
                                </div>

                                <div class='hide-pfs-2'>
                                    <button class='btn btn-default col-sm-12 disabled btn-aviso-confirmacao'><i class="fa fa-print"></i> PDF Proposta</button>
                                    <button class='btn btn-default col-sm-12 disabled btn-aviso-confirmacao'><i class="fa fa-print"></i> PDF Relatório</button>
                                </div>
                            <?php endif ?>  
                            teste
                            <?php if($user_confirm_diaria != '1'):?>
                                <?php if($confirmacao == '0'):?>                           
                                    <button  class='btn btn-danger col-sm-12 text-center remove-diaria' value="<?php echo $id_diaria?>" name='id_ufm-confirmar'><i class='glyphicon glyphicon-trash'></i> Deletar</button>
                                    <a href="<?php echo base_url('Diarias/edit_diaria/').$id_diaria?>">
                                        <button type='submit' class='btn btn-primary col-sm-12 edit-diaria' name='btn_id' value="<?php echo $id_diaria;?>"><i class="glyphicon glyphicon-edit"></i> Editar</button></a>
                                    </a>
                                <?php endif ?>     
                            
                                <button type='button' class='btn btn-success col-sm-12 btn_confirm_diaria' value="<?php echo $id_diaria;?>"><i class="glyphicon glyphicon-ok"></i> Finalizar</button>
                            <?php endif ?>                
                        </ul>
                    </div> 
                </div> 
            </div>
            <div class="box-body">
                <div class="panel box box-primary "> 
                    <article class="flex-container" >
                        <div class="informacoes_gerais col-xs-12 text-center">
                            <h3><strong> PROPOSTA DE CONCESSÃO DE DIÁRIAS</strong></h3>
                            <p> Lei Municipal nº 1142/95 e 2.573/2013</p>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 1. PROPONENTE</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong> Nome: <?= $dados_diaria[0]['servidor']?></strong></td>
                                        <td><strong> Banco: <?= $dados_diaria[0]['banco']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong>  Cargo: <?= $dados_diaria[0]['cargo']?></strong></td>
                                        <td id="prop"><strong> Agência: <?= $dados_diaria[0]['agencia']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong>  Matrícula: <?= $dados_diaria[0]['portaria_matricula']?></strong></td>
                                        <td id="ap"><strong> Conta corrente: <?= $dados_diaria[0]['conta']?></strong></td>   
                                    </tr>
                                    <tr>
                                        <td class='col-xs-8'><strong>  CPF: <?= $dados_diaria[0]['cpf']?></strong></td>
                                        <td id="mes"><strong> Telefone: <?= $dados_diaria[0]['telefone']?></strong></td>   
                                    </tr>
                                </table>
                            </div>                   
                        </div>   
                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong>  2. LOCAL/SERVIÇO A SER EXECUTADO E PERÍODO DO AFASTAMENTO</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Data e Hora do Egresso: <?= $data_saida?></strong></td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Data e Hora do Retorno: <?= $data_retorno?></strong></td>
                                        <td id="prop"> </td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Localidade: <?= $dados_diaria[0]['cidade_destino'] . ' - ' . $dados_diaria[0]['estado_destino']?></strong></td>
                                        <td id="ap"></td>   
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Veículo: <?= $dados_diaria[0]['veiculo']?></strong></td>
                                        <td id="mes"> </td>   
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Motivo: <?= $dados_diaria[0]['motivo']?></strong></td>
                                        <td id="mes"> </td>   
                                    </tr>
                                </table>
                            </div>                   
                        </div> 

                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 3. VALOR DA DIÁRIA</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-6'><strong>  Nº de Diárias Concedidas: <?= $dados_diaria[0]['tempo_total']?></strong></td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12 '><strong> Total: R$ <span class='bg-warning'> <?= number_format($dados_diaria[0]['valor_total'],'2', ',','')?></span><strong></td>
                                        <td id="prop"> </td>
                                    </tr>
                                </table>
                            </div>                   
                        </div> 

                        <div class="informacoes_gerais col-xs-12 text-center" style='margin-top:2vmin;'>
                            <div  style='border: 1px solid black' class=' text-left'>
                                <table id="infoGeral" class='table table-condensed'>
                                    <tr>
                                        <td colspan="3" class="h3 cabecalho text-left"><h3><strong> 4. CLASSIFICAÇÃO ORÇAMENTÁRIA</strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Órgão: <?= $dados_diaria[0]['orgao'] . ' - ' . $dados_diaria[0]['fundo']?></strong></td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Código Reduzido: <?= $dados_diaria[0]['codigo_reduzido'] ?></strong></td>
                                        <td id="prop"> </td>
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Atividade: <?= $dados_diaria[0]['atividade']?></strong></td>
                                        <td id="ap"></td>   
                                    </tr>
                                    <tr>
                                        <td class='col-xs-12'><strong> Elemento de Despesa: <?= $dados_diaria[0]['elemento_despesa']?> - Diárias de viagem - Pessoa civil</strong></td>
                                        <td id="mes"> </td>   
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

        $('.btn_confirm_diaria').click(function() {
            var id = $(this).val()

            var conf = confirm('Deseja realmente enviar a proposta? Ao confirmar não será mais possível ( EDITAR / DELETAR ) a diária');

            if(conf == true) {
                $.ajax({
                    url: '/Diarias/confirmar_diaria',
                    data: { id: id},
                    dataType: "json",
                    type: "POST",
                    success: function( data ) {
                        console.log(data);
                        $('.alert-confirmacao').show();    
                        $('.btn_confirm_diaria').hide();
                        $('.hide-pfs').show();
                        $('.hide-pfs-2').hide();
                        $('.remove-diaria').hide();
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
        $('.remove-diaria').click(function(e) {           
            var r = confirm("Deseja realmente deletar esta diária?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/removediarias',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data );
                    $('#'+ id).remove();
                    window.location = '/Diarias/diarias/1';
                    
                },
                error: function() {
                    console.log('erro');
                }
            });
        })


        $('.indefere-documento').click(function(e) {           
            var r = confirm("Deseja realmente indeferir este documento?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/indefere_diaria',
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

         $('.confirm-documento').click(function(e) {    
            var r = confirm("Deseja realmente deferir este documento?");
            if (r == false) {
                return false
            }
        
            id = $(this).val();
            $.ajax({
                url: '/home/confirm_diaria',
                data: { id: id},
                dataType: "json",
                type: "POST",
                success: function( data ) {
                    console.log( data );
                    // $('#'+ id).remove();     
                    window.history.back();        
                },
                error: function() {
                    console.log('erro');
                }
            });
        })
    })  
</script>
