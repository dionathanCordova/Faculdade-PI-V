<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secretaria_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function GetAll() {
        $query = $this->db->order_by('fundo')->get('secretarias');
        return $query->result_array();
    }

    public function GetSecretaria() {
        $option = "<option value =''>Selecione a Secretaria</option>";

        $secretaria = $this->GetAll();

        foreach($secretaria as $info) {
            // $secretaria_nome = $info['secretaria_nome'];
            $id_selecretaria = $info['id_secretaria'];
            $fundo = $info['fundo'];
            $option .= "<option value='$id_selecretaria'>$fundo</option>";
        }
        return $option;
    }

    public function GetSecretarianome() {
        $option = "<option value =''>Selecione a Secretaria</option>";

        $secretaria = $this->GetAll();

        foreach($secretaria as $info) {
            // $secretaria_nome = $info['secretaria_nome'];
            $id_selecretaria = $info['id_secretaria'];
            $secretaria_nome = $info['secretaria_nome'];
            $option .= "<option value='$id_selecretaria'>$secretaria_nome</option>";
        }
        return $option;
    }
}