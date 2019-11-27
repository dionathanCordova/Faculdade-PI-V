<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estados_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function GetAll() {
        $query = $this->db->order_by('NOME')->get('estado');
        return $query->result_array();
    }

    public function GetEstados() {
        $option = "<option value =''>Selecione o Estado</option>";

        $estados = $this->GetAll();

        foreach($estados as $estado) {
            $uf = $estado['Uf'];
            $nome = $estado['Nome'];
            $option .= "<option value='$uf'>$nome</option>";
        }

        return $option;
    }
}