<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidades_model extends CI_Model{

    public function __contruct(){
        parent::__construct();
    }

    public function GetCidades($estado = null) {
        $query = $this->db->Where('Uf', $estado)->order_by('nome')->get('municipio');
        return $query->result_array();
    }

    public function select_cidades($cidades = null) {
        $cidade = $this->GetCidades($cidades);

        $option = "";

        foreach($cidade as $city) {
            $cd = $city['Nome'];
            $Uf = $city['Uf'];
            $option .= "<option value='$cd'>$cd - $Uf </option>".PHP_EOL;
        }
        return $option;
    }
}