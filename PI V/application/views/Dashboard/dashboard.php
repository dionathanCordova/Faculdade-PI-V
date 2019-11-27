
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Indicadores</h3>
                <div class="panel box box-primary">     <br>
                    <form class="form-inline" action="/Dashboard/dashboardsDados/"<?php echo $tabela?> method="POST">
					   
						<?php if($_SESSION['nivel'] == 5):?>
							<div class="alert alert-warning">
								<strong>Warning!</strong> Não é possivel pesquisar por secretaria e servidores sem antes selecionar o exercício
							</div>
                        <?php else: ?> 

                        <div class="alert alert-warning">
                            <strong>Warning!</strong> Não é possivel pesquisar por servidores sem antes selecionar o exercício
                        </div>
                        <?php endif ?>

                        <div class="form-group">
                            <select class='form-control' type="text" name="exercicio" id='exercicio'  >
                                <?php echo $exercicio; ?>
                            </select>
                        </div>  

						<?php if($_SESSION['nivel'] < 5):?>
							<div class="form-group" style="display: none;">
								<select class='form-control' type="hidden" name="id_select_secretaria" id='id_select_secretaria'  required disabled >
										<?php echo $secretaria; ?>
								</select>
							</div>            
                        <?php else: ?> 

                        <div class="form-group">
                            <select class='form-control' type="text" name="id_select_secretaria" id='id_select_secretaria' >
                                <option value="">Secretaria</option>
                                <?php echo $secretaria; ?>
                            </select>
                        </div>    
                        <?php endif ?>

                        <div class="form-group">
                            <select class="form-control" name="nome_servidor" id="servidores" >
                                <option value="">Servidor</option>
                                <?php if($_SESSION['nivel'] < 5):?>
                                <?php foreach($diarias_nome as $info):?>
                                    <option value="<?php echo $info["servidor"];?>"><?php echo $info["servidor"];?></option>
                                <?php endforeach;?>
                                <?php endif ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="mes_diaria" id="sel1">
                                <option value="">Mes opcional</option>
                                <option value='01'>Janeiro</option>
                                <option value='02'>Fevereiro</option>
                                <option value='03'>Março</option>
                                <option value='04'>Abril</option>
                                <option value='05'>Maio</option>
                                <option value='06'>Junho</option>
                                <option value='07'>Julho</option>
                                <option value='08'>Agosto</option>
                                <option value='09'>Setembro</option>
                                <option value='10'>Outubro</option>
                                <option value='11'>Novembro</option>
                                <option value='12'>Dezembro</option>
                            </select>
                        </div>

                        <input type="text" name='tabela' id='tabela' value="<?php echo $tabela?>" hidden>
                        <div class="form-group">
                            <button class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span></button>
                        </div>
                    </form><br>
                </div>
            </div>
            <div class="box-body table-responsive-sm text-nowrap"  style="overflow-x:auto;">
                <div class="col-lg-3 col-xs-12">
                    <h3 id='ano'> Exercicio de <?php echo date('Y')?></h3>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="small-box bg-green box-indicador col-lg-3 col-xs-12">
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <div class="inner">
                            <h3>R$ <sup style="font-size: 20px" id="valor"><?php echo isset($freqData[0]['valor_anual'])? number_format($freqData[0]['valor_anual'], '2', ',',''): '0,00' ?></sup></h3>
                            <p id="Legenda"> Valor total do exercício</p>
                        </div>                        
                    </div>

                    <div class="col-lg-3 col-xs-12">
                        <h1>Total diárias : <?php echo  isset($Titulo)?  $Titulo : 'Nenhum registro encontrado' ?></h1>
                    </div>
					
                    <div id='dashboard' class="col-lg-12 col-xs-12">
						
						</div>
					</div>
				</div> 
				
				<div class="panel box box-primary"> 
					<div class='table-responsive'>
						<div class="panel panel-default">
							<div class="panel-heading  text-center" style="font-weight:bold; font-size: 3vmin">Relatório resumido</div>
							<div class="panel-body">
								<table id='example' class="table table-hover table-condensed table-striped table-conteudo" style='font-size:2vmin'> 
									<thead>
										<tr>
											<!-- <td><strong>ID</strong> </td> -->
											<td><strong>Secretaria</strong> </td>
											<?php if($nome_servidor != null):?>
											<td><strong>Servidor</strong> </td>
											<?php endif?>
											<td><strong>Exercicio</strong> </td>
											<td><strong>Total de diárias</strong> </td>
											<td><strong>Valor total</strong> </td>
											<td><strong>Gerar Relatorio</strong> </td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($diarias_relatorio as $info): ?>
										<?php $servidor = ($nome_servidor != null)? '/' . "{$info['portaria_matricula']}": '/none'?>
										<?php $mes = (isset($mesInit) != '' && isset($mesFim) != '')? '/' . "$mesInit" . '/' . "$mesFim": ''?>
										<tr>
											<td><?php echo $info['secretaria_nome']; ?></td> 
											<?php if($nome_servidor != null):?>
											<td><?php echo $info['servidor']; ?></td>
											<?php endif ?>
											<td><?php echo $info['exercicio']; ?></td>
											<td><?php echo $info['total_diarias']; ?></td>
											<td>R$ <?php echo $info['valor_total']; ?></td>
											<td>
												<a href="<?php echo base_url('Dashboard/relatorio/').$tabela.'/'.$info['id_secretaria']. '/' .  $info['exercicio'] . $servidor  . '/' . $mes ?>" target='_blank'>
													<button type='submit' class='btn btn-default col-sm-12' name='btn_id' value="<?php echo 'teae';?>"><i class="fa fa-print"></i> PDF Relatório</button></a>
												</a>
											</td>
										</tr>    
                                    <?php endforeach; ?>          
									</tbody> 
								</table>
							</div>
                        <div class="panel-footer text-right" style="font-weight:bold; font-size: 3vmin">
                            Soma Total: R$ <?php echo $soma_total?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var freqData = <?php echo json_encode($freqData) ?>;

    let exercicio = $("#exercicio").val();
    if(exercicio == '') {
        $('#id_select_secretaria').prop("disabled", true);
    }

    // MONTA O HTML CONTENDO SERVIDORES RELACIONADOS AO EXERCICIO SELECIONADO
    $('#exercicio').change(function() {
        let exercicio = $("#exercicio").val();
        if(exercicio == '') {
            $('#id_select_secretaria').prop("disabled", true);
        }else{
            $('#id_select_secretaria').prop("disabled", false);
            $('#ano').text('Exercicio de ' + exercicio);
        }

        let url = '/Dashboard/servidores_option/';   

        let id_secretaria = $('#id_select_secretaria').val();

        let mes = $('#mes').val();

        let tabela = $('#tabela').val();

        $.ajax({
            url: url,
            method:"POST",
            dataType:"json",
            data: {id_secretaria: id_secretaria, tabela: tabela, exercicio: exercicio},
            success:function(data) {
                console.log(data);
                // $('#exercicio').text('Exercício de ');
                $('#servidores').html(data.servidores);
            }
        });

    })

    // MONTA O HTML CONTENDO SERVIDORES RELACIONADOS A SECRETARIA SELECIONADA
    $('#id_select_secretaria').change(function() {
        let url = '/Dashboard/servidores_option/';   

        let id_secretaria = $('#id_select_secretaria').val();

        let exercicio = $("#exercicio").val();

        let mes = $('#mes').val();

        let tabela = $('#tabela').val();

        $.ajax({
            url: url,
            method:"POST",
            dataType:"json",
            data: {id_secretaria: id_secretaria, tabela: tabela, exercicio: exercicio, mes: mes},
            success:function(data) {
                console.log(data);
                $('#servidores').html(data.servidores);
            }
        });

    })

</script>

