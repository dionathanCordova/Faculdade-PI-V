<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuprementoFundos_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function getPropostas() {
        $result = $this->db->get('supr_fundos')->result_array();
        return $result;
    }

    public function insertProposta($fundo, $id_fundo, $orgao, $atividade, $elemento_despesa, $valor_solicitacao, $servidor, $matricula, $cpf, $banco, $agencia, $conta, $telefone, $motivo, $data_cadastro, $created_by) {
        $dados = array(
            'fundo' => $fundo,
            'id_secretaria' => $id_fundo,
            'orgao' => $orgao,
            'atividade' => $atividade,
            'elemento_despesa' => $elemento_despesa,
            'valor_solicitacao' => $valor_solicitacao,
            'responsavel' => $servidor,
            'matricula' => $matricula,
            'cpf' => $cpf,
            'banco' => $banco,
            'agencia' => $agencia,
            'conta' => $conta,
            'telefone' => $telefone,
            'motivo' => $motivo,
            'data_cadastro' => $data_cadastro,
            'created_by' => $created_by,
        );

        $ret = $this->db->insert('supr_fundos', $dados);
        if($ret) {
            return ['response' => 'true'];
        }else{
            return ['response' => 'Falha no cadastro'];
        }
    }

    public function insertHistorico($recibo, $data, $razao_social, $pagamento, $valor_solicitacao, $data_deposito, $id_adiantamento, $data_cadastro) {
        $dados = array(
            'recibo' => $recibo,
            'data' => $data,
            'razaosocial' => $razao_social,
            'pagamento' => $pagamento,
            'valor_solicitacao' => $valor_solicitacao,
            'data_deposito' => $data_deposito,
            'id_adiantamento' => $id_adiantamento,
            'data_cadastro' => $data_cadastro
        );

        $ret = $this->db->insert('historico_adiantamento', $dados);
        if($ret) {
            return ['response' => 'true'];
        }else{
            return ['response' => 'Falha no cadastro'];
        }
    }

    public function get_confirmacao($id) {
        $this->db->select('confirmacao')->from('supr_fundos')->where("id = $id");
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function user_confirm_adiantamento($id) {
        $this->db->select('user_confirm_diaria')->from('supr_fundos')->where("id = $id");
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function confirmar_adiantamento($id) {
        $this->db->query("UPDATE supr_fundos SET user_confirm_diaria = '1' WHERE id = $id");
    }

    public function edit($id, $dados_insert) {
        $modifield  = date('Y-m-d');
        $query = $this->db->query("UPDATE supr_fundos SET 
            responsavel  = '{$dados_insert['servidor']}',
            matricula  = '{$dados_insert['matricula']}',
            cpf  = '{$dados_insert['cpf']}',
            banco  = '{$dados_insert['banco']}',
            agencia = '{$dados_insert['agencia']}',
            conta  = '{$dados_insert['conta']}',
            telefone = '{$dados_insert['telefone']}',
            motivo  = '{$dados_insert['motivo']}',
            valor_solicitacao = '{$dados_insert['valor_solicitacao']}',
            modifield = '$modifield',
            visualizado = 0
            WHERE id = $id");
    }

    public function dados_adiantamento($id) {
        $this->db->select('supr_fundos.*')
                ->from('supr_fundos')
                ->where('id = "'. $id .'"');
        
        $query = $this->db->get()->result_array();
        
        return $query;        
    }

    public function dados_balancete($id) {
        $this->db->select('historico_adiantamento.*')
                ->from('historico_adiantamento')
                ->where('id_adiantamento = "'. $id .'"');
        
        $query = $this->db->get()->result_array();
        
        return $query;        
    }

    public function getBalanceteGerado($id) {
        $this->db->select('balancete_gerado')->from('supr_fundos')->where("id = $id");
        $query = $this->db->get()->result_array();
        return $query;
    }

    function count_all($condicao = null, $valor = null) {
        if($condicao != null && $valor != null) {
            $this->db->where($condicao, $valor);
        }
        $query = $this->db->get("supr_fundos");
        return $query->num_rows();
    }

    public function fetch_details($limit, $start, $condicao = null, $valor = null) {
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
                <th>data_cadastro</th>
                <th>Valor Diária</th>
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
                    // '<td>   
                    //     <button  class="btn btn-success btn-xs confirm-adiantamento" value='.$row->id.'" name="id_diaria-confirmar"><span class="fa fa-thumbs-up"></span></button>                                                
                    //     <button  class="btn btn-warning btn-xs indefere-adiantamento"  value='.$row->id.'" name="id_diaria-indeferir"><span class="fa fa-thumbs-down"></span></button>
                    // </td>';  
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
}

/*








*/