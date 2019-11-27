<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Veiculo_model extends CI_Model{

    public function __contruct(){
        parent::__construct();
    }

    public function getVeiculos() {
        if($_SESSION['nivel'] != 5){
            $this->db->where("id_secretarias = ". $_SESSION['secretaria']);
        }     
          
        $query = $this->db->order_by('modelo')->get('veiculos');
        return $query->result_array();
    }

    public function getVeiculosServidor($id_servidor){
        // $this->db->where("id_secretarias = ". $_SESSION['secretaria']);
        // $this->db->join('servidores', "servidores.id_servidor = id_servidor");
        // $query = $this->db->order_by('modelo')->get('veiculos');
       
        $this->db->select('modelo, placa');    
        $this->db->from('veiculoss');
        $this->db->join('servidores', "servidores.id_servidor = $id_servidor");
        $this->db->where("id_secretarias = ". $_SESSION['secretaria']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function select_veiculos() {
        $veiculos = $this->getVeiculos();

        $option = '<option>Selecione o veículo:</option>';

        foreach($veiculos as $info) {
            $modelo = $info['modelo'];
            $option .= "<option value='$modelo'>$modelo</option>";
        }
        return $option;
    }

    public function compara_veiculo($veiculo, $placa) {
        $this->db->select('modelo');
        $this->db->like('modelo', $veiculo, 'after');
        $this->db->like('placa', $veiculo, 'after');
        $query = $this->db->get('veiculos')->result_array();
        return $query;
    }

    public function inderir_carro($veiculo,  $placa, $id_secretaria) {
        $data = array('modelo'=> $veiculo, 'placa' => $placa, 'id_secretarias' => $id_secretaria);
        $this->db->insert('veiculos', $data);
    }
}