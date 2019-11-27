<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?php echo base_url('/assets/images/bandeira.png')?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo base_url('/assets/images/bandeira.png')?>" type="image/x-icon" />
    <title>Controle Diarias Camboriu</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/template/estilo.css')?>">
    
    <script src="<?php echo base_url('assets/js/library/jquery.js')?>"></script>
    <!-- <script>var base_url = '<?= base_url('index.php/home/cad_diaria') ?>';</script> -->
    <script src="<?php echo base_url('assets/js/main.js')?>"></script>
    <script src="<?php echo base_url('assets/js/ajax.js')?>"></script>
    <script src="<?php echo base_url('/assets/js/popper.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js')?>"></script>

    
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/dataTables.foundation.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.foundation.min.js"></script> -->

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.24.3/css/uikit.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/dataTables.uikit.min.css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.uikit.min.js"></script> -->

     <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script> -->

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.min.css" rel="stylesheet">    
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.foundation.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.foundation.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.foundation.min.js"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet"> -->

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.material.min.js"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.material.min.css" rel="stylesheet"> -->

</head>
<body>
    <header>
        <nav id="menu" class='navbar'>
            <div id="links" class='container-fluid'>
                <div class='navbar-nav navbar-header'>
                    <a class='navbar-brand'href="<?php echo base_url('home/lei')?>">LEI N&ordm;1142/95</a>
                </div>

                <ul class='nav navbar-nav'>
                    <li><a href="<?php echo base_url('home/diarias/1')?>">DIÁRIAS</a></li>
                    <li><a href="<?php echo base_url('home/ufms/1')?>">UFMS</a></li>
                    <!-- <li><a href="<?php echo base_url('home/teste')?>">teste</a>   </li> -->
                </ul>

                <ul class='nav navbar-nav navbar-right'>
                    <li><a href="<?php echo base_url('/home/sair')?>">SAIR</a></li>
                </ul>                
            </div>
        </nav>
    </header>

    <!-- <main class="main container-fluid"> -->
    <img id="bandeira"src="<?php echo base_url('/assets/images/bandeira1.png')?>" alt="">

    <?php $this->load->view($viewName);?>
    <!-- </main> -->

    <footer class='container-fluid'>
        <div id='left' class='col-sm-6 col-xs-12'>
            <p>Copyrigth © 2018 Todos direitos reservados - Prefeitura de Camboriú</p>
        </div>

        <div id='right' class='col-sm-6 col-xs-12 '>
            <p>Desenvolvido por <strong>Controladoria-Geral do Município de Canboriú</strong></p>
        </div>
    </footer>
    
</body>
<script type="text/javascript">
    $(document).ready(function(){
        // $('#registros').DataTable({
        //     "oLanguage":{
        //         "sProcessing"   :"Processando...",
        //         "sLengthMenu"   :"Mostrar _MENU_ registros",
        //         "sZeroRecords"  :"Não foram encontrados resultados",
        //         "sInfo"         :"Exibindo _START_ até _END_ of _TOTAL_ resultados",
        //         "sInfoEmpty"    :"Buscando 0 to 0 de 0 resultados",
        //         "sInfoFiltered" :"(Total de resultados _MAX_)",
        //         "sInfoPostFix"  :"",
        //         "sSearch"       :"Buscar",
        //         "sUrl"          :"",
        //         "oPaginate"     :{
        //             "sFirst"    :"Primeiro",
        //             "sPrevious" :"Anterior",
        //             "sNext"     :"Seguinte",
        //             "sLast"     :"Último"
        //         }
        //     }
        // });
        // $('.ufm').DataTable({
        //     "oLanguage":{
        //         "sProcessing"   :"Processando...",
        //         "sLengthMenu"   :"Mostrar _MENU_ registros",
        //         "sZeroRecords"  :"Não foram encontrados resultados",
        //         "sInfo"         :"Exibindo _START_ até _END_ of _TOTAL_ resultados",
        //         "sInfoEmpty"    :"Buscando 0 to 0 de 0 resultados",
        //         "sInfoFiltered" :"(Total de resultados _MAX_)",
        //         "sInfoPostFix"  :"",
        //         "sSearch"       :"Buscar",
        //         "sUrl"          :"",
        //         "oPaginate"     :{
        //             "sFirst"    :"Primeiro",
        //             "sPrevious" :"Anterior",
        //             "sNext"     :"Seguinte",
        //             "sLast"     :"Último"
        //         }
        //     }
        // });
        // $(".dataTables_length").append('<br>');
        // $(".dataTables_length").append('<br>');
        // $("#registros_filter").hide();
        // $("#registros_info").hide();
        // function() {
            // alert("achoiu");
        // })
    });
    </script>
</html>