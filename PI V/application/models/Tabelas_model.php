<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabelas_model extends CI_Model{
    private $dbase;

    public function __construct() {
        parent::__construct();
        // $this->load->database();
    }

    // metodo para saber se o usuarui esta logado
    public function getSession() {
        $tokenUser = md5('seq'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);

        if($_SESSION["logado"] != "true") {
            session_destroy();
            redirect('home');
        }else if (isset($_SESSION['donoDaSessao'])  != $tokenUser) {
            session_destroy();
            redirect('home');
        }
    }

        // select comum
    public function Select($tbname = null, $orderBy, $limit = null) {
        $query = $this->db->query("SELECT * FROM $tbname ORDER BY $orderBy DESC $limit");
        return $query->result_array();
    }

    // SELECIONAR DIARIAS DE SERVIDORES POR SECRETARIA QUE ESTA LOGADA
    public function select_cadastros_secretaria($tabela, $orderBy, $secretaria, $limit = null) {
        if($limit != null) {
            $query = $this->db->query("SELECT $tabela.* 
            FROM $tabela 
                WHERE `id_secretaria` =  $secretaria
                ORDER BY $orderBy DESC
                $limit"
            );
        }else{
            $query = $this->db->query("SELECT $tabela.* 
            FROM $tabela 
                WHERE `id_secretaria` =  $secretaria
                ORDER BY $orderBy DESC"
            );
        }
        
        return $query->result_array();
    }
    
    public function dados_diaria($id) {
        $this->db->select('diarias.*, secretarias.*')
                 ->from('diarias')
                 ->join('secretarias','secretarias.id_secretaria = diarias.id_secretaria','left')
                 ->where('diarias.id_diaria = "'. $id .'"');
        
        $query = $this->db->get()->result_array();
        
        return $query;        
    }

    public function dados_adiantamento($id) {
        $this->db->where('id', $id);
        $response = $this->db->get('supr_fundos');
        return $response->result_array();        
    }
  
    public function update($tabela, $campo, $valor, $condicao, $id) {
        $query = $this->db->query("UPDATE $tabela SET $campo = '$valor' WHERE $condicao = '$id' ");
    }

    // metodo acha o item especifico que foi escolhido no menu de produtos
    public function filtro($tbname, $genero = null, $valor= null) {
        $query = $this->db->query("SELECT * FROM $tbname WHERE $genero = '$valor' ORDER BY data_saida desc " );
        return $query->result_array();
    }

    public function filtro_gastos_ano($tbname, $genero = null, $valor= null) {
        $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tbname WHERE $genero = '$valor' and YEAR(data_saida) = YEAR(now())");
        return $query->result_array();
    }

    public function filtro_gastos_mes($tbname, $genero = null, $valor= null, $mes_diaria = null) {
        $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tbname WHERE $genero = '$valor' and MONTH(data_saida) =  MONTH('$mes_diaria')");
        return $query->result_array();
    }

    public function filtro_dados_nome_mes($tbname, $condicao = null, $valor = null, $mes_diaria = null) {
        $query = $this->db->query("SELECT diarias.* FROM $tbname WHERE $condicao = '$valor' AND MONTH(data_saida) = MONTH('$mes_diaria') ");
        return $query->result_array();
    }

    public function filtro_dados_mes($tbname, $mes_diaria = null) {
        $query = $this->db->query("SELECT diarias.* FROM $tbname WHERE MONTH(data_saida) = MONTH('$mes_diaria') ");
        return $query->result_array();
    }

    // metodo sendo usado para carregas os servidores que possuem diarias cadastradas no banco
    public function Servidor_nome($secretaria, $exercicio = null) {
        $not = ['Exterior'];
        $this->db->select('servidor, portaria_matricula');
        if($secretaria != 6) {
            $this->db->where('id_secretaria', $secretaria);
        }
        if($exercicio != null) {
            $this->db->where('exercicio', $exercicio);
        }else{
            $this->db->where('exercicio', date('Y'));
        }
        $this->db->where_not_in('estado_destino', $not);
        $this->db->group_by('servidor');
        $query = $this->db->get('diarias');
        return $query->result_array();
    }

    // BUSCA NOMES DOS SERVIDORES NA PAGINA DE DIARIAS
    public function Servidor_nome_busca($table, $secretaria, $exercicio = null) {
        $not = ['Exterior'];
        $this->db->select('servidor, portaria_matricula');
        if($secretaria != 0) {
            $this->db->where('id_secretaria', $secretaria);
        }
        if($exercicio != null) {
            $this->db->where('exercicio', $exercicio);
        }else{
            $this->db->where('exercicio', date('Y'));
        }
        $this->db->where_not_in('estado_destino', $not);
        $this->db->group_by('servidor');
        $query = $this->db->get($table);

        $output = '<option value="">Servidor</option>';
        foreach($query->result() as $info) {
            $output .= '<option value=' . $info->portaria_matricula .'>'.$info->servidor .'</option>';
        };
        return  $output;
    }
    

    // NOTA ARRUMAR RELATORIO DE DIARIAS PRO EXTERIOR

    // BUSCA EXERCICIOS com diarias cadastradas
    public function Exercicio_busca($table, $secretaria) {
        $not = ['Exterior'];
        $this->db->select('exercicio');
        if($secretaria != 0) {
            $this->db->where('id_secretaria', $secretaria);
        }
        $this->db->where_not_in('estado_destino', $not);
        $this->db->group_by('exercicio');
        $query = $this->db->get($table);

        $output = '<option value="">Exercício</option>';
        foreach($query->result() as $info) {
            if(!empty($info->exercicio)) {
                $output .= '<option value=' . $info->exercicio .'>'.$info->exercicio.'</option>';
            }
        };
        return  $output;
    }

     // metodo sendo usado para carregas os servidores que possuem diarias cadastradas no banco
     public function Servidor_nome_ufms($tabela) {
        $query = $this->db->query("SELECT servidor FROM $tabela GROUP BY servidor");
        return $query->result_array();
    }

    public function delete($tabela, $condicao, $valor) {
        $query = $this->db->query("DELETE FROM $tabela WHERE $condicao = '$valor' ");
    }

    public function gastos_mensais($tabela, $mes, $secretaria = null) {
        if($secretaria != null) {
            $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tabela
                where MONTH(data_saida) =  MONTH('$mes') AND id_secretaria = $secretaria;"
            );
        }else{
            $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tabela
            where MONTH(data_saida) =  MONTH('$mes')"
            );
        }
        
        return $query->result_array();
    }

    // resultado gerado pelo ano
    public function gastos_anuais($tabela, $secretaria = null) {
        if($secretaria != null) {
            $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tabela
                WHERE YEAR(data_saida) = YEAR(now()) AND id_secretaria = $secretaria
            ");
        }else{
            $query = $this->db->query("SELECT sum(valor_total) as Total FROM $tabela
                WHERE YEAR(data_saida) = YEAR(now())
            ");
        }
        
        return $query->result_array();
    }
}