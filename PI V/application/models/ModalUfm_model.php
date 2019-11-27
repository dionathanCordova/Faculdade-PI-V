<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModalUfm_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function dados_ufm($id) {
        $this->db->select('ufms.*, secretarias.*')
                 ->from('ufms')
                 ->join('secretarias','secretarias.id_secretaria = ufms.id_secretaria ','left')
                 ->where('ufms.id_ufm = "'. $id .'"');
        
        $query = $this->db->get()->result_array();
        
        return $query;        
    }
    
    public function get_datos_ufm_modal($id = null) {
        $dados = $this->dados_ufm($id);
        $data = [];
        foreach($dados as $info) {
            $data = array(
                'id_ufm' => $info['id_ufm'],
                'servidor' => $info['servidor'],
                'matricula_portaria' => $info['portaria_matricula'],
                'estado_destino' => $info['estado_destino'],
                'cidade_destino' => $info['cidade_destino'],
                'distancia_destino' => $info['distancia_destino'],	
                'data_saida' => date('d/m/Y - h:m', strtotime($info['data_saida'])),	
                'data_retorno' => date('d/m/Y - h:m', strtotime($info['data_retorno'])),
                'valor_total' => $info['valor_total'],	
                'tempo_total' => $info['tempo_total'],	
                // 'matricula' => $info['matricula'],
                'banco' => $info['banco'],	
                'agencia' => $info['agencia'],	
                'conta' => $info['conta'],	
                'veiculo' => $info['veiculo'],	
                'orgao' => $info['orgao'],	
                'atividade' => $info['atividade'],
                'elemento_despesa' => $info['elemento_despesa'],	
                'cpf' => $info['cpf'],	
                'cargo' => $info['cargo'],	
                'motivo' => $info['motivo'],	
                'fundo' => $info['fundo'],
                'qtd_diarias'=> $info['tempo_total'],
                'secretaria_nome' => $info['secretaria_nome'],
                'qtd_ufm'=> $info['ufm'],
                'valor_ufm' => $info['valor_ufm'] 
            );
        }
        return $data;
    }
}