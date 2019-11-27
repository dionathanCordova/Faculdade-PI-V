<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distancia_model extends CI_Model{

    public function __contruct(){
        parent::__construct();
    }

    public function Get_distancia($municipio, $uf) {
        $this->db->select('municipio.distancia')
                ->from('municipio')
                ->where('municipio.nome = ', $municipio)
                ->where('municipio.uf',  $uf);

        $query = $this->db->get()->result_array();

        return $query;
    }

}