
<div class='url' style='display:none'><?php echo base_url('Diarias/dados_model_diaria')?></div>
<div class='url1' style='display:none'><?php echo base_url('Diarias/pdfDiaria')?></div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong> Cadastro de Adiantamento de Valores </strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
                    <form class="form-inline" action="" method="POST">
                        <?php if($_SESSION['nivel'] == 5): ?>
                            <div class="form-group">
                                <label for="servidor">Secretaría: </label>
                                <select class='form-control' type="text" name="id_select_secretaria" id='id_select_secretaria' required>
                                    <?php echo $secretaria; ?>
                                </select>
                            </div>                 
                        <?php endif?>

                        <!-- <div class="form-group">
                            <select class="form-control" name="nome_servidor" id="sel1">
                                <option value="">Servidor</option>
                                <?php foreach($diarias_nome as $info):?>
                                    <option value="<?php echo $info["servidor"];?>"><?php echo $info["servidor"];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="mes_diaria" id="sel1">
                                <option value="">Mes opcional</option>
                                <option value='2017-01-01'>Janeiro</option>
                                <option value='2017-02-01'>Fevereiro</option>
                                <option value='2017-03-01'>Março</option>
                                <option value='2017-04-01'>Abril</option>
                                <option value='2017-05-01'>Maio</option>
                                <option value='2017-06-01'>Junho</option>
                                <option value='2017-07-01'>Julho</option>
                                <option value='2017-08-01'>Agosto</option>
                                <option value='2017-09-01'>Setembro</option>
                                <option value='2017-10-01'>Outubro</option>
                                <option value='2017-11-01'>Novembro</option>
                                <option value='2017-12-01'>Dezembro</option>
                            </select>
                        </div> -->
                        
                        <div class="form-group">
                            <a href="/home/inicio"><button class='btn btn-success btn-sm'><span class='	glyphicon glyphicon-search'></span></button> </a>
                        </div>
                    </form><br>

                    <div class='table-responsive'>
                        <div class="table-responsive" id="country_table"></div> 
                        <div align="right" id="pagination_link"></div>

                        <!-- <table id='example' class="table table-hover table-condensed table-striped table-conteudo" style='font-size:2vmin'> 
                            <thead>
                                <tr>
                                    <td><strong>ID</strong> </td>
                                    <td><strong>Servidor</strong> </td>
                                    <td><strong>CPF</strong> </td>
                                    <td><strong>Telefone</strong> </td>
                                    <td><strong>Data Cadastro</strong> </td>
                                    <td><strong>Valor Diária</strong> </td>
                                    <td><strong>Secretaría</strong> </td>
                                    <?php if($_SESSION['nivel'] == 5):?>
                                        <td><strong>Contas</strong> </td>
                                        <td class='text-center'><strong>Opções</strong> </td>
                                    <?php endif ?>
                                    <?php if($_SESSION['nivel'] < 5):?>                                                 
                                        <td><strong>Status</strong> </td>
                                        <td class='text-center'><strong>Opções</strong> </td>
                                    <?php endif ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($supr_fundos as $info): ?>
                                <tr class="<?php echo ($info['visualizado'] == 0) ? "bg-light-blue disabled color-palette" : '' ?>" id="<?php echo $info['id']?>">
                                    <td><?php echo $info['id']; ?></td>
                                    <td><?php echo $info['responsavel']; ?></td>
                                    <td><?php echo $info['cpf'] ?></td>
                                    <td><?php echo $info['telefone'] ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($info['data_cadastro'])); ?></td>
                                    <td><?php echo ($info['valor_solicitacao']) != '' ? 'R$ '. $info['valor_solicitacao']: "nd"; ?></td>
                                    <td><?php echo $info['fundo'] ?></td>
                                    <?php if($_SESSION['nivel'] == 5):?>
                                        <?php if($info['confirmacao'] == '0'): ?>
                                        <td>   
                                            <button  class='btn btn-success btn-xs confirm-adiantamento'  value="<?php echo $info["id"]?>" name='id_diaria-confirmar'><span class='fa fa-thumbs-up'></span></button>                                                
                                            <button  class='btn btn-warning btn-xs indefere-adiantamento'  value="<?php echo $info["id"]?>" name='id_diaria-indeferir'><span class='fa fa-thumbs-down'></span></button>
                                        </td>           
                                        <?php endif?>            
                                        
                                        <?php if($info['confirmacao'] == 's'): ?>
                                            <td> 
                                                 <button class='btn btn-success btn-xs disabled'> Pestada </button>
                                            </td>                                                                                                                                                                    
                                        <?php endif?>    


                                        <?php if($info['confirmacao'] == 'n'): ?>
                                            <td>   
                                               <button class='btn btn-danger btn-xs disabled'> Indeferida </button>
                                            </td>  
                                        <?php endif?>   
                                    <?php endif ?>

                                    <?php if($_SESSION['nivel'] < 5):?>
                                        <?php if($info['confirmacao'] == '0'):?>
                                            <td> 
                                                <span class="label label-warning">Em Análise </span>
                                            </td>
                                        <?php endif ?>
                                    
                                        <?php if($info['confirmacao'] == "s"):?>
                                            <td> 
                                                <span class="label label-success">Contas Prestadas</span>
                                            </td>
                                        <?php endif ?>

                                        <?php if($info['confirmacao'] == "n"):?>
                                            <td> 
                                                <span class="label label-danger">Indeferido</span>
                                            </td>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <td class='text-center'> 
                                        <a href="<?php echo base_url('SuprimentoFundos/view_adiantamento/').$info['id']?>">
                                            <button type='submit' class='btn btn-default btn-xs' name='btn_id' value="<?php echo $info['id'];?>"><i class='glyphicon glyphicon-eye-open'></i></button></a>
                                        </a>
                                    </td>

                                </tr>                            
                                <?php endforeach; ?>          
                            </tbody> 
                        </table> -->
                    </div>
                 

                    <!-- <div class="paginacao">
                        <?php
                        if(isset($pagina)) {
                            $p = $pagina;
                        }else{
                            $p = 0;
                        }

                        $_SESSION['p'] = 0;
                        if($p >= 0) {
                            $anterior = $p - 1;
                            $_SESSION['p'] = $anterior;
                        }
                        if($p <= $count) {
                            $proxima = $p + 1;
                            $_SESSION['p'] = $proxima;
                        }
                        
                        if($anterior <= 0) {
                            $anterior = 0;
                        }
                        if(isset($proxima) && $proxima >= $count){
                            $proxima = $count;
                        }
                        ?>

                        <?php if($count > $total_registros):?>
                            <ul class="pagination">
                                <?php if($p > 1):?>
                                    <li><a class='pagina' href="<?php echo base_url('/SuprimentoFundos/adiantamento/' . 1);?>"><</a></li>
                                    <li><a class='pagina' href="<?php echo base_url('/SuprimentoFundos/adiantamento/' .$anterior);?>"><?=$anterior;?></a></li>
                                <?php endif?>

                                <li class='bg-info' style='background:blue'><a class='pagina active' href="<?php echo base_url('/SuprimentoFundos/adiantamento/') .$p;?>"><?=$p;?></a></li>

                                <?php if($pHome+12 <= $count):?>
                                    <li><a class='pagina' href="<?php echo base_url('/SuprimentoFundos/adiantamento/' .$proxima);?>"><?=$proxima;?></a></li>
                                    <li><a class='pagina' href="<?php echo base_url('/SuprimentoFundos/adiantamento/' .$proxima);?>">></a></li>
                                <?php endif?>
                            </ul>
                        <?php endif;?>
                    </div>   -->
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
     $(document).ready(function() {

        function load_country_data(page, Secretaria = null) {

            if(Secretaria == null) {
                url = "<?php echo base_url(); ?>SuprimentoFundos/pagination/"+page
            }else{
                url = "<?php echo base_url(); ?>SuprimentoFundos/pagination/"+page+'/'+id_secretaria;
            }

            console.log(Secretaria);
            $.ajax({
                url: url,
                method:"GET",
                dataType:"json",
                success:function(data) {
                    $('#country_table').html(data.country_table);
                    $('#pagination_link').html(data.pagination_link);
                }
            });
        }

        load_country_data(1);

        let id_secretaria = 0;
        $('.form-inline').on('change', function() {
            id_secretaria = $('#id_select_secretaria').val();
            load_country_data(1, id_secretaria);
    
            $(document).on('click', '.pagination li a', function(event) {
                event.preventDefault();
                let page = $(this).data('ci-pagination-page');
                load_country_data(page, id_secretaria);
            })
        });

        if(id_secretaria == 0){
            $(document).on('click', '.pagination li a', function(event) {
                event.preventDefault();
                let page = $(this).data('ci-pagination-page');
                load_country_data(page);
            })
        }else{
            $(document).on('click', '.pagination li a', function(event) {
                event.preventDefault();
                let page = $(this).data('ci-pagination-page');
                load_country_data(page, id_secretaria);
            })
        }
       

            
       
     })
</script>