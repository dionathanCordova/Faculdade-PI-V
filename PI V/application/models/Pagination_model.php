<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagination_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function count_all_pagination($table, $condicao = null, $valor = null, $servidor = null) {
        if($condicao != null && $valor != null && $valor != 0) {
            $this->db->where($condicao, $valor);
        }
        if($servidor != null) {
            $this->db->where('portaria_matricula', "$servidor");
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function fetch_details_adiantamento($limit, $start, $condicao = null, $valor = null) {
        $output = '';
        $this->db->select("*");
        if($condicao != null && $valor != null) {
            $this->db->where($condicao, $valor);
        }
        $this->db->from("supr_fundos");
        $this->db->order_by("data_cadastro", "DESC");
        $this->db->limit($limit, $start);
    
        $query = $this->db->get();

        $output .= '
            <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Data Cadastro</th>
                <th>Valor adiantamento</th>
                <th>Secretaria</th>
                <th><strong>Status</strong></th>
                <th class="text-center"><strong>Opções</strong> </th>
            </tr>
            ';
        foreach($query->result() as $row) {
            $link = base_url('SuprimentoFundos/view_adiantamento/').$row->id;
            $info_status = '';
            
            if($_SESSION['nivel'] == 5) {
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <button class="btn btn-warning btn-xs disabled"> Em análise </button>
                    </td> ';     
                }         

                if($row->confirmacao  == 's') {
                    $info_status =  '<td> 
                        <button class="btn btn-success btn-xs disabled"> Prestada </button>
                    </td> '; 
                }

                if($row->confirmacao == 'n'){
                    $info_status = '<td>   
                        <button class="btn btn-danger btn-xs disabled"> Indeferida </button>
                    </td>';
                } 
            }

            
            if($_SESSION['nivel'] < 5){
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <span class="label label-warning">Em Análise </span>
                    </td>';
                }

                if($row->confirmacao == "s"){
                    $info_status = '<td> 
                        <span class="label label-success">Contas Prestadas</span>
                    </td>';
                }

                if($row->confirmacao == "n"){
                    $info_status = '<td> 
                        <span class="label label-danger">Indeferido</span>
                    </td>';
                }
            }
        

            $valor_solicitacao = ($row->valor_solicitacao) != '' ? 'R$ '. number_format($row->valor_solicitacao, '2', ',', ''): "nd";

            $output .= '
            <tr>
                <td>'.$row->id.'</td>
                <td>'.$row->responsavel.'</td>
                <td>'.$row->cpf.'</td>
                <td>'.$row->telefone.'</td>
                <td>'.date('d/m/Y', strtotime($row->data_cadastro)).'</td>
                <td>'.$valor_solicitacao.'</td>
                <td>'.str_replace(['FUNDO MANUTENÇÃO', 'DA'], '', $row->fundo).'</td>'
                .$info_status.
                '<td class="text-center">
                    <a href='.  $link . '>
                        <button type="submit" class="btn btn-default btn-xs" name="btn_id" value="'.$row->id.'"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </a>
                </td>
            </tr>
            ';
        }
        $output .= '</table>';
        return $output;
    }

    public function fetch_details_diarias($limit, $start, $condicao = null, $valor = null, $servidor = null) {
        $output = '';

        $this->db->select("*");
        if($condicao != null && $valor != null) {
            $this->db->where($condicao, $valor);
        }
        if($servidor != null){
            $this->db->where('portaria_matricula', "$servidor");
        }
        $this->db->from("diarias");
        $this->db->order_by("data_saida", "DESC");
        $this->db->limit($limit, $start);
    
        $query = $this->db->get();

        $output .= '
            <table class="table table-bordered">
            <tr>
                <th>Servidor</th>
                <th>Destino</th>
                <th>Data Saída</th>
                <th>Data Retorno</th>
                <th>Valor Diária</th>
                <th>Total Horas/Dias</th>
                <th><strong>Status</strong></th>
                <th class="text-center"><strong>Opções</strong> </th>
            </tr>
            ';
        foreach($query->result() as $row) {
            $link = base_url('Diarias/view_diaria/').$row->id_diaria;
            $info_status = '';
            
            if($_SESSION['nivel'] == 5) {
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <button class="btn btn-warning btn-xs disabled"> Em análise </button>
                    </td> ';     
                }         

                if($row->confirmacao  == 's') {
                    $info_status =  '<td> 
                        <button class="btn btn-success btn-xs disabled"> Prestada </button>
                    </td> '; 
                }

                if($row->confirmacao == 'n'){
                    $info_status = '<td>   
                        <button class="btn btn-danger btn-xs disabled"> Indeferida </button>
                    </td>';
                } 
            }

            
            if($_SESSION['nivel'] < 5){
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <span class="label label-warning">Em Análise </span>
                    </td>';
                }

                if($row->confirmacao == "s"){
                    $info_status = '<td> 
                        <span class="label label-success">Contas Prestadas</span>
                    </td>';
                }

                if($row->confirmacao == "n"){
                    $info_status = '<td> 
                        <span class="label label-danger">Indeferido</span>
                    </td>';
                }
            }
        

            $valor_solicitacao = ($row->valor_total) != '' ? 'R$ '. number_format($row->valor_total, '2', ',', ''): "nd";

            $output .= '
            <tr>
                <td>'.$row->servidor.'</td>
                <td>'.$row->cidade_destino. '/'. $row->estado_destino.'</td>
                <td>'.date('d/m/Y', strtotime($row->data_saida)).'</td>
                <td>'.date('d/m/Y', strtotime($row->data_retorno)).'</td>
                <td>'.$valor_solicitacao.'</td>
                <td>'.$row->tempo_total.'</td>'
                .$info_status.
                '<td class="text-center">
                    <a href='.  $link . '>
                        <button type="submit" class="btn btn-default btn-xs" name="btn_id" value="'.$row->id_diaria.'"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </a>
                </td>
            </tr>
            ';
        }
        $output .= '</table>';
        return $output;
    }

    public function fetch_details_ufms($limit, $start, $condicao = null, $valor = null, $servidor = null) {
        $output = '';

        $this->db->select("*");
        if($condicao != null && $valor != null) {
            $this->db->where($condicao, $valor);
        }
        if($servidor != null){
            $this->db->where('portaria_matricula', "$servidor");
        }
        $this->db->from("ufms");
        $this->db->order_by("data_saida", "DESC");
        $this->db->limit($limit, $start);
    
        $query = $this->db->get();

        $output .= '
            <table class="table table-bordered">
            <tr>
                <th>Servidor</th>
                <th>Destino</th>
                <th>Data Saída</th>
                <th>Data Retorno</th>
                <th>Total Horas/Dias</th>
                <th>UFMS</th>
                <th>Valor Diária</th>
                <th><strong>Status</strong></th>
                <th class="text-center"><strong>Opções</strong> </th>
            </tr>
            ';
        foreach($query->result() as $row) {
            $link = base_url('Ufms/view_ufm/').$row->id_ufm;
            $info_status = '';
            
            if($_SESSION['nivel'] == 5) {
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <button class="btn btn-warning btn-xs disabled"> Em análise </button>
                    </td> ';     
                }         

                if($row->confirmacao  == 's') {
                    $info_status =  '<td> 
                        <button class="btn btn-success btn-xs disabled"> Prestada </button>
                    </td> '; 
                }

                if($row->confirmacao == 'n'){
                    $info_status = '<td>   
                        <button class="btn btn-danger btn-xs disabled"> Indeferida </button>
                    </td>';
                } 
            }

            
            if($_SESSION['nivel'] < 5){
                if($row->confirmacao == '0'){
                    $info_status = '<td> 
                        <span class="label label-warning">Em Análise </span>
                    </td>';
                }

                if($row->confirmacao == "s"){
                    $info_status = '<td> 
                        <span class="label label-success">Contas Prestadas</span>
                    </td>';
                }

                if($row->confirmacao == "n"){
                    $info_status = '<td> 
                        <span class="label label-danger">Indeferido</span>
                    </td>';
                }
            }
        

            $valor_solicitacao = ($row->valor_total) != '' ? 'R$ '. number_format($row->valor_total, '2', ',', ''): "nd";

            $output .= '
            <tr>
                <td>'.$row->servidor.'</td>
                <td>'.$row->cidade_destino. '/'. $row->estado_destino.'</td>
                <td>'.date('d/m/Y', strtotime($row->data_saida)).'</td>
                <td>'.date('d/m/Y', strtotime($row->data_retorno)).'</td>
                <td>'.$row->tempo_total.'</td>
                <td>'.number_format($row->ufm, '2', ',', '').'</td>
                <td>'.$valor_solicitacao.'</td>'
                .$info_status.
                '<td class="text-center">
                    <a href='.  $link . '>
                        <button type="submit" class="btn btn-default btn-xs" name="btn_id" value="'.$row->id_ufm.'"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </a>
                </td>
            </tr>
            ';
        }
        $output .= '</table>';
        return $output;
    }
}