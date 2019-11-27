<script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>

<p class='url' style='display:none'><?php echo base_url('home/municipio');?></p>
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header ">
                  <h3 class="box-title"><strong> BALANCETE DE PRESTAÇÃO DE CONTAS/ADIANTAMENTO </strong></h3>
            </div>

            <div class="box-body">
                <div class="panel box box-primary"> 
                    
                    <br>
                    <div class="panel-body no-padding">
                        <!--  -->
                    </div>

                    <div class="container col-md-12">
                        <div class="nav-tabs-custom">
                            
                            <div class="tab-content container-fluid">   
                                <div id="home" class="tab-pane fade in active col-sm-12">   
                                    <h2 class='text-center'><strong>BALANCETE DE PRESTAÇÃO DE CONTAS/ADIANTAMENTO</strong></h2>      
                                    <h4 class='text-center'><strong>PREFEITURA MUNICIPAL DE CAMBORIÚ</strong></h4> 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Mes</th>
                                                <th colspan='3'>Ano</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>BENEFICIADO:</td>
                                                <td colspan='4'> <?= $dados_adiantamento[0]['responsavel']?></td>
                                            </tr>
                                            <tr>
                                                <td>CPF: </td>
                                                <td colspan='4'><?= $dados_adiantamento[0]['cpf']?></td>
                                            </tr>
                                            <tr>
                                                <td>ENDEREÇO: </td>
                                                <td colspan='4'>RUA GETÚLIO VARGAS  77 CENTRO   CAMBORIÚ/SC</td>
                                            </tr>
                                            <tr>
                                                <td>CEP: </td>
                                                <td colspan='4'>88340-000</td>
                                            </tr>
                                            <tr>
                                                <td>VALOR: </td>
                                                <td colspan='4'>R$ <?= number_format($dados_adiantamento[0]['valor_solicitacao'], '2', ',', '')?></td>
                                            </tr>
                                            <tr>
                                                <td>OBJETIVO: </td>
                                                <td colspan='4'> <?= $dados_adiantamento[0]['motivo'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h2 class='text-center'><strong>HISTÓRICO</strong></h2>     
                                    <form action="<?php echo base_url('SuprimentoFundos/gerar_balancete/'.$id);?>" method="POST" class='form_historico col-sm-12'>    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>DATA DEPÓSITO: </td>
                                                <td><input type="text" placeholder="Data deposito" class='form-control col-sm-2' name='datadeposito_1' id='data_deposito' required></td>
                                            </tr>
                                            <tr>
                                                <th>RECIBO</th>
                                                <th>DATA</th>
                                                <th>NOME RAZÃO SOCIAL</th>
                                                <th>PAGAMENTOS</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody id='historico-balancete'>

                                        </tbody>
                                    </table>
                                     
                                </div>
                                <div class="form-group col-sm-4">
                                        <div class="form-group col-sm-2">
                                            <a href="#"><button class='btn btn-success' type="button" id='add_campo'><strong> +</strong></button></a><br><br>
                                        </div>
                                        <div class="form-group col-sm-1">
                                            <button class='btn btn-success' id='submit'>Enviar</button>
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

<script>
    $(document).ready(function() {

        // MASCARA PARA O CPF DO CADASTRO DO MODAL
        $('#data_deposito').keyup(function() {
            $('#data_deposito').inputmask({
                // mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                mask: ["99/99/9999"],
                keepStatic: true
            });
        });
        
        let contagem = 1;
      
        $("#add_campo").click(function() {   
            let historico = document.querySelector('#historico-balancete');
            let tr = document.createElement('tr');

            let td_recibo = document.createElement('td');
            let input_recibo = document.createElement('input');
            input_recibo .setAttribute('class','form-control');
            input_recibo .setAttribute('placeholder','recibo');
            // input_recibo .setAttribute('name','recibo_'+contagem);
            input_recibo .setAttribute('name','recibo[]');

            td_recibo.appendChild(input_recibo);

            let td_data = document.createElement('td');
            let input_data = document.createElement('input');
            input_data .setAttribute('class','form-control');
            input_data .setAttribute('id','data_pagamento');
            input_data .setAttribute('placeholder','data');
            // input_data .setAttribute('name','data_'+contagem);
            input_data .setAttribute('name','data[]');

            td_data.appendChild(input_data);

            let td_razao_social = document.createElement('td');
            let input_razao_social = document.createElement('input');
            input_razao_social .setAttribute('class','form-control')
            input_razao_social .setAttribute('placeholder','razao social')
            // input_razao_social .setAttribute('name','razaosocial_'+contagem);
            input_razao_social .setAttribute('name','razaosocial[]');

            td_razao_social.appendChild(input_razao_social);

            let td_pagamento = document.createElement('td');
            let input_pagamento = document.createElement('input');
            input_pagamento.setAttribute('class','form-control')
            input_pagamento.setAttribute('placeholder','pagamento')
            //input_pagamento.setAttribute('class','pagamento');
            input_pagamento.setAttribute('name','pagamento[]');

            td_pagamento.appendChild(input_pagamento);

            tr.appendChild(td_recibo);
            tr.appendChild(td_data);
            tr.appendChild(td_razao_social);
            tr.appendChild(td_pagamento);

            historico.appendChild(tr);
            contagem += 1;
        });
        
        // MASCARA PARA O data_pagamento 
        $('#data_pagamento').keyup(function() {
            $('#data_pagamento').inputmask({
                // mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                mask: ["99/99/9999"],
                keepStatic: true
            });
        });
      
    })
</script>