<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuprimentoFundos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // carreganho o model Tabelas_model e setando um apelido de Tabelas
        $this->load->model('SuprementoFundos_model', 'Supri');
        $this->load->model('Tabelas_model', 'Tabelas');
        $this->load->model('Secretaria_model', 'Secretaria');
        $this->load->model('ModalUfm_model', 'Modal_ufm');
        $this->load->model('Project_model', 'PjModel');
        $this->load->helper('url');        
    }

    public function pagination() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        if(!empty($this->uri->segment(4))) {
            $total_registros = $this->Supri->count_all('id_fundo', $this->uri->segment(4));
        }else{
            $total_registros = $this->Supri->count_all();
        }

        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $total_registros;
        $config["per_page"] = 5;
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

        
        if(!empty($this->uri->segment(4))) {
            $output = array(
                'response' => '$this->uri->segment(4): '.$this->uri->segment(4),
                'pagination_link'  => $this->pagination->create_links(),
                'country_table'   => $this->Supri->fetch_details($config["per_page"], $start, 'id_fundo', $this->uri->segment(4))
            );
        }else{
            $output = array(
                'response' => '$this->uri->segment(4): '.$this->uri->segment(4),
                'pagination_link'  => $this->pagination->create_links(),
                'country_table'   => $this->Supri->fetch_details($config["per_page"], $start)
            );
        }
        echo json_encode($output);
    }

    public function adiantamento() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        $dados['secretaria'] = $this->Secretaria->GetSecretaria();
        // pegar o numero da pagina na url
        // $uri = explode('/', isset($_SERVER['REQUEST_URI']) ? preg_replace('/^\//', '', $_SERVER['REQUEST_URI'], 1) : '');
        
        // if(!isset($uri[2])) {
        //     $uri[2] = '1';
        // }

        // $pagina = $uri[2];
        // $dados['pagina'] = $pagina;

        // // --------------------- PAGINAÇÂO --------------------
        // if(isset($uri[2])) {
        //     $pg = $uri[2];
        // }else{
        //     $pg = 0;
        // }

        // $pagina= ($pg - 1) * 5;
        // if( $pagina < 0) {
        //     $pagina = 1;
        // }

        //  // carregando todos os registros de diarias para a paginação
        // $dados['pHome']             = $pagina;
        // $dados['total_registros']   = 5;

        // if($_SESSION["nivel"] == 5) {
        //     if(isset($_POST['id_select_secretaria'])) {
        //         $pagina = 0;
        //         $dados['supr_fundos']  = $this->Tabelas->select_cadastros_secretaria('supr_fundos', 'data_cadastro', $_POST['id_select_secretaria'], 'limit ' .$pagina . ', 10' );
        //         $dados['count']    = count($this->Tabelas->select_cadastros_secretaria('supr_fundos', 'data_cadastro', $_POST['id_select_secretaria']));
        //         $dados['paginas']  = ceil($dados['count'] / 5);
        //     }else{
        //         $dados['supr_fundos']  = $this->Tabelas->Select('supr_fundos' , 'data_cadastro', 'limit ' .$pagina . ', 10' );      
        //         $dados['count']    = count($this->Tabelas->Select('supr_fundos', 'data_cadastro'));
        //         $dados['paginas']  = ceil($dados['count'] / 5);      
        //     }
        // }else{
        //     $dados['supr_fundos']      = $this->Tabelas->select_cadastros_secretaria('supr_fundos', 'data_cadastro', $_SESSION['secretaria'], 'limit ' .$pagina . ', 10' );
        //     $dados['count']        = count($this->Tabelas->select_cadastros_secretaria('supr_fundos', 'data_cadastro', $_SESSION['secretaria']));
        //     $dados['paginas']      = ceil($dados['count'] / 5);
        // }
        
        $dados['viewName'] = 'SuprimentoFundos/adiantamento';
        $this->load->view('index', $dados);
    }

    public function cadAdiantamento() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        // mensagem de erro caso haja algum
        $dados['msg'] = '';

        # PEGANDO OS DADOS DA SECRETARIA LOGADA
        $dados['secretaria'] = $this->Secretaria->GetSecretaria();

        // Pega os dados dos servidores cadastrados na secretaria     
        $id_secretaria = ($_SESSION['nivel'] != 5) ? $_SESSION['secretaria'] : (isset($_POST['id_select_secretaria']) ? $_POST['id_select_secretaria']: '0');
        $dados['servidores_registrados'] = $this->PjModel->options_servidores($id_secretaria);

        if($id_secretaria != 0){
            $dados['secretaria_selecionada'] = $this->PjModel->getDadosSecretaria($id_secretaria);
            $fundo              = $dados['secretaria_selecionada'][0]['fundo'];
            $id_fundo           = $id_secretaria;
            $orgao              = $dados['secretaria_selecionada'][0]['orgao'] ;
            $atividade          = $dados['secretaria_selecionada'][0]['atividade'] ;
            $elemento_despesa   = $dados['secretaria_selecionada'][0]['elemento_despesa'] ;
            $valor_solicitacao  = !empty($_POST['valor']) ? $_POST['valor'] : '' ;
            $data_cadastro      = date('Y-m-d');
            $created_by         = $_SESSION['usuario'];
            $motivo             = !empty($_POST['motivo']) ? $_POST['motivo'] : '' ;
        }

        if(!empty($_POST['id_servidor']) && $_POST['id_servidor'] != 'Carregando...') {
            $servidor_dados = $this->PjModel->getDadosServidor($_POST['id_servidor']);
            $servidor  = $servidor_dados[0]['nome'];
            $matricula = $servidor_dados[0]['matricula'];
            $cpf       = $servidor_dados[0]['cpf'];
            $banco     = $servidor_dados[0]['banco'];
            $agencia   = $servidor_dados[0]['agencia'];
            $conta     = $servidor_dados[0]['cc'];
            $telefone  = $servidor_dados[0]['telefone'];
        }else{            
            $servidor  = !empty($_POST['servidor']) ? $_POST['servidor'] : '' ;
            $matricula = !empty($_POST['matricula']) ? $_POST['matricula'] : '' ;
            $cpf       = !empty($_POST['cpf']) ? $_POST['cpf'] : '' ;
            $banco     = !empty($_POST['banco']) ? $_POST['banco'] : '' ;
            $agencia   = !empty($_POST['agencia']) ? $_POST['agencia'] : '' ;
            $conta     = !empty($_POST['conta']) ? $_POST['conta'] : '' ;
            $telefone  = !empty($_POST['telefone']) ? $_POST['telefone'] : '' ;
        }

        if($servidor != '') {
            $retorno = $this->Supri->insertProposta($fundo, $id_fundo, $orgao, $atividade, $elemento_despesa, $valor_solicitacao, $servidor, $matricula, $cpf, $banco, $agencia, $conta, $telefone, $motivo, $data_cadastro, $created_by); 
            if($retorno['response'] == 'true') {
                redirect('SuprimentoFundos/adiantamento/1');
            }
        }       

        $dados['viewName'] = 'SuprimentoFundos/cad_supr';
        $this->load->view('index', $dados);  
    }

    public function edit_adiantamento($id) {
        $this->Tabelas->getSession();
     
        $dados['dados_adiantamento'] = $this->Supri->dados_adiantamento($id);
        $dados['msg'] = '';
        $dados['id'] = $id;
        
        if(isset($_POST['servidor'])) {
                        
            $dados_insert = array(
                'servidor'  => !empty($_POST['servidor']) ? $_POST['servidor'] : '' ,
                'matricula' => !empty($_POST['matricula']) ? $_POST['matricula'] : '' ,
                'cpf'       => !empty($_POST['cpf']) ? $_POST['cpf'] : '' ,
                'banco'     => !empty($_POST['banco']) ? $_POST['banco'] : '' ,
                'agencia'   => !empty($_POST['agencia']) ? $_POST['agencia'] : '' ,
                'conta'     => !empty($_POST['conta']) ? $_POST['conta'] : '' ,
                'telefone'  => !empty($_POST['telefone']) ? $_POST['telefone'] : '',
                'valor_solicitacao' =>  !empty($_POST['valor']) ? $_POST['valor'] : '',
                'motivo' => !empty($_POST['motivo']) ? $_POST['motivo'] : ''
            );

            $confirmacao = $this->Supri->get_confirmacao($id);
            $dados['postinmemoria'] = $dados_insert;

            if($confirmacao[0]['confirmacao'] === '0') {
                $teste = $this->Supri->edit($id, $dados_insert);
                redirect('SuprimentoFundos/adiantamento/1');  
            }else{
                $dados['msg'] = 'Este adiantamento já foi analisado, Entre em contato com a Controladoria-Geral';
            }
             
        }
        $dados['viewName'] = 'SuprimentoFundos/edit_adiantamento';
        $this->load->view('index', $dados);
    }

    public function view_adiantamento($id) {        
        $this->Tabelas->getSession();
        $dados['id'] = $id;

        $this->Tabelas->update('supr_fundos', 'visualizado', 1, 'id', $id);

        $dados['dados_adiantamento'] =  $this->Tabelas->dados_adiantamento($id);

        $balancete_gerado = $this->Supri->getBalanceteGerado($id);
        $dados['balancete_gerado'] = $balancete_gerado[0]['balancete_gerado'];

        $confirmacao = $this->Supri->get_confirmacao($id);
        $dados['confirmacao'] = $confirmacao[0]['confirmacao'];

        $user_confirm_diaria = $this->Supri->user_confirm_adiantamento($id);
        $dados['user_confirm_diaria'] = $user_confirm_diaria[0]['user_confirm_diaria'];

        $dados['viewName'] = 'SuprimentoFundos/view_adiantamento';
        $this->load->view('index', $dados); 
    }

    public function gerar_balancete($id = null) {    
        $this->Tabelas->getSession();
        $dados['msg'] = '';
        $dados['id'] = $id;
        $cont = 1;
        $count_post = 0;
        $data_reposito = !empty($_POST['datadeposito_1'])? $_POST['datadeposito_1'] : '';
      
        $dados['dados_adiantamento'] = $this->Tabelas->dados_adiantamento($id);
        $valor_solicitacao = $dados['dados_adiantamento'][0]['valor_solicitacao'];
      
        $response = false;

        $data_reposito = !empty($_POST['datadeposito_1']) ? $_POST['datadeposito_1'] : '' ;

        if(!empty($_POST)) {
            foreach($_POST['recibo'] as $key => $info) {
                $recibo = $info;
                $data = $_POST['data'][$key];
                $razaosocial = $_POST['razaosocial'][$key];
                $pagamento = str_replace(',', '.', $_POST['pagamento'][$key]);
      
                $response = $this->Supri->insertHistorico($recibo, $data, $razaosocial, $pagamento, $valor_solicitacao , $data_reposito, $id, date('Y-m-d'));
            }
           
            if($response) {
                $this->Tabelas->update('supr_fundos', 'balancete_gerado', 1, 'id', $id);
                redirect('SuprimentoFundos/view_adiantamento/'.$id);  
            }
        }
        
        $dados['viewName'] = 'SuprimentoFundos/gerar_balancete';
        $this->load->view('index', $dados); 
    }

    public function confirmar_adiantamento() {
        $id = $_POST['id'];
        $confirmacao = $this->Supri->confirmar_adiantamento($id);
        echo json_encode(['retorno' => $confirmacao]);
    }

    public function formataMes($mes) {
      
        // $mes = date('m', strtotime($mes));

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

    public function Pdfadiantamento($id) {
        $this->Tabelas->update('supr_fundos', 'visualizado', '1', 'id', $id);
        // $this->load->library('Sendmail');
        $this->load->library('tcpdf/Tcpdf');       
       
        $dados_adiantamento =  $this->Tabelas->dados_adiantamento($id);
       
        $dados['id'] = $dados_adiantamento[0]['id'];
        $dados['servidor'] = $dados_adiantamento[0]['responsavel'];
        $dados['matricula'] = $dados_adiantamento[0]['matricula'];
        $dados['banco'] = $dados_adiantamento[0]['banco'];
        $dados['agencia'] = $dados_adiantamento[0]['agencia'];
        $dados['conta'] = $dados_adiantamento[0]['conta'];
        $dados['cpf'] = $dados_adiantamento[0]['cpf'];
        $dados['motivo'] = $dados_adiantamento[0]['motivo'];
        $dados['telefone'] = $dados_adiantamento[0]['telefone'];
        $dados['fundo'] = $dados_adiantamento[0]['fundo'];
        $dados['orgao'] = $dados_adiantamento[0]['orgao'];
        $dados['atividade'] = $dados_adiantamento[0]['atividade'];
        $dados['elemento_despesa'] = $dados_adiantamento[0]['elemento_despesa'];
        $dados['valor_total'] = number_format($dados_adiantamento[0]['valor_solicitacao'], '2', ',', '');
        $dados['data_cadastro'] = $dados_adiantamento[0]['data_cadastro'];
       
        $data =  explode('-', $dados_adiantamento[0]['data_cadastro']);
        $dados['dia'] = $data[2];
        $dados['mes'] = $this->formataMes($data[1]);
        $dados['ano'] = $data[0];        

        $this->load->view('SuprimentoFundos/Pdfadiantamento', $dados);    
    }

    public function Pdfbalancete($id) {
        // $this->load->library('Sendmail');
        $this->load->library('tcpdf/Tcpdf');       
            
        $dados_adiantamento =  $this->Supri->dados_adiantamento($id);
        $dados_balancete =  $this->Supri->dados_balancete($id);
       
        $dados['id'] = $dados_adiantamento[0]['id'];
        $dados['servidor'] = $dados_adiantamento[0]['responsavel'];
        $dados['cpf'] = $dados_adiantamento[0]['cpf'];
        $dados['endereco'] = 'RUA GETÚLIO VARGAS  77 CENTRO   CAMBORIÚ/SC';
        $dados['cep'] = '88340-000'; 
        $dados['valor_total'] = number_format($dados_adiantamento[0]['valor_solicitacao'], '2', ',', '');
        
        $dados['motivo'] = $dados_adiantamento[0]['motivo'];

        $dados['dados_balancete'] = $dados_balancete;

        $total_gasto = 0;
        foreach( $dados['dados_balancete'] as $info ){
            $dados['data_deposito'] = $info['data_deposito'];
            $total_gasto += $info['pagamento']; 
        }

        $dados['total_gasto'] =  number_format($total_gasto, '2', ',', '');
        $devolucao = number_format(($dados_adiantamento[0]['valor_solicitacao'] - $total_gasto), '2', ',', '');
        if($devolucao > 0) {
            $dados['devolucao'] = $devolucao;
        }else{
            $dados['devolucao'] = '0,00';
        }
            
        $data =  explode('-', $dados_balancete[0]['data_cadastro']);
        $dados['dia'] = $data[2];
        $dados['mes'] = $this->formataMes($data[1]);
        $dados['mes_numero'] = $data[1];
        $dados['ano'] = $data[0];        

        $this->load->view('SuprimentoFundos/Pdfbalancete', $dados);   
    }

}