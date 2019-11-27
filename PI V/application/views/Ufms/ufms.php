
<div class='url' style='display:none'><?php echo base_url('Ufms/dados_model_ufm')?></div>
<div class='url1' style='display:none'><?php echo base_url('home/pdfUfm')?></div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong>Diárias Agêntes Políticos</strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    <?php if($_SESSION['nivel'] == 5):?>
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> Não é possivel pesquisar por secretaria e servidores sem antes selecionar a secretaria
                        </div>
                    <?php endif ?>
                    <br>
					
                    <form class="form-inline" action="" method="POST">
                        
                        <?php if($_SESSION['nivel'] < 5):?>
                        <div class="form-group" style="display: none;">
                            <select class='form-control' type="hidden" name="id_select_secretaria" id='id_select_secretaria'  required disabled >
                                <option value="<?php echo $_SESSION['secretaria']?>">Secretaria</option>
                            </select>
                        </div>            
                        <?php else: ?> 
                        <div class="form-group">
                            <select class='form-control' type="text" name="id_select_secretaria" id='id_select_secretaria' >
                                <option value="0">Secretaria</option>
                                <?php echo $secretaria; ?>
                            </select>
                        </div>    
                        <?php endif ?>

                        <div class="form-group">
                            <select class="form-control" name="nome_servidor" id="servidores">
                                <option value="">Servidor</option>
                            </select>
                        </div>
                    </form><br>
                                                                 
                    <div class='table-responsive'>
                        <div class="table-responsive" id="country_table"></div> 
                        <div align="right" id="pagination_link"></div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
<script>
     $(document).ready(function() {

        let secretaria = $('#id_select_secretaria').val();

        if(secretaria == '0') {
            $('#servidores').prop('disabled', true);
        }

        // IMPEDINDO TROCA DE SERVIDOR CASO NAO SELECIONAR A SECRETARIA
        $('#id_select_secretaria').change(function(e) {    
            let secretaria = $('#id_select_secretaria').val();
            if(secretaria == '0') {
                $('#servidores').prop('disabled', true);
            }else{
                $('#servidores').prop('disabled', false);
            }
        })

        function load_country_data(page, Secretaria = null, servidor = null) {

            url = "<?php echo base_url(); ?>Ufms/pagination/"+page+'/'+Secretaria;
            
                $.ajax({
                    url: url,
                    method:"POST",
                    data: {Secretaria: Secretaria, servidor: servidor, page:page},
                    dataType:"json",
                    success:function(data) {
                        console.log(data.response);
                        $('#servidores').html(data.servidores);
                        $('#country_table').html(data.country_table);
                        $('#pagination_link').html(data.pagination_link);
                    }
                });
            }

            $('.form-inline').on('change', function() {
                secretaria = $('#id_select_secretaria').val();
                servidores = $('#servidores').val();
            
                load_country_data(1, secretaria, servidores);

                $(document).on('click', '.pagination li a', function(event) {
                    event.preventDefault();
                    let page = $(this).data('ci-pagination-page');
                    load_country_data(page, secretaria, servidores);
            })
        });

        let servidores = $('#servidores').val();
        $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            let page = $(this).data('ci-pagination-page');
            load_country_data(page, secretaria, servidores);
        })

        load_country_data(1, secretaria, servidores);    
     })
</script>





<!-- 

<table id='example' class="table table-hover table-condensed table-striped table-conteudo" style='font-size:2vmin'> 
    <thead>
        <tr>
            <td><strong>Servidor</strong> </td>
            <td><strong>Destino</strong> </td>
            <td><strong>Data Saída</strong> </td>
            <td><strong>Data Retorno</strong> </td>
            <td><strong>Total Horas/Dias</strong> </td>
            <td><strong>UFMS</strong> </td>
            <td><strong>Valor Total</strong> </td>  
        </tr>
    </thead>

    <tbody>
        <?php foreach($dados as $info): ?>
        <tr>
            <td><?php echo $info['id_secretaria']; ?></td>
            <td><?php echo $info['servidor']; ?></td>
            <td><?php echo $info['cidade_destino'] . ' - ' . $info['estado_destino']; ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($info['data_saida'])); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($info['data_retorno'])); ?></td>
            <td><?php echo $info['tempo_total']; ?></td> 
            <td><?php echo $info['ufm']; ?></td>
            <td>R$ <?php echo $info['valor_total']; ?></td>
        </tr>    
        <?php endforeach; ?>          
    </tbody> 
</table> -->