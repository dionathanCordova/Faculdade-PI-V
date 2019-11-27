<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard_model extends CI_Model{



    public function __contruct(){

        parent::__construct();

    }



    public function dados_diaria($table, $id_secretaria = null, $servidor = null, $exercicio = null, $mesinit = null, $mesFim = null) {

        if($id_secretaria != null) {
            if($servidor != null) {
                $where = 'secretarias.id_secretaria = "'. $id_secretaria .'" AND portaria_matricula =' ."$servidor" . ' ';
            }else{
                $where = 'secretarias.id_secretaria = "'. $id_secretaria .'"';
            }
        }else{
            if($servidor != null) {
                $where = 'secretarias.id_secretaria > 0 AND portaria_matricula  =' ."$servidor" . ' ';
            }else{
                $where = 'secretarias.id_secretaria > 0';
            }
        }

        if($exercicio != null) {
            $sect_exercicio = 'exercicio = ' .  "$exercicio";
            $ano = "$exercicio";
        }else{
            $sect_exercicio = 'exercicio = ' .  date('Y');
            $ano = date('Y');
        }

        $id = 'id_' . "$table";

        $id = str_replace('s', '', $id);
        if($mesinit != null && $mesFim != null) {
            $Where_mes = "data_saida BETWEEN '$mesinit' AND '$mesFim'";
            $this->db->select("$id, $table.servidor, $table.portaria_matricula, $table.cargo, $table.cidade_destino, $table.estado_destino, $table.data_saida, $table.data_retorno, $table.confirmacao, $table.valor_total, $table.tempo_total, $table.prestacao_contas, secretarias.secretaria_nome")
            ->from("$table")
            ->join('secretarias',"secretarias.id_secretaria = $table.id_secretaria", 'left')
            ->where($sect_exercicio)
            ->where($where)
            ->where( "$Where_mes" )
            ->order_by('servidor', 'ASC')
            ->order_by('data_saida', 'ASC');
        }else{
            $this->db->select("$id, $table.servidor, $table.portaria_matricula, $table.cargo, $table.cidade_destino, $table.estado_destino, $table.data_saida, $table.data_retorno, $table.confirmacao, $table.valor_total, $table.tempo_total, $table.prestacao_contas, secretarias.secretaria_nome")
            ->from("$table")
            ->join('secretarias',"secretarias.id_secretaria = $table.id_secretaria", 'left')
            ->where($sect_exercicio)
            ->where($where)
            ->order_by('servidor', 'ASC')
            ->order_by('data_saida', 'ASC');
        }

        $query = $this->db->get()->result_array();

        return $query;        
    }



    public function dados_diaria_relatorio($table, $id_secretaria = null, $servidor = null, $exercicio = null, $mesinit = null, $mesFim = null) {

        if($id_secretaria != null) {
            if($servidor != null) {
                $where = 'secretarias.id_secretaria = "'. $id_secretaria .'" AND portaria_matricula  =' ."$servidor" . ' ';
                $group = 'servidor';
            }else{
                $where = 'secretarias.id_secretaria = "'. $id_secretaria .'"';
                $group = 'secretarias.secretaria_nome';
            }
        }else{
            if($servidor != null) {
                $where = 'secretarias.id_secretaria > 0 AND portaria_matricula  =' ."$servidor" . ' ';
                $group = 'servidor';
            }else{
                $where = 'secretarias.id_secretaria > 0';
                $group = 'secretarias.secretaria_nome';
            }
        }

        if($exercicio != null) {
            $sect_exercicio = 'exercicio = ' .  "$exercicio";
            $ano = "$exercicio";
        }else{
            $sect_exercicio = 'exercicio = ' .  date('Y');
            $ano = date('Y');
        }
        
        $id = 'id_' . "$table";
        $id = str_replace('s', '', $id);
        if($mesinit != null && $mesFim != null) {
            $Where_mes = "data_saida BETWEEN '$mesinit' AND '$mesFim'";
            $this->db->select("$id, $table.servidor, $table.exercicio, $table.portaria_matricula, $table.id_secretaria, count($table.data_cadastro) as total_diarias, sum($table.valor_total) as valor_total, secretarias.secretaria_nome")
            ->from("$table")
            ->join('secretarias',"secretarias.id_secretaria = $table.id_secretaria", 'left')
            ->where($sect_exercicio)
            ->where($where)
            ->where("$Where_mes" )
            ->group_by($group)
            ->order_by('exercicio', 'ASC')
            ->order_by('data_saida', 'ASC');
        }else{
            $this->db->select("$id, $table.servidor, $table.exercicio, $table.portaria_matricula, $table.id_secretaria, count($table.data_cadastro) as total_diarias, sum($table.valor_total) as valor_total, secretarias.secretaria_nome")
                     ->from("$table")
                     ->join('secretarias',"secretarias.id_secretaria = $table.id_secretaria", 'left')
                     ->where($sect_exercicio)
                     ->where($where)
                     ->group_by($group)
                     ->order_by('exercicio', 'ASC')
                     ->order_by('data_saida', 'ASC');
        }

        $query = $this->db->get()->result_array();

        return $query;        
    }
}

    