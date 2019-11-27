<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model{
    private $dbase;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // metodo para saber se o usuarui esta logado
    // public function getSession($session) {
    //     if($session != "true") {
    //         session_destroy();
    //         redirect('/');
    //     }
    // }

    public function login() {

        // Comparação dos dados digitados pelo usuario para efetuar o login,
        // Addslashes é uma foma básica para prevenção de SQL injection;
        $this->db->where('email', addslashes($this->input->post('email')));
        $this->db->where('password', addslashes(md5($this->input->post('password'))));

        $query = $this->db->get('usuarios');

        if (count($query->result_array()) == 1) {
            $retorno = $query->result_array();
        }else{
            $retorno = array('fail');
        }

        return $retorno;
    }

    public function altera_senha($email, $senha) {
        $this->db->where('email', $email);
        $this->db->set('password', $senha);
        return $this->db->update('user');
    }

    public function cria_conta($user, $email, $senha) {
        // Variabel receberá uma mensagem de cadastro ja existemte quando tentar repetir cadastro de email
        $cadastro = '';
        
        // Busca do email informado, para verificar duplicidade no DB
        $this->db->where('email', addslashes($email));
        $query = $this->db->get('usuarios');

        // caso email ja exista no banco, a mensagem é imformada
        if($query->num_rows() > 0) {
            $cadastro = 'Já existe este email cadastrado em nosso sistema';
        }else{
            $data = array(
                'user' => $user,
                'email'     => $email,
                'password'  => md5($senha)
            );
            $cadastro = 'Cadastro concluido!';
           
            $this->db->insert('usuarios', $data);  
     
            redirect('/'); 
        }      
        return $cadastro;  
    }

    public function cadastro_servidor($dados) {          
        $cadastro = 'Cadastro concluido!';
        $this->db->insert('servidores', $dados);  
        $last_id = $this->db->insert_id(); 
        
        return $cadastro;  
    }

    public function cadastro_insert($table, $dados) {    
        $cadastro = '';      
        // Busca do email informado, para verificar duplicidade no DB
        $this->db->where('email', addslashes($dados['email']));
        $query = $this->db->get('usuarios');

        // caso email ja exista no banco, a mensagem é imformada
        if($query->num_rows() > 0) {
            $cadastro = 'Já existe este email cadastrado em nosso sistema';
        }else{
            $cadastro = 'Cadastro concluido!';
            $this->db->insert('usuarios', $dados);  
            $last_id = $this->db->insert_id(); 
        }      
        return $cadastro;  
    }

    public function cadastro_estado($dados) {
        $this->db->insert('Estados', $dados);
    }

    public function edita_conta($id_user, $user, $email, $password) {
        $cadastro = '';
        $data = array();

        
        // Recebendo todos os dados do usuario
        $query = $this->getDadosUsuarios(addslashes($id_user));
        foreach($query as $info){
            $data_nome = $info['user'];
            $data_email = $info['email'];
            $data_password = $info['password'];
        };
        
        if($email != null) {
            // Comparacao do email informado para evitar duplicidade de cadastro do mesmo
            $this->db->where('email', addslashes($email));
            $query2 = $this->db->get('usuarios');
                      
            if($query2->num_rows() > 0) {
                $cadastro = 'Já existe este email cadastrado em nosso sistema';
            }else{
                $data_email = $email;
            }           
        }
        
        if($user != null) {
            $data_user = $user;
        }

        if($password != null) {
            $data_password = md5($password);
        }
      
        if($user != null || $password != null || $email != null) {
            $cadastro = 'Alteração concluida!';
            $query = $this->db->query("UPDATE usuarios SET user = '$data_user', email = '$data_email',  password = '$data_password' WHERE id_usuario = $id_user "); 
        };
       
        return $cadastro;  
    }
    
    public function editar_usuario($dados_insert, $id_usuario) {
        $query = $this->db->query("UPDATE usuarios SET user = '{$dados_insert['user']}', email = '{$dados_insert['email']}', password = '{$dados_insert['password']}' WHERE id_usuario = $id_usuario"); 
    }

    public function editar_dados_servidor($dados_insert, $id_servidor) {
        $query = $this->db->query("UPDATE servidores SET nome = '{$dados_insert['nome']}', cargo = '{$dados_insert['cargo']}', matricula = '{$dados_insert['matricula']}', cpf = '{$dados_insert['cpf']}', banco = '{$dados_insert['banco']}', agencia = '{$dados_insert['agencia']}', cc = '{$dados_insert['cc']}', telefone = '{$dados_insert['telefone']}', veiculos = '{$dados_insert['veiculo']}', modelo = '{$dados_insert['modelo']}', placa = '{$dados_insert['placa']}' WHERE id_servidor = $id_servidor"); 
    }

    public function update_generico($table, $array_insert, $condicao, $valor) {
        $count = count($array_insert);
        $dado = '';
        foreach($array_insert as $k=>$val) {
            $dado .= $k . ' = '. $val;
        }
        $sql = "UPDATE $table SET " . $dado  . " WHERE $condicao = $valor"; 
        $this->db->query($sql);
    }

    public function deleta_servidores($id) {
        $this->db->where('id_servidor', $id);
        $this->db->delete('servidores');
    }
    
    public function deleta_conta($id) {
        $this->db->where('id_usuario', $id);
        $this->db->delete('usuarios');
    }

    // Retorna os Dados dos usuario para que possa ser feita uma alteração na pagina Prifile
    public function getDadosUsuarios($id_user) {
        $this->db->where('id_usuario', $id_user);
        $query = $this->db->get('usuarios');
        return $query->result_array();        
    }

     // Retorna os Dados dos usuario para que possa ser feita uma alteração na pagina Prifile
     public function getDadosServidor($id_user) {
        $this->db->where('id_servidor', $id_user);
        $query = $this->db->get('servidores');
        return $query->result_array();        
    }

    public function getTodosUsuarios() {
        $query = $this->db->get('usuarios');
        return $query->result_array(); 
    }

    public function getTodosUsuariosSecretaria($id_secretaria) {
        $this->db->where("id_secretaria = $id_secretaria");
        $query = $this->db->get('servidores');
        return $query->result_array(); 
    }

    public function options_servidores($id_secretaria) {
        $veiculos = $this->getTodosUsuariosSecretaria($id_secretaria);

        $option = '<option>Selecione o Servidor:</option>';

        foreach($veiculos as $info) {
            $id_servidor = $info['id_servidor'];
            $nome = $info['nome'];
            $option .= "<option value='$id_servidor'>$nome</option>";
        }
        return $option;
    }

    public function getDadosSecretaria($id_secretaria) {
        $this->db->where("id_secretaria = $id_secretaria");
        $query = $this->db->get('secretarias');
        return $query->result_array(); 
    }

}

