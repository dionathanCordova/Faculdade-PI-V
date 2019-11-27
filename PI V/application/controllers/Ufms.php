<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ufms extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // carreganho o model Tabelas_model e setando um apelido de Tabelas
        $this->load->model('Tabelas_model', 'Tabelas');
        $this->load->model('Estados_model', 'Estados');
        $this->load->model('Cidades_model', 'Cidades');
        $this->load->model('Veiculo_model', 'Veiculo');
        $this->load->model('Secretaria_model', 'Secretaria');
        $this->load->model('ModalUfm_model', 'Modal_ufm');
        $this->load->model('Distancia_model', 'Distancia');
        $this->load->model('Project_model', 'PjModel');
        $this->load->model('Pagination_model', 'PagModel');
        $this->load->model('Ufm_model', 'Ufm');
        $this->load->helper('url');

        
    }

    public function pagination() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        if(!empty($this->input->post('servidor') && $this->input->post('servidor') != null)) {
            $total_registros = $this->PagModel->count_all_pagination('ufms', 'id_secretaria', $this->input->post('Secretaria'), $this->input->post('servidor'));
        }else{
            $total_registros = $this->PagModel->count_all_pagination('ufms', 'id_secretaria', $this->input->post('Secretaria'));
        }
       
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";  
        $config["total_rows"] = $total_registros;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        // NOMES DE SERVIDORES COM DIARIAS CADASTRADAS
        $secretaria = $this->input->post('Secretaria') != 0 ? $this->input->post('Secretaria'): 0;
        $servidores = $this->input->post('servidor') != ''  ? $this->input->post('servidor')  : null; 
        $servidores_select = $this->Tabelas->Servidor_nome_busca('ufms',  $secretaria ); 
       
        $output = array(
            'servidores' => $servidores_select,
            'response' =>  array('Secretariass' => $secretaria, 'servidor' => $this->input->post('servidor'), 'cont_total' => $total_registros),
            'pagination_link'  => $this->pagination->create_links(),
            'country_table'   => $this->PagModel->fetch_details_ufms($config["per_page"], $start, 'id_secretaria', intval($secretaria), $servidores )
        );
       
        
        echo json_encode($output);
    }

    // JA FOI @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    public function ufms() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        $dados['secretaria'] = $this->Secretaria->GetSecretaria();

        $dados['viewName'] = 'Ufms/ufms';
        $this->load->view('index', $dados);
    }

    public function servidores_option() {
        $servidor = $this->input->post('servidor');sleep(1);
        echo $this->PjModel->options_servidores($servidor);      
    }

  

    public function cad_ufms() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        // mensagem de erro caso haja algum
        $dados['msg'] = '';

        $dados['estado'] = $this->Estados->GetEstados();
        $dados['veiculo'] = $this->Veiculo->select_veiculos();
        $dados['secretaria'] = $this->Secretaria->GetSecretaria();

         // Pega os dados dos servidores cadastrados na secretaria     
         $id_secretaria = ($_SESSION['nivel'] != 5) ? $_SESSION['secretaria'] : (isset($_POST['id_select_secretaria']) ? $_POST['id_select_secretaria']: '0');
         $dados['servidores_registrados'] = $this->PjModel->options_servidores($id_secretaria);
 
         if($id_secretaria != 0){
             $dados['secretaria_selecionada'] = $this->PjModel->getDadosSecretaria($id_secretaria);
         }

        if(isset($_POST['servidor'])) {
             
            // CONFIGUDANDO OS VALORES DE HORA DE DATA QUE VEM DO FORMULARIO E SETANDO NO FORMATO PARA O DB
            $hora_saida = $_POST['hora_saida'] .':00';
            $data_saida = str_replace('/', '-', $_POST['data_saida']);
            $data_saida = date('Y-m-d', strtotime($data_saida));
            $data_saida = $data_saida. ' ' . $hora_saida;

            $hora_retorno = $_POST['hora_retorno'] .':00';
            $data_retorno = str_replace('/', '-', $_POST['data_retorno']);
            $data_retorno = date('Y-m-d', strtotime($data_retorno));           
            $data_retorno = $data_retorno . ' ' . $hora_retorno;      

            $distancia = $this->Distancia->Get_distancia($_POST['cidade_destino'], $_POST['estado_destino']);
            $distancia = $distancia[0]['distancia'];
 
            if($this->input->post('modelo') == "" &&  $this->input->post('placa') == "") {
                $veiculo = 'Particular / Outros';
            }else{
                $veiculo = strtoupper($_POST['modelo']) . ' ' . $_POST['placa']; 
            }
            $matricula = str_replace(['.', '/', ','], '', $_POST['matricula']);
            $dados_insert = array(
                'servidor'=>ucwords($_POST['servidor']),
                'id_secretaria' => $id_secretaria,
                'estado_destino'=>$_POST['estado_destino'],
                'cidade_destino'=>$_POST['cidade_destino'],
                'distancia_destino'=> $distancia,
                'portaria_matricula' => $matricula ,
                'banco' => ucwords($_POST['banco']),
                'agencia' => $_POST['agencia'],
                'veiculo' =>  $veiculo,
                'cpf' => $_POST['cpf'],
                'cargo' => ucwords($_POST['cargo']),
                'motivo' => ucwords($_POST['motivo']),
                'conta' => $_POST['conta'],
                'data_saida'=>  $data_saida,
                'data_retorno'=> $data_retorno,
                'exercicio' => date('Y'),
                'data_cadastro'=>date('Y-m-d'),
                'valor_ufm' => $_POST['valor_ufm'],
                'telefone' =>$_POST['telefone'],
                'created_by' => $_SESSION['usuario']
            );        
                   
            // calculo de diferenca de dias entre saida e retorno
            $saida = date('Y-m-d H:i:s', strtotime($data_saida));
            $retorno = date('Y-m-d H:i:s', strtotime($data_retorno));
            $t_s = strtotime($saida);
            $t_r = strtotime($retorno);
            $diferenca = $t_r - $t_s;
            $data = (float)($diferenca / (60 * 60 * 24) );

            // conversao de tempo exato em dias, horas, minutos;
            $data_a = new DateTime($data_saida);
            $data_b = new DateTime($data_retorno);
            $intervalo = date_diff($data_a,$data_b);

            if($intervalo->format('%D') > 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s) + %H Hora(s)');
            }elseif($intervalo->format('%D') > 1 && $intervalo->format('%H') == 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s)');
            }elseif($intervalo->format('%D') == 0 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%H Hora(s)');
            }elseif($intervalo->format('%D') > 0 && $intervalo->format('%D') <= 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária + %H Hora(s)');            
            }     

            $estado = $_POST['estado_destino'];
         
            // Condiçoes definidas na lei de diarias
            if($estado == "EX") {
                $horas_consedidas = (400 * $data) / 1; 
                $dados_insert['ufm'] = 'U$';
                $dados_insert['valor_total'] = number_format($horas_consedidas, 2, '.', '');
            }else{
             
                $ufm = 0;
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA INFERIOR A 100 KM
                if($distancia < 100) {
                    if($data <= 0.5) {
                        $ufm = 6;
                        $horas_consedidas  = 6;
                    }elseif($data > 0.5) {
                        $ufm = 6;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }
                
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA SUPERIOR A 100 KM
                if($distancia > 100) {
                    if($data <= 0.5) {
                        $ufm = 9;
                        $horas_consedidas  = 9;
                    }elseif($data > 0.5) {
                        $ufm = 9;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PERIODO ACIMA DE 24 HORAS
                if($data >= 1 ) {
                    $ufm = 17;
                    $horas_consedidas = ($ufm * $data) / 1;
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PARA DF
                if($data >= 1 && $estado == "DF") {
                    $ufm = 25;
                    $horas_consedidas = ($ufm * $data) / 1;
                }
                
                $dados_insert['ufm'] = $horas_consedidas;
                $valor = $horas_consedidas * $_POST['valor_ufm'];

                $dados_insert['valor_total'] = number_format($valor, 2, '.', '');
            }
       
            $cad = $this->db->insert('ufms', $dados_insert);
            if($cad) {
                redirect('Ufms/ufms/1');
            }            
            $dados['msg'] = "Cadastro efetuado com sucesso!";            
        };
        $dados['viewName'] = 'Ufms/cad_ufms';
        $this->load->view('index', $dados);
    }

    public function cadUfmsServidorCadastrado() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();
        
        if(isset($_POST['id_servidor'])) {
            $servidor = $this->PjModel->getDadosServidor($_POST['id_servidor']);
           
            $hora_saida = $_POST['hora_saida'] .':00';
            $data_saida = str_replace('/', '-', $_POST['data_saida']);
            $data_saida = date('Y-m-d', strtotime($data_saida));
            $data_saida = $data_saida. ' ' . $hora_saida;

            $hora_retorno = $_POST['hora_retorno'] .':00';
            $data_retorno = str_replace('/', '-', $_POST['data_retorno']);
            $data_retorno = date('Y-m-d', strtotime($data_retorno));           
            $data_retorno = $data_retorno . ' ' . $hora_retorno;      
                          
            $distancia = $this->Distancia->Get_distancia($_POST['cidade_destino'], $_POST['estado_destino']);
            $distancia = $distancia[0]['distancia'];                 

            if($this->input->post('modelo') == "" &&  $this->input->post('placa') == "") {
                $veiculo = strtoupper($servidor[0]['modelo']) . ' ' . $servidor[0]['placa'];
                if($servidor[0]['modelo'] != '' && $servidor[0]['placa'] != '') {
                    $veiculo = strtoupper($servidor[0]['modelo']) . ' ' . $servidor[0]['placa'];
                }else{
                    $veiculo = 'Não Informado';
                }
            }else{
                $veiculo = strtoupper($_POST['modelo']) . ' ' . $_POST['placa']; 
            }
    
            $matricula = str_replace(['.', '/', ','], '', $servidor[0]['matricula']);
            $dados_insert = array(
                'servidor'=> ucwords($servidor[0]['nome']),
                'id_secretaria' => $servidor[0]['id_secretaria'],
                'estado_destino'=>$_POST['estado_destino'],
                'cidade_destino'=>$_POST['cidade_destino'],
                'portaria_matricula' => $matricula ,
                'banco' => ucfirst($servidor[0]['banco']),
                'agencia' => $servidor[0]['agencia'],
                'veiculo' => $veiculo,
                'cpf' => $servidor[0]['cpf'],
                'cargo' => ucfirst($servidor[0]['cargo']),
                'motivo' => ucfirst($_POST['motivo']),
                'conta' => $servidor[0]['cc'],
                'data_saida'=>  $data_saida,
                'data_retorno'=> $data_retorno,
                'data_cadastro'=>date('Y-m-d'),
                'exercicio' => date('Y'),
                'telefone' =>$servidor[0]['telefone'],
                'created_by' => $_SESSION['usuario'], 
                'distancia_destino'=> $distancia,
                'valor_ufm' => $_POST['valor_ufm'],
            );
           
            // calculo de diferenca de dias entre saida e retorno
            $saida = date('Y-m-d H:i:s', strtotime($data_saida));
            $retorno = date('Y-m-d H:i:s', strtotime($data_retorno));
            $t_s = strtotime($saida);
            $t_r = strtotime($retorno);
            $diferenca = $t_r - $t_s;
            $data = (float)($diferenca / (60 * 60 * 24) );

            // conversao de tempo exato em dias, horas, minutos;
            $data_a = new DateTime($data_saida);
            $data_b = new DateTime($data_retorno);
            $intervalo = date_diff($data_a,$data_b);


            if($intervalo->format('%D') > 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s) + %H Hora(s)');
            }elseif($intervalo->format('%D') > 1 && $intervalo->format('%H') == 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s)');
            }elseif($intervalo->format('%D') == 0 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%H Hora(s)');
            }elseif($intervalo->format('%D') > 0 && $intervalo->format('%D') <= 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária + %H Hora(s)');            
            }         
            
            $estado = $_POST['estado_destino'];          
            // Condiçoes definidas na lei de diarias
            if($estado == "EX") {
                $horas_consedidas = (400 * $data) / 1; 
                $dados_insert['ufm'] = 'U$';
                $dados_insert['valor_total'] = number_format($horas_consedidas, 2, '.', '');
            }else{
            
                $ufm = 0;
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA INFERIOR A 100 KM
                if($distancia < 100) {
                    if($distancia < 100 && $data < 0.5) {
                        $ufm = 6;
                        $horas_consedidas  = 6;
                    }elseif($distancia < 100){
                        $ufm = 6;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }
               
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA SUPERIOR A 100 KM
                if($distancia > 100) {
                    if($distancia > 100 && $data < 0.5) {
                        $ufm = 9;
                        $horas_consedidas  = 9;
                    }elseif($distancia > 100){
                        $ufm = 9;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PERIODO ACIMA DE 24 HORAS
                if($data >= 1 ) {
                    $ufm = 17;
                    $horas_consedidas = ($ufm * $data) / 1;
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PARA DF
                if($data >= 1 && $estado == "DF") {
                    $ufm = 25;
                    $horas_consedidas = ($ufm * $data) / 1;
                    //   $horas_conc = ($data * $valor)
                }
                    
                $dados_insert['ufm'] = $horas_consedidas;
                $valor = $horas_consedidas * $_POST['valor_ufm'];

                $dados_insert['valor_total'] = number_format($valor, 2, '.', '');
            }

            $cad = $this->db->insert('ufms', $dados_insert);
            if($cad) {
                 redirect('Ufms/ufms/1');
            }            
             
            $dados['msg'] = "Cadastro efetuado com sucesso!";            
             
        }
    }   

    public function edit_ufm($id_ufm) {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();
        $dados['id_ufm'] = $id_ufm;

        // mensagem de erro caso haja algum
        $dados['msg'] = '';

        $dados['estado'] = $this->Estados->GetEstados();
        $dados['veiculo'] = $this->Veiculo->select_veiculos();
        $dados['secretaria'] = $this->Secretaria->GetSecretaria();
        $dados['dados_ufm'] = $this->Ufm->dados_ufm($id_ufm);

        if(isset($_POST['servidor'])) {
            if(isset($_POST['data_saida']) && isset($_POST['hora_saida'])) {
                $hora_saida = $_POST['hora_saida'] .':00';
                $data_saida = str_replace('/', '-', $_POST['data_saida']);
                $data_saida = date('Y-m-d', strtotime($data_saida));
                $data_saida = $data_saida. ' ' . $hora_saida;
            }else{
                $hora_saida = $dados['dados_ufm'][0]['data_saida'];
            }

            if(isset($_POST['data_retorno']) && isset($_POST['hora_retorno'])) {
                $hora_retorno = $_POST['hora_retorno'] .':00';
                $data_retorno = str_replace('/', '-', $_POST['data_retorno']);
                $data_retorno = date('Y-m-d', strtotime($data_retorno));           
                $data_retorno = $data_retorno . ' ' . $hora_retorno;   
            }else{
                $data_retorno = $dados['dados_ufm'][0]['data_retorno'];
            }
                 
            $cidade_destino = isset($_POST['cidade_destino']) ? $_POST['cidade_destino'] : $dados['dados_ufm'][0]['cidade_destino'];
            $estado_destino = isset($_POST['estado_destino']) ? $_POST['estado_destino'] : $dados['dados_ufm'][0]['estado_destino'];
            $distancia = $this->Distancia->Get_distancia($cidade_destino, $estado_destino);
            $distancia = $distancia[0]['distancia'] * 2;

            if($this->input->post('modelo') == "" &&  $this->input->post('placa') == "") {
                $veiculo = 'Particular / Outros';
                if(isset($dados['dados_ufm'][0]['modelo']) != '' && isset($dados['dados_ufm'][0]['placa']) != '') {
                    $veiculo = strtoupper($dados['dados_ufm'][0]['modelo']) . ' ' . $dados['dados_ufm'][0]['placa'];
                }else{
                    $veiculo = 'Não Informado';
                }
            }else{
                $veiculo = strtoupper($_POST['modelo']) . ' ' . $_POST['placa']; 
            }
    
            $dados_insert = array(
                'servidor'=> isset($_POST['servidor'])? strtoupper($_POST['servidor']) : strtoupper($dados['dados_ufm'][0]['servidor']),
                'estado_destino'=> isset($_POST['estado_destino']) ? $_POST['estado_destino'] : $dados['dados_ufm'][0]['estado_destino'],
                'cidade_destino'=> isset($_POST['cidade_destino'])? $_POST['cidade_destino'] : $dados['dados_ufm'][0]['cidade_destino'],
                'portaria_matricula' => isset($_POST['servidor'])? $_POST['servidor'] : $dados['dados_ufm'][0]['matricula'],
                'banco' => isset($_POST['banco'])? ucfirst($_POST['banco']) : ucfirst($dados['dados_ufm'][0]['banco']),
                'agencia' => isset($_POST['agencia'])? ucfirst($_POST['agencia']) : $dados['dados_ufm'][0]['agencia'],
                'veiculo' => $veiculo,
                'cpf' => isset($_POST['cpf'])? $_POST['cpf'] : $dados['dados_ufm'][0]['cpf'],
                'cargo' => isset($_POST['cargo']) ? ucfirst($_POST['cargo']) : ucfirst($dados['dados_ufm'][0]['cargo']),
                'motivo' => isset($_POST['motivo']) ? ucfirst($_POST['motivo']) : ucfirst($dados['dados_ufm'][0]['motivo']),
                'conta' => isset($_POST['conta'])? $_POST['conta'] : $dados['dados_ufm'][0]['cc'],
                'data_saida'=> $data_saida,
                'data_retorno'=> $data_retorno,
                'distancia_destino'=> $distancia,
                'valor_ufm' => isset($_POST['valor_ufm']) ? $_POST['valor_ufm'] : $dados['dados_ufm'][0]['valor_ufm'],
                'telefone' => isset($_POST['telefone']) ? $_POST['telefone'] : $dados['dados_ufm'][0]['telefone'],
                'modified_by' => $_SESSION['usuario'],
                'modified' => date('Y-m-d H:i:s'),
                'visualizado' => 0
            );

            // calculo de diferenca de dias entre saida e retorno
            $saida = date('Y-m-d H:i:s', strtotime($data_saida));
            $retorno = date('Y-m-d H:i:s', strtotime($data_retorno));
            $t_s = strtotime($saida);
            $t_r = strtotime($retorno);
            $diferenca = $t_r - $t_s;
            $data = (float)($diferenca / (60 * 60 * 24) );

            // conversao de tempo exato em dias, horas, minutos;
            $data_a = new DateTime($data_saida);
            $data_b = new DateTime($data_retorno);
            $intervalo = date_diff($data_a,$data_b);

            if($intervalo->format('%D') > 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s) + %H Hora(s)');
            }elseif($intervalo->format('%D') > 1 && $intervalo->format('%H') == 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária(s)');
            }elseif($intervalo->format('%D') == 0 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%H Hora(s)');
            }elseif($intervalo->format('%D') > 0 && $intervalo->format('%D') <= 1 && $intervalo->format('%H') > 0) {
                $dados_insert['tempo_total'] = $intervalo->format('%D Diária + %H Hora(s)');            
            }     

            $estado = $_POST['estado_destino'];
         
            // Condiçoes definidas na lei de diarias
            if($estado == "EX") {
                $horas_consedidas = (400 * $data) / 1; 
                $dados_insert['ufm'] = 'U$';
                $dados_insert['valor_total'] = number_format($horas_consedidas, 2, '.', '');
            }else{
             
                $ufm = 0;
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA INFERIOR A 100 KM
                if($distancia < 100) {
                    if($distancia < 100 && $data < 0.5) {
                        $ufm = 6;
                        $horas_consedidas  = 6;
                    }elseif($distancia < 100){
                        $ufm = 6;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }
                
                // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA SUPERIOR A 100 KM
                if($distancia > 100) {
                    if($distancia > 100 && $data < 0.5) {
                        $ufm = 9;
                        $horas_consedidas  = 9;
                    }elseif($distancia > 100){
                        $ufm = 9;
                        $horas_consedidas = ($ufm * $data) / 0.5;  
                    }
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PERIODO ACIMA DE 24 HORAS
                if($data >= 1 ) {
                    $ufm = 17;
                    $horas_consedidas = ($ufm * $data) / 1;
                }

                // ALGORITMO DE CALCULO FRACIONADO DE UFM PARA DF
                if($data >= 1 && $estado == "DF") {
                    $ufm = 25;
                    $horas_consedidas = ($ufm * $data) / 1;
                }
                
                $dados_insert['ufm'] = $horas_consedidas;
                $valor = $horas_consedidas * $_POST['valor_ufm'];

                $dados_insert['valor_total'] = number_format($valor, 2, '.', '');
            }
          
            $cad = $this->Ufm->edit($id_ufm, $dados_insert);
            redirect('Ufms/ufms/1');
            if($cad) {
                redirect('Ufms/ufms/1');
            }            
            $dados['msg'] = "Cadastro alterado com sucesso!";            
        };

        $dados['viewName'] = 'Ufms/edit_ufm';
        $this->load->view('index', $dados);
    }

    public function view_ufm($id_diaria) {        
        $this->Tabelas->getSession();
        $dados['id_diaria'] = $id_diaria;

        $dados['dados_diaria'] = $this->Modal_ufm->dados_ufm($id_diaria);

        $dados['data_saida'] = str_replace('/', '-', $dados['dados_diaria'][0]['data_saida']);
        $dados['data_saida'] = date('d/m/Y  -  H:i', strtotime($dados['data_saida']));

        $dados['data_retorno'] = str_replace('/', '-', $dados['dados_diaria'][0]['data_retorno']);
        $dados['data_retorno'] = date('d/m/Y  -  H:i', strtotime($dados['data_retorno']));

        $confirmacao = $this->Ufm->get_confirmacao($id_diaria);
        $dados['confirmacao'] = $confirmacao[0]['confirmacao'];

        $user_confirm_diaria = $this->Ufm->user_confirm_diaria($id_diaria);
        $dados['user_confirm_diaria'] = $user_confirm_diaria[0]['user_confirm_diaria'];

        $dados['viewName'] = 'Ufms/view_ufm';
        $this->load->view('index', $dados); 
    }

    public function confirmar_diaria() {
        $id_diaria = $_POST['id'];
        $confirmacao = $this->Ufm->confirmar_diaria($id_diaria);
        echo json_encode(['retorno' => $confirmacao]);
        
    }

    public function formataMes($mes) {
        switch($mes) {
            case '01':
                $mes = 'Janeiro';
                break;
            case '02':
                $mes = 'Fevereiro';
                break;
            case '03':
                $mes = 'Março';
                break;
            case '04':
                $mes = 'Abril';
                break;
            case '05':
                $mes = 'Maio';
                break;
            case '06':
                $mes = 'Jonho';
                break;
            case '07':
                $mes = 'Julho';
                break;
            case '08':
                $mes = 'Agosto';
                break;
            case '09':
                $mes = 'Setembro';
                break;
            case '10':
                $mes = 'Outubro';
                break;
            case '11':
                $mes = 'Novembro';
                break;
            case '12':
                $mes = 'Dezembro';
                break;
        }
        return $mes;
    }
    public function dados_model_ufm() {
        
        // id do documento visualizado que vem através do AJAX
        $id = $this->input->post('id_modal');

        // select dos dados referentes ao id selecionado
        $data = $this->Modal_ufm->get_datos_ufm_modal($id);

        // retorno dos dados para o ajax
        echo json_encode($data);
    }

    public function Pdfufm($id_diaria) {
        $this->Tabelas->update('ufms', 'visualizado', '1', 'id_ufm', $id_diaria);
        // $this->load->library('Sendmail');
        $this->load->library('tcpdf/tcpdf');      
       
        $diarias = $this->Modal_ufm->dados_ufm($id_diaria);
      
        $dados['id_ufm'] = $diarias[0]['id_ufm'];
        $dados['servidor'] = $diarias[0]['servidor'];
        $dados['portaria_matricula'] = $diarias[0]['portaria_matricula'];
        $dados['estado_destino'] = $diarias[0]['estado_destino'];
        $dados['cidade_destino'] = $diarias[0]['cidade_destino'];
        $dados['distancia_destino'] = $diarias[0]['distancia_destino'];
        $dados['distancia_destino'] = $diarias[0]['distancia_destino'];
        $dados['distancia_destino'] = $diarias[0]['distancia_destino'];
        $dados['distancia_destino'] = $diarias[0]['distancia_destino'];
        $dados['tempo_total'] = $diarias[0]['tempo_total'];
        $dados['banco'] = $diarias[0]['banco'];
        $dados['agencia'] = $diarias[0]['agencia'];
        $dados['conta'] = $diarias[0]['conta'];
        $dados['veiculo'] = $diarias[0]['veiculo'];
        $dados['cpf'] = $diarias[0]['cpf'];
        $dados['cargo'] = $diarias[0]['cargo'];
        $dados['motivo'] = $diarias[0]['motivo'];
        $dados['telefone'] = $diarias[0]['telefone'];
        $dados['id_secretaria'] = $diarias[0]['id_secretaria'];
        $dados['data_cadastro'] = $diarias[0]['data_cadastro'];
        $dados['fundo'] = $diarias[0]['fundo'];
        $dados['orgao'] = $diarias[0]['orgao'];
        $dados['ufm'] = $diarias[0]['ufm'];
        $dados['atividade'] = $diarias[0]['atividade'];
        $dados['elemento_despesa'] = $diarias[0]['elemento_despesa'];
        $dados['codigo_reduzido'] = $diarias[0]['codigo_reduzido'];
        $dados['secretaria_nome'] = $diarias[0]['secretaria_nome'];
        $dados['email_secretaria'] = $diarias[0]['email_secretaria'];
        $dados['valor_total'] = $diarias[0]['valor_total'];
        $dados['valor_ufm'] = $diarias[0]['valor_ufm'];
        $dados['data_cadastro'] = $diarias[0]['data_cadastro'];

        $dados['data_saida'] = str_replace('/', '-', $diarias[0]['data_saida']);
        $dados['data_saida'] = date('d/m/Y  -  H:i', strtotime($dados['data_saida']));

        $dados['data_retorno'] = str_replace('/', '-', $diarias[0]['data_retorno']);
        $dados['data_retorno'] = date('d/m/Y  -  H:i', strtotime($dados['data_retorno']));

        $data =  explode('-', $diarias[0]['data_cadastro']);
        $dados['dia'] = $data[2];
        $dados['mes'] = $this->formataMes($data[1]);
        $dados['ano'] = $data[0];        

        $this->load->view('Ufms/Pdfufm', $dados);    
    }

    public function Pdfrelatorioufm($id_diaria) {
        $this->Tabelas->update('ufms', 'visualizado', '1', 'id_ufm', $id_diaria);
        // $this->load->library('Sendmail');
        $this->load->library('tcpdf/tcpdf');      
       
        // $dados['tcpfd'] =  $this->load->library('TCPDF/tcpdf/tcpdf.php');
        $diarias = $this->Modal_ufm->dados_ufm($id_diaria);
      
        $dados['id_ufm'] = $diarias[0]['id_ufm'];
        $dados['servidor'] = $diarias[0]['servidor'];
        $dados['portaria_matricula'] = $diarias[0]['portaria_matricula'];
        $dados['estado_destino'] = $diarias[0]['estado_destino'];
        $dados['cidade_destino'] = $diarias[0]['cidade_destino'];
        $dados['tempo_total'] = $diarias[0]['tempo_total'];
        $dados['veiculo'] = $diarias[0]['veiculo'];
        $dados['cpf'] = $diarias[0]['cpf'];
        $dados['cargo'] = $diarias[0]['cargo'];
        $dados['motivo'] = $diarias[0]['motivo'];
        $dados['ufm'] = $diarias[0]['ufm'];
        $dados['data_cadastro'] = $diarias[0]['data_cadastro'];
        $dados['secretaria_nome'] = $diarias[0]['secretaria_nome'];
        $dados['valor_total'] = $diarias[0]['valor_total'];
        $dados['valor_ufm'] = $diarias[0]['valor_ufm'];
        $dados['data_cadastro'] = $diarias[0]['data_cadastro'];

        $dados['data_saida'] = str_replace('/', '-', $diarias[0]['data_saida']);
        $dados['data_saida'] = date('d/m/Y  -  H:i', strtotime($dados['data_saida']));

        $dados['data_retorno'] = str_replace('/', '-', $diarias[0]['data_retorno']);
        $dados['data_retorno'] = date('d/m/Y  -  H:i', strtotime($dados['data_retorno']));

        $data =  explode('-', $diarias[0]['data_cadastro']);
        $dados['dia'] = $data[2];
        $dados['mes'] = $this->formataMes($data[1]);
        $dados['ano'] = $data[0];        

        $this->load->view('Ufms/Pdfrelatorioufm', $dados);    
    }
}