<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


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
        $this->load->model('SuprementoFundos_model', 'Supri');

        $this->load->helper('url'); // 
    }

    public function entrar() {
        $redirect = null;
        $tentativas_login = 0;
        $MsgAcessoBloqueado = '';

        if($_POST["tentativasLogin"] >= 5){
            $_SESSION['horarioBloqueio'] = date('H:i', strtotime('+1 minutes'));
        }

        // carregando os dados do formulario de login
        if(isset($_POST["token"]) && $_POST["token"] == $_SESSION['token']) {
            
            $user = !empty($_POST["email"]) ? addslashes($_POST["email"]) : '';
            $password = !empty($_POST["password"]) ? addslashes(md5($_POST["password"])) : '';
            
            if($user != '' &&  $password != '') {

                // pegando os dados do usuario no banco de dados
                $usuarios_info = $this->PjModel->login();
                
                if(count($usuarios_info[0]) > 1) {
                    
                    // com os dados corretos carregados uma seria de $_Session sao configurados
                    foreach($usuarios_info as $info) {
                        $userLogin              = $info["email"];
                        $userPassword           = $info["password"];
                        $_SESSION["usuario"]    = $info["user"];
                        $_SESSION["nivel"]      = $info["nivel"];
                        $_SESSION['id_user']    = $info['id_usuario'];
                        $_SESSION['secretaria'] = $info['id_secretaria'];
                        
                        
                        if($user == $userLogin && $password == $userPassword) {
                            $_SESSION["logado"] = "true";
                            
                            $_SESSION['donoDaSessao'] = md5('seq'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                            
                            $redirect = 'home/lei';
                        }else{
                            $_SESSION["logado"] = "false";
                        }
                    };
                }
            }

            echo json_encode(['tentativas_login' => $tentativas_login, 'AcessoBloqueado' =>  $MsgAcessoBloqueado, 'tentativas' => $_POST["tentativasLogin"], 'redirect' => $redirect]);
        }
    }

	public function index() {
        $_SESSION['token'] = md5(date('Y-m-d H:i:S'));
        
        $dados['tempoBloqueado']  = '';
        $agora = date('H:i');
        if(!empty($_SESSION['horarioBloqueio']) && $_SESSION['horarioBloqueio'] > $agora) {
            $dados['tempoBloqueado'] = true;
        }else{
            $dados['tempoBloqueado'] = false;
        }

        $this->load->view('login', $dados);
    }

    public function municipio() {
        $estado = $this->input->post('estado');sleep(1);
        echo $this->Cidades->select_cidades($estado);        
    }

    public function lei() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();
        
        $dados['viewName'] = 'lei';
        $this->load->view('index', $dados);
    }
    
    public function leiAdiantamento() {
        $this->Tabelas->getSession();
        
        $dados['viewName'] = 'leiAdiantamento';
        $this->load->view('index', $dados);
    }

    public function sair() {
        unset($_SESSION);
        session_destroy();
        $_SESSION["logado"] = "false";
        redirect("/index.php");
    }

    public function profile() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();
        
		$email 		= $this->input->post('email');
		$user 		= $this->input->post('user');
		$password	= $this->input->post('password');	

		$id_user_delete = $this->input->post('delete_user');
        $id_servidor_delete = $this->input->post('delete_servidor');

		// teste de AJAX
		$dados_id = $this->input->post('id');
		
		if(isset($id_user_delete)) {
			$this->PjModel->deleta_conta($id_user_delete);
        }
        
        if(isset($id_servidor_delete)) {
			$this->PjModel->deleta_servidores($id_servidor_delete);
        }
        
        if(isset($_POST) && $_POST != "") {
			// Funcão que chama o insert para a criação da conta
			$success = $this->PjModel->edita_conta($_SESSION['id_user'], $user, $email, $password);
				// Mensagem que vem no metodo de cadastro, 
			$dados['Mensagem'] = $success;
		}

		if(isset($_POST['new_user'])) {			
			// $this->PjModel->getSession($_SESSION["logado"]);
			$email 		= $this->input->post('new_email');
			$user 		= $this->input->post('new_user');
			$password	= $this->input->post('new_password');
			$secretaria = $this->input->post('fundo');
			$data_cadastro = date('Y-m-d');

			$dados_insert = array(
				'user' => $user,
				'email' => $email,
				'password' => addslashes(md5($password)),
				'data_cadastro' => $data_cadastro,
				'id_secretaria' => $secretaria 
			);
			$cadastro = $this->PjModel->cadastro_insert('usuarios', $dados_insert);
			$dados['Mensagem'] = $cadastro;
		}
    
		// Pega os dados do Usuario logado
		$dados['dados_usuario_logado'] = $this->PjModel->getDadosUsuarios($_SESSION['id_user']);
	
        // Pega os dados dos servidores cadastrados na secretaria        
        $id_secretaria = ($_SESSION['nivel'] != 5) ? $_SESSION['secretaria'] : (isset($_POST['id_select_secretaria']) ? $_POST['id_select_secretaria']: '0');
        $dados['dados_servidores_geral'] = $this->PjModel->getTodosUsuariosSecretaria( $id_secretaria);
        $dados['count_servidores'] = count($dados['dados_servidores_geral']); 

        // Pega os dados de todos os uduarios
        $dados['dados_usuarios_geral'] = $this->PjModel->getTodosUsuarios();
        $dados['count_users'] = count($dados['dados_usuarios_geral']);
		                
        $dados['veiculo'] = $this->Veiculo->select_veiculos();
		$dados['secretaria'] = $this->Secretaria->GetSecretarianome();
		
		$dados['viewName'] = 'Usuarios/profile';
        $this->load->view('index', $dados);
    }
    
    public function editusuario($id_usuario) {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        $dados['postinmemoria'] = $this->PjModel->getDadosUsuarios($id_usuario);      

        $user       = (isset($_POST['user']) != "") ? $_POST['user'] :  $dados['postinmemoria'][0]['user'];
        $email 	    = (isset($_POST['email']) != "") ? $_POST['email'] :  $dados['postinmemoria'][0]['email'];
            
        // $dados['secretaria'] = $this->Secretaria->GetSecretaria();
        $dados['id_usuario'] = $id_usuario;

        if(isset($_POST['submit'])) {
            if($_POST['password'] == ""){
                $dados_insert = array(
                    'user' => $user,
                    'email' => $email,
                    'password' => $dados['postinmemoria'][0]['password']
                );
            }else{
                $dados_insert = array(
                    'user' => $user,
                    'email' => $email,
                    'password' => md5($_POST['password'])
                );
            }

            $edit = $this->PjModel->editar_usuario($dados_insert, $id_usuario);
            
            $_SESSION['usuario'] = $user;
            return $this->profile();            
        }        

		$dados['viewName'] = 'Usuarios/editusuario';
		$this->load->view('index', $dados);		
    }

    public function editarservidor($id_usuario) {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();
        
        $dados['postinmemoria'] = $this->PjModel->getDadosServidor($id_usuario); 

		// $this->PjModel->getSession($_SESSION["logado"]);
		$nome 		= $this->input->post('nome');
		$cargo 		= $this->input->post('cargo');
        $matricula	= $this->input->post('matricula');
        $cpf	    = $this->input->post('cpf');
        $banco	    = $this->input->post('banco');
        $agencia	= $this->input->post('matricula');
        $cc	        = $this->input->post('cc');
        $telefone	= $this->input->post('telefone');
        $email  	= $this->input->post('email');
        
        $id_usuario = $id_usuario;
        $dados['id_usuario'] = $id_usuario;
  

        // So faz a alteracao se os dados do post estiverem preencidos
        if(isset($_POST['nome'])) {

            if(isset($_POST['veiculo']) == ""){
                $modelo = isset($_POST['modelo'])? strtoupper($_POST['modelo']) : '';
                $placa = isset($_POST['placa'])? $_POST['placa'] : '';
                $veiculo = $modelo . ' ' . $placa;
            }else{
                $veiculo = isset($_POST['veiculo'])? strtoupper($_POST['veiculo']) : '';
            }

            $dados_insert= array(
                'nome' => strtoupper($nome),
                'cargo' => ucfirst($cargo),
                'matricula' => $matricula,
                'cpf' => $cpf,
                'banco' => strtoupper($banco),
                'agencia' => $agencia,
                'cc' => $cc,
                'telefone' => $telefone,
                'veiculos' => $veiculo,
                'modelo' => $modelo,
                'placa' => $placa,
                'email' => $email
            );
      
            $this->PjModel->editar_dados_servidor($dados_insert, $id_usuario);
            redirect('home/profile');
        }

        $dados['veiculo'] = $this->Veiculo->select_veiculos();		
      
		$dados['viewName'] = 'Usuarios/editarservidor';
		$this->load->view('index', $dados);		
    }

    // CADSTRO DE SERVIDORES
    public function CreateServidores() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        $nome = $this->input->post('nome');
        $cargo = $this->input->post('cargo');
        $matricula = $this->input->post('matricula');
        $cpf = $this->input->post('cpf');
        $banco = $this->input->post('banco');
        $agencia = $this->input->post('agencia');
        $cc = $this->input->post('cc');
        $telefone = $this->input->post('telefone');
        $email  = $this->input->post('email');
        $id_secretaria = ($_SESSION['nivel'] != 5) ? $_SESSION['secretaria']: $this->input->post('id_select_secretaria');

        if(isset($_POST['veiculo']) == ""){
            $modelo = isset($_POST['modelo'])? strtoupper($_POST['modelo']) : '';
            $placa = isset($_POST['placa'])? $_POST['placa'] : '';
            $veiculo = $modelo . ' ' . $placa;
        }else{
            $veiculo = isset($_POST['veiculo'])? strtoupper($_POST['veiculo']) : '';
        }

        // SE NAO EXISTIR CADSTRO DO VEICULO RELACIONADO A SECRETARIA INSERE
        $carro = $this->Veiculo->compara_veiculo($veiculo, $placa);
        if(empty($carro)) {
            $this->Veiculo->inderir_carro($modelo,  $placa, $id_secretaria);
        }

        $dados_insert = array(
            'nome' => strtoupper($nome),
            'cargo' => ucfirst($cargo),
            'matricula' => $matricula,
            'cpf' => $cpf,
            'banco' => strtoupper($banco),
            'agencia' => $agencia,
            'cc' => $cc,
            'telefone' => $telefone,
            'veiculos' => $veiculo,
            'modelo' => $modelo,
            'placa' => $placa,
            'email' => $email,
            'id_secretaria' => $id_secretaria
        );
       
        $this->PjModel->cadastro_servidor($dados_insert);
        
        redirect('home/profile');
    }
    public function CreateAccount() {
        // pegar a session de usuario logado
        $this->Tabelas->getSession();

		$email 		= $this->input->post('email');
		$user 		= $this->input->post('user');
        $password	= $this->input->post('password');
        $nome       = $this->input->post('nome');
        $id_secretaria = $this->input->post('id_secretaria');

		$success = '';
		if(isset($email)) {
			// Funcão que chama o insert para a criação da conta
			$success = $this->PjModel->cria_conta($user, $email, $password, $nome);		
		}
		// Mensagem que vem no metodo de cadastro, 
		$dados['Mensagem'] = $success;
	
		$this->load->view('create_account', $dados);	
	}
    
    public function removediarias() {
        $this->Tabelas->delete('diarias', 'id_diaria', $_POST['id']);
        echo json_encode('delete');
    }

    public function removeadiantamento() {
        $this->Tabelas->delete('supr_fundos', 'id', $_POST['id']);
        echo json_encode('delete');
    }

    public function removebalancete() {
        $dados_adiantamento =  $this->Supri->dados_adiantamento($_POST['id']);
        if($dados_adiantamento[0]['confirmacao'] == '0') {
            $this->Tabelas->update('supr_fundos', 'balancete_gerado', 0, 'id', $_POST['id']);
            $this->Tabelas->delete('historico_adiantamento', 'id_adiantamento', $_POST['id']);
            echo json_encode(['response' => 1]);
        }else{
            echo json_encode(['response' => 0]);
        }
        
        
    }

    public function removeufms() {
        $this->Tabelas->delete('ufms', 'id_ufm', $_POST['id']);
        echo json_encode('delete');
    }

    public function confirm_ufm() {
        if(isset($_POST['id'])) {
            $this->Tabelas->update('ufms', 'confirmacao', 's', 'id_ufm', $_POST['id']);
            echo json_encode(['Retorno' => 'ufm confirmada']);
        }
    }

    public function indefere_ufm() {

        if(isset($_POST['id'])) {
            $this->Tabelas->update('ufms', 'confirmacao', 'n', 'id_ufm', $_POST['id']);
            echo json_encode(['Retorno' => 'ufm indeferida']);
        }
    }

    public function confirm_diaria() {

        if(isset($_POST['id'])) {
            $this->Tabelas->update('diarias', 'confirmacao', 's', 'id_diaria', $_POST['id']);
            echo json_encode(['Retorno' => 'diaria confirmada']);
        }
    }

    public function confirm_adiantamento() {

        if(isset($_POST['id'])) {
            $this->Tabelas->update('supr_fundos', 'confirmacao', 's', 'id', $_POST['id']);
            echo json_encode(['Retorno' => 'Adiantamento confirmado']);
        }
    }

    public function indefere_diaria() {

        if(isset($_POST['id'])) {           
            $this->Tabelas->update('diarias', 'confirmacao', 'n', 'id_diaria', $_POST['id']);
            echo json_encode(['Retorno' => 'diaria indeferida']);
        }
    }

    public function indefere_adiantamento() {

        if(isset($_POST['id'])) {           
            $this->Tabelas->update('supr_fundos', 'confirmacao', 'n', 'id', $_POST['id']);
            echo json_encode(['Retorno' => 'adiantamento indeferido']);
        }
    }
    
        

        
}