<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ufm_model extends CI_Model{

    public function __contruct(){
        parent::__construct();
    }

    public function edit($id_ufm, $dados_insert) {
        $query = $this->db->query("UPDATE ufms SET 
           servidor = '{$dados_insert['servidor']}',
           portaria_matricula = '{$dados_insert['portaria_matricula']}',
           estado_destino = '{$dados_insert['estado_destino']}',
           cidade_destino = '{$dados_insert['cidade_destino']}',
           distancia_destino = '{$dados_insert['distancia_destino']}',
           data_saida = '{$dados_insert['data_saida']}',
           data_retorno = '{$dados_insert['data_retorno']}',
           valor_total = '{$dados_insert['valor_total']}',
           tempo_total = '{$dados_insert['tempo_total']}',
           banco = '{$dados_insert['banco']}',
           agencia = '{$dados_insert['agencia']}',
           conta = '{$dados_insert['conta']}',
           veiculo = '{$dados_insert['veiculo']}',
           cpf = '{$dados_insert['cpf']}',
           cargo = '{$dados_insert['cargo']}',
           motivo = '{$dados_insert['motivo']}',
           telefone = '{$dados_insert['telefone']}',
           modified_by = '{$dados_insert['modified_by']}',
           modified = '{$dados_insert['modified']}',
           visualizado = '{$dados_insert['visualizado']}'
           WHERE id_ufm = $id_ufm");
   }

    public function get_confirmacao($id_diaria) {
        $this->db->select('confirmacao')->from('ufms')->where("ufms.id_ufm = $id_diaria");
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function user_confirm_diaria($id_diaria) {
        $this->db->select('user_confirm_diaria')->from('ufms')->where("ufms.id_ufm = $id_diaria");
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function confirmar_diaria($id_diaria) {
        $this->db->query("UPDATE ufms SET user_confirm_diaria = '1' WHERE id_ufm = $id_diaria");
    }
   
   public function dados_ufm($id_ufm) {
       $this->db->select('ufms.*')
                ->from('ufms')
                ->where('ufms.id_ufm = "'. $id_ufm .'"');
       
       $query = $this->db->get()->result_array();
       
       return $query;        
   }

}