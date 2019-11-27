<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Simulador extends CI_Controller {



    public function __construct() {

        parent::__construct();



        // carreganho o model Tabelas_model e setando um apelido de Tabelas

        $this->load->model('Tabelas_model', 'Tabelas');

        $this->load->model('Estados_model', 'Estados');

        $this->load->model('Cidades_model', 'Cidades');

        $this->load->model('Veiculo_model', 'Veiculo');

        $this->load->model('Secretaria_model', 'Secretaria');

        $this->load->model('ModalUfm_model', 'Modal_ufm');

        $this->load->model('Distancia_model', 'Distancia');

        $this->load->model('Project_model', 'PjModel');



        $this->load->helper('url');

    }



	public function simulador() {

        // pegar a session de usuario logado

        $this->Tabelas->getSession();

        

        $dados['estado'] = $this->Estados->GetEstados();



        $dados['viewName'] = 'Simulador/simulador';

        $this->load->view('index', $dados);

    }



    public function ufms() {

        // pegar a session de usuario logado

        $this->Tabelas->getSession();



        // CONFIGUDANDO OS VALORES DE HORA DE DATA QUE VEM DO FORMULARIO E SETANDO NO FORMATO PARA O DB

        $hora_saida = $_POST['hora_saida'] .':00';

        $data_saida = str_replace('/', '-', $_POST['data_saida']);

        $data_saida = date('Y-m-d', strtotime($data_saida));

        $data_saida = $data_saida. ' ' . $hora_saida;



        $hora_retorno = $_POST['hora_retorno'] .':00';

        $data_retorno = str_replace('/', '-', $_POST['data_retorno']);

        $data_retorno = date('Y-m-d', strtotime($data_retorno));           

        $data_retorno = $data_retorno . ' ' . $hora_retorno;      



        $distancia = $this->Distancia->Get_distancia($_POST['cidade_destino'], $_POST['estado_destino']);

        $distancia = $distancia[0]['distancia'];

                

        // calculo de diferenca de dias entre saida e retorno

        $saida = date('Y-m-d H:i:s', strtotime($data_saida));

        $retorno = date('Y-m-d H:i:s', strtotime($data_retorno));

        $t_s = strtotime($saida);

        $t_r = strtotime($retorno);

        $diferenca = $t_r - $t_s;

        $data = (float)($diferenca / (60 * 60 * 24) );



        // conversao de tempo exato em dias, horas, minutos;

        $data_a = new DateTime($data_saida);

        $data_b = new DateTime($data_retorno);

        $intervalo = date_diff($data_a,$data_b);





        if($intervalo->format('%D') > 1 && $intervalo->format('%H') > 0) {

            $tempo_total = $intervalo->format('%D Diária(s) + %H Hora(s)');

        }elseif($intervalo->format('%D') > 1 && $intervalo->format('%H') == 0) {

            $tempo_total = $intervalo->format('%D Diária(s)');

        }elseif($intervalo->format('%D') == 0 && $intervalo->format('%H') > 0) {

            $tempo_total = $intervalo->format('%H Hora(s)');

        }elseif($intervalo->format('%D') > 0 && $intervalo->format('%D') <= 1 && $intervalo->format('%H') > 0) {

            $tempo_total = $intervalo->format('%D Diária + %H Hora(s)');            

        }     



        $estado = $_POST['estado_destino'];

    

        // Condiçoes definidas na lei de diarias

        if($estado == "EX") {

            $horas_consedidas = (400 * $data) / 1; 

            $ufm = 'U$';

            $valor_total = number_format($horas_consedidas, 2, ',', '.');

        }else{

          

             $ufm = 0;

             // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA INFERIOR A 100 KM

             if($distancia <= 100) {

                 if($data <= 0.5) {

                     $ufm = 6;

                     $horas_consedidas  = 6;

                 }elseif($data > 0.5){

                     $ufm = 6;

                     $horas_consedidas = ($ufm * $data) / 0.5;  

                 }

             }

             

             // ALGORITMO DE CALCULO FRACIONADO DE UFM COM DISTANCIA SUPERIOR A 100 KM

             if($distancia > 100) {

                 if($data <= 0.5) {

                     $ufm = 9;

                     $horas_consedidas  = 9;

                }elseif($data > 0.5){

                     $ufm = 9;

                     $horas_consedidas = ($ufm * $data) / 0.5;  

                 }

             }



            // ALGORITMO DE CALCULO FRACIONADO DE UFM PERIODO ACIMA DE 24 HORAS

            if($data >= 1 ) {

                $ufm = 17;

                $horas_consedidas = ($ufm * $data) / 1;

            }



            // ALGORITMO DE CALCULO FRACIONADO DE UFM PARA DF

            if($data >= 1 && $estado == "DF") {

                $ufm = 25;

                $horas_consedidas = ($ufm * $data) / 1;

            }

             

            $dados_insert['ufm'] = $horas_consedidas;

            $valor = $horas_consedidas * $_POST['valor_ufm'];



            $valor_total = number_format($valor, 2, ',', '.');

            $horas_consedidas = number_format($horas_consedidas, 2, ',', '.');



            $result = ['valor_total' => $valor_total, 'horas_consedidas' => $horas_consedidas, 'distacie' => $distancia];

            echo json_encode($result);

         }

    }



    public function diarias() {

        // pegar a session de usuario logado

        $this->Tabelas->getSession();

        

         // CONFIGUDANDO OS VALORES DE HORA DE DATA QUE VEM DO FORMULARIO E SETANDO NO FORMATO PARA O DB

        $hora_saida = $_POST['hora_saida'] .':00';

        $data_saida = str_replace('/', '-', $_POST['data_saida']);

        $data_saida = date('Y-m-d', strtotime($data_saida));

        $data_saida = $data_saida. ' ' . $hora_saida;



        $hora_retorno = $_POST['hora_retorno'] .':00';

        $data_retorno = str_replace('/', '-', $_POST['data_retorno']);

        $data_retorno = date('Y-m-d', strtotime($data_retorno));           

        $data_retorno = $data_retorno . ' ' . $hora_retorno;     

        

        // calculo de diferenca de dias entre saida e retorno

        $saida = date('Y-m-d H:i:s', strtotime($data_saida));

        $retorno = date('Y-m-d H:i:s', strtotime($data_retorno));

        

        $t_s = strtotime($saida);

        $t_r = strtotime($retorno);

        $diferenca = $t_r - $t_s;

        $data = (float)($diferenca / (60 * 60 * 24) ); 



        // conversao de tempo exato em dias, horas, minutos;

        $data_a = new DateTime($data_saida);

        $data_b = new DateTime($data_retorno);

        $intervalo = date_diff($data_a,$data_b);



        // $dados_insert['tempo_total'] = $intervalo->format('%D Dias %H Horas %I Minutos');

        if($intervalo->format('%D') > 0 && $intervalo->format('%H') > 0) {

            $tempo_total = $intervalo->format('%D Diárias + %H Horas');

        }elseif($intervalo->format('%D') == 0 && $intervalo->format('%H') > 0) {

            $tempo_total = $intervalo->format('%H Horas');

        }elseif($intervalo->format('%D') > 0 && $intervalo->format('%D') <= 1) {

            $tempo_total = $intervalo->format('%D Diária');

        }elseif($intervalo->format('%D') > 1 && $intervalo->format('%H') == 0) {

            $tempo_total = $intervalo->format('%D Diárias');

        }

                    

        $estado = $_POST['estado_destino'];



        if($data < 0.25) {   

            $msg ='Periodo inferior a 6 horas! Em caso de dúvidas entrar em contato com a Controladoria-Geral!';

            echo json_encode(['msg' => $msg]);

        }else{

            $distancia = $this->Distancia->Get_distancia($_POST['cidade_destino'], $_POST['estado_destino']);

            

            foreach($distancia as $info) {

                $distancia = $info['distancia'] * 2;

            }           

   

            if($distancia >= 100 || $distancia === NULL) {

                

                // ---------------------------- CALCULO DE VALORES DE DIÁRIAS FRACIONADO -----------------------

                if($estado == "SC") {

                    // if($data == 0.25) {

                    //     $data = 0.25;

                    // }elseif($data > 0.25 && $data <= 0.50) {

                    //     $data = 0.50;                            

                    // }

                    $valor_total = number_format(($data * 80), 2, ",", ".");                     

                }else{

                    // if($data == 0.25) {

                    //     $data = 0.25;

                    // }elseif($data > 0.25 && $data <= 0.50) {

                    //     $data = 0.50;

                    // }

                    $valor_total = number_format(($data * 100), 2, ",", ".");     
                }
                $result = ['horas_consedidas' => $tempo_total, 'valor_total' => $valor_total, 'msg' => 'Simulação diária'];
                echo json_encode($result);

            }elseif(isset($_POST['curso']) && $_POST['curso'] == 'on' && $distancia < 100 && $data > 0.3) {
                $valor_total = number_format(($data * 80), 2, ",", ".");
                $result = ['horas_consedidas' => $tempo_total, 'valor_total' => $valor_total, 'msg' => 'Simulação diária'];
                echo json_encode($result);
            }else{
                $msg = "Diaria indisponível para distância inferior a 50 km de deslocamento onde o motivo seja diferente de (cursos), e tempo total de diária seja inferior a 08Hs. Em caso de dúvidas entrar em contato com a Controladoria-Geral!";
                echo json_encode(['msg' => $msg, 'curso' => $_POST['curso'], 'distancis' => $distancia, 'tempo', $data]);
            }
        }
    }
}       