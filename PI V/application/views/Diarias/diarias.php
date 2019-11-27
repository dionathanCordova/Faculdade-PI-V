
<div class='url' style='display:none'><?php echo base_url('Diarias/dados_model_diaria')?></div>
<div class='url1' style='display:none'><?php echo base_url('Diarias/pdfDiaria')?></div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong> Cadastro de Diária </strong></h3>
            </div>
            <div class="box-body">
                <div class="panel box box-primary"> 
                    <?php if($_SESSION['nivel'] == 5):?>
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> Não é possivel pesquisar por secretaria e servidores sem antes selecionar a secretaria
                        </div>
                        <?php else: ?> 
                            <br>
                    <?php endif ?>

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
       
            url = "<?php echo base_url(); ?>Diarias/pagination/"+page+'/'+Secretaria;
         
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