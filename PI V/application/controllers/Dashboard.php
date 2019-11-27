<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends CI_Controller {



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

        $this->load->model('Dashboard_model', 'Dashboard');



        $this->load->helper('url');

    }



    public function servidores_option() {

        // NOMES DE SERVIDORES COM DIARIAS CADASTRADAS

        $exercicio =  ($this->input->post('exercicio') != '')?$this->input->post('exercicio'): null;

        $servidores_select = $this->Tabelas->Servidor_nome_busca($this->input->post('tabela'),  $this->input->post('id_secretaria'), $exercicio);    

         

        echo json_encode(['tabela:' => $this->input->post('tabela'), 'id_secretaria:' =>  $this->input->post('id_secretaria'), 'servidores' => $servidores_select]);

    }



	public function dashboard() {

        // pegar a session de usuario logado
        $this->Tabelas->getSession();

        if($_SESSION['nivel'] == 5){

            $dados['diarias'] = $this->Dashboard->dados_diaria();

        }else{

            $dados['diarias'] = $this->Dashboard->dados_diaria($_SESSION['secretaria']);

        }

        $dados['viewName'] = 'Dashboard/dashboard';

        $this->load->view('index', $dados);

    }





    public function dashboardsDados($table = null) {
        $this->Tabelas->getSession();


        if($table == null && isset($_POST['tabela'])) {
            $table = $_POST['tabela'];
        };

        $dados['tabela'] = $table ;

        if($_SESSION['nivel'] == 5){
            $dados['secretaria'] = $this->Secretaria->GetSecretaria();
        }else{
            $dados['secretaria'] = $this->Secretaria->GetSecretaria($_SESSION['secretaria']);
        }

        $dados_relatorio = array(
            'id_secretaria' => null,
            'nome_servidor' => null,
            'exercicio' => null
        );

        if(!empty($_POST)) {
            // $this->dump($_POST) ;
            $dados_relatorio['id_secretaria'] = isset($_POST['id_select_secretaria']) ? $_POST['id_select_secretaria'] : null;
            
            $dados_relatorio['nome_servidor'] = !empty($_POST['nome_servidor']) ? $_POST['nome_servidor'] :  null;
            
            $dados_relatorio['exercicio'] = !empty($_POST['exercicio']) ? $_POST['exercicio'] :  date('Y');
            
            $dados_relatorio['mes'] = !empty($_POST['mes_diaria']) ? $_POST['mes_diaria'] :  '';
            
            if( $dados_relatorio['mes'] != '') {
                $mesInit =  $dados_relatorio['exercicio'] . '-'.$dados_relatorio['mes'] . '-01';
                if($dados_relatorio['mes'] + 1 > 12 ) {
                    $mesFuturo = 12;
                }else{
                    $mesFuturo = $dados_relatorio['mes'] + 1;
                }
                $mesFim =  $dados_relatorio['exercicio'] . '-'. "$mesFuturo" .'-01';
                $dados['mesInit'] = $mesInit; 
                $dados['mesFim'] = $mesFim;
            }else{
                $mesInit = null;
                $mesFim = null;
            }

            if($_SESSION['nivel'] == 5) {
                // TRAS RESULTADO DOS REGISTROS NA PAGINA PRINCIPAL
                $dados['diarias'] =  $this->Dashboard->dados_diaria($table, $dados_relatorio['id_secretaria'],  $dados_relatorio['nome_servidor'], $dados_relatorio['exercicio'], $mesInit, $mesFim);
                // MONTA OS DADOS PARA MONTAR O RELATORIO EM PDF
                $dados['diarias_relatorio'] =  $this->Dashboard->dados_diaria_relatorio($table,  $dados_relatorio['id_secretaria'] , $dados_relatorio['nome_servidor'], $dados_relatorio['exercicio'], $mesInit, $mesFim);

                $dados['nome_servidor'] =  ($dados_relatorio['nome_servidor'] != null)? (isset($dados['diarias_relatorio'][0]['servidor']) ? $dados['diarias_relatorio'][0]['servidor']: '') : null;

            }else{
                // TRAS RESULTADO DOS REGISTROS NA PAGINA PRINCIPAL
                $dados['diarias'] =  $this->Dashboard->dados_diaria($table, $_SESSION['secretaria'],  $dados_relatorio['nome_servidor'], $dados_relatorio['exercicio'], $mesInit, $mesFim);
                // MONTA OS DADOS PARA MONTAR O RELATORIO EM PDF
                $dados['diarias_relatorio'] =  $this->Dashboard->dados_diaria_relatorio($table, $_SESSION['secretaria'], $dados_relatorio['nome_servidor'], $dados_relatorio['exercicio'], $mesInit, $mesFim);

                $dados['nome_servidor'] =  ($dados_relatorio['nome_servidor'] != null)? (isset($dados['diarias_relatorio'][0]['servidor']) ? $dados['diarias_relatorio'][0]['servidor']: '')  : null;

            }

        }else{

      
            if($_SESSION['nivel'] == 5) {
                 // TRAS RESULTADO DOS REGISTROS NA PAGINA PRINCIPAL
                $dados['diarias'] =  $this->Dashboard->dados_diaria($table, $dados_relatorio['id_secretaria']);
           
                // MONTA OS DADOS PARA MONTAR O RELATORIO EM PDF
                $dados['diarias_relatorio'] =  $this->Dashboard->dados_diaria_relatorio($table, $dados_relatorio['id_secretaria']);

                $dados['nome_servidor'] =  ($dados_relatorio['nome_servidor'] != null)? (isset($dados['diarias_relatorio'][0]['servidor']) ? $dados['diarias_relatorio'][0]['servidor']: '')  : null;

      
        
        

            }else{
                // TRAS RESULTADO DOS REGISTROS NA PAGINA PRINCIPAL
                $dados['diarias'] =  $this->Dashboard->dados_diaria($table, $_SESSION['secretaria']);
                // MONTA OS DADOS PARA MONTAR O RELATORIO EM PDF
                $dados['diarias_relatorio'] =  $this->Dashboard->dados_diaria_relatorio($table, $_SESSION['secretaria']);

                $dados['nome_servidor'] =  ($dados_relatorio['nome_servidor'] != null)? (isset($dados['diarias_relatorio'][0]['servidor']) ? $dados['diarias_relatorio'][0]['servidor']: '')  : null;

            }

        }   

        $soma_total = 0;

        foreach($dados['diarias_relatorio'] as $info) {

            $soma_total = $soma_total + $info['valor_total'];

        }

        $dados['soma_total'] = $this->formato_valor($soma_total);


        if(count($dados['diarias_relatorio']) > 0) {
            
            if($_SESSION['nivel'] == 5) {
                if($dados_relatorio['nome_servidor'] != null) {
    
                    $dados['Titulo'] = $dados['diarias_relatorio'][0]['servidor'];
    
                }elseif($dados_relatorio['id_secretaria'] == null) {
    
                    $dados['Titulo'] = 'Todas as Secretarias';
    
                }else{
    
                    $dados['Titulo'] = str_replace(['SECRETARIA MUNICIPAL', 'DA'], '', $dados['diarias_relatorio'][0]['secretaria_nome']);
    
                }
    
            }else{
    
                if($dados_relatorio['id_secretaria'] == null) {
    
                    $dados['Titulo'] = isset($_POST['nome_servidor']) ? $_POST['nome_servidor'] : $dados['secretaria'];
    
                }else{
    
                    $dados['Titulo'] = str_replace(['SECRETARIA MUNICIPAL', 'DA'], '', $dados['diarias_relatorio'][0]['secretaria_nome']);
    
                }
    
            }
        }
        



        // MONTANDO UM SELECT OPTION HTML COM TODOS OS EXERCICIOS QUE POSSUEM DIARIAS

        $dados['exercicio'] = $this->Tabelas->Exercicio_busca($table,  $dados_relatorio['id_secretaria']);  



        $confirmados_jan = 0;

        $prestar_contas_jan = 0;

        $cadastradas_jan = 0;

        $valor_total_jan = 0;



        $confirmados_Fev= 0;

        $prestar_contas_Fev= 0;

        $cadastradas_Fev = 0;

        $valor_total_Fev = 0;



        $confirmados_Mar = 0;

        $prestar_contas_Mar = 0;

        $cadastradas_Mar = 0;

        $valor_total_Mar = 0;



        $confirmados_Abr = 0;

        $prestar_contas_Abr = 0;

        $cadastradas_Abr = 0;

        $valor_total_Abr = 0;



        $confirmados_Mai = 0;

        $prestar_contas_Mai = 0;

        $cadastradas_Mai = 0;

        $valor_total_Mai = 0;



        $confirmados_Jun = 0;

        $prestar_contas_Jun = 0;

        $cadastradas_Jun = 0;

        $valor_total_Jun = 0;



        $confirmados_Jul = 0;

        $prestar_contas_Jul = 0;

        $cadastradas_Jul = 0;

        $valor_total_Jul = 0;



        $confirmados_Ago = 0;

        $prestar_contas_Ago = 0;

        $cadastradas_Ago = 0;

        $valor_total_Ago = 0;



        $confirmados_Set = 0;

        $prestar_contas_Set = 0;

        $cadastradas_Set = 0;

        $valor_total_Set = 0;



        $confirmados_Out = 0;

        $prestar_contas_Out = 0;

        $cadastradas_Out = 0;

        $valor_total_Out = 0;



        $confirmados_Nov = 0;

        $prestar_contas_Nov = 0;

        $cadastradas_Nov = 0;

        $valor_total_Nov = 0;



        $confirmados_Dez = 0;

        $prestar_contas_Dez = 0;

        $cadastradas_Dez = 0;

        $valor_total_Dez = 0;



        $valor_total_anual = 0;



        $freqData = array();

        foreach($dados['diarias'] as $key => $info) {

            $mes =  explode('-',$info['data_saida']);   

            $mes = $mes[1];



            

            if($mes == '01') {

                $state = 'Jan';

                if($info['confirmacao'] == 's') {

                    $confirmados_jan += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_jan += 1;

                }



                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_jan  += 1;

                }

                

                $valor_total_jan += (float) $info['valor_total'];

            }



            if($mes == '02') {

                $state = 'Fev';

                if($info['confirmacao'] == 's') {

                    $confirmados_Fev += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Fev += 1;

                }



                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Fev  += 1;

                }



                $valor_total_Fev += (float) $info['valor_total'];

            }



            if($mes == '03') {

                $state = 'Mar';   

                if($info['confirmacao'] == 's') {

                    $confirmados_Mar += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Mar += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Mar  += 1;

                }



                $valor_total_Mar += (float) $info['valor_total'];

            }



            if($mes == '04') {

                $state = 'Abr';   

                if($info['confirmacao'] == 's') {

                    $confirmados_Abr += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Abr += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Abr  += 1;

                }



                $valor_total_Abr += (float) $info['valor_total'];

            }



            if($mes == '05') {

                $state = 'Mai';     

                if($info['confirmacao'] == 's') {

                    $confirmados_Mai += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Mai += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Mai  += 1;

                }



                $valor_total_Mai += (float) $info['valor_total'];

            }



            if($mes == '06') {

                $state = 'Jun';      

                if($info['confirmacao'] == 's') {

                    $confirmados_Jun += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Jun += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Jun  += 1;

                }



                $valor_total_Jun += (float) $info['valor_total'];

            }



            if($mes == '07') {

                $state = 'Jul';   

                if($info['confirmacao'] == 's') {

                    $confirmados_Jul += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Jul += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Jul  += 1;

                }



                $valor_total_Jul += (float) $info['valor_total'];

            }



            if($mes == '08') {

                $state = 'Ago';     

                if($info['confirmacao'] == 's') {

                    $confirmados_Ago += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Ago += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Ago  += 1;

                }



                $valor_total_Ago += (float) $info['valor_total'];

            }



            if($mes == '09') {

                $state = 'Set';       

                if($info['confirmacao'] == 's') {

                    $confirmados_Set += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Set += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Set  += 1;

                }



                $valor_total_Set += (float) $info['valor_total'];

            }



            if($mes == '10') {

                $state = 'Out';     

                if($info['confirmacao'] == 's') {

                    $confirmados_Out += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Out += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Out += 1;

                }



                $valor_total_Out += (float) $info['valor_total'];

            }



            if($mes == '11') {

                $state = 'Nov';    

                if($info['confirmacao'] == 's') {

                    $confirmados_Nov += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Nov += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Nov  += 1;

                }



                $valor_total_Nov += (float) $info['valor_total'];

            }



            if($mes == '12') {

                $state = 'Dez';        

                if($info['confirmacao'] == 's') {

                    $confirmados_Dez += 1;                       

                }

                if($info['confirmacao'] == '0') {

                    $prestar_contas_Dez += 1;

                }

                

                if($info['prestacao_contas'] == '1' || $info['prestacao_contas'] == '0') {

                    $cadastradas_Dez  += 1;

                }



                $valor_total_Dez += (float) $info['valor_total'];

            }            



            $valor_total_anual = $valor_total_jan + $valor_total_Fev + $valor_total_Mar + $valor_total_Abr + $valor_total_Mai + $valor_total_Jun + $valor_total_Jul + $valor_total_Ago + $valor_total_Set + $valor_total_Out + $valor_total_Nov + $valor_total_Dez; 

            if(!in_array($state, $freqData)) {               

                array_push($freqData,  $state);

            }           

        }



        foreach($freqData as $key => $val) {

            if(!in_array('Jan', $freqData)) {               

                $freqData[0] = 'Jan';

            }  

            if(!in_array('Fev', $freqData)) {               

                $freqData[1] = 'Fev';

            }  

            if(!in_array('Mar', $freqData)) {               

                $freqData[2] = 'Mar';

            }  

            if(!in_array('Abr', $freqData)) {               

                $freqData[3] = 'Abr';

            }  

            if(!in_array('Mai', $freqData)) {               

                $freqData[4] = 'Mai';

            }  

            if(!in_array('Jun', $freqData)) {               

                $freqData[5] = 'Jun';

            }  

            if(!in_array('Jul', $freqData)) {               

                $freqData[6] = 'Jul';

            }  

            if(!in_array('Ago', $freqData)) {               

                $freqData[7] = 'Ago';

            }  

            if(!in_array('Set', $freqData)) {               

                $freqData[8] = 'Set';

            }  

            if(!in_array('Out', $freqData)) {               

                $freqData[9] = 'Out';

            }  

            if(!in_array('Nov', $freqData)) {               

                $freqData[10] = 'Nov';

            }  

            if(!in_array('Dez', $freqData)) {               

                $freqData[11] = 'Dez';

            }  

        }

        // $valor_total_jan = str_replace('', '.',  $valor_total_jan );

        // $valor_total_Fev = str_replace('', '.',  $valor_total_Fev );





    //     $valor_total_jan = explode(',', $valor_total_jan);

    //    var_dump($valor_total_jan);

    // echo $this->formato($valor_total_Fev);

        foreach($freqData as $key => $dados_freqData) {

            if($dados_freqData == 'Jan') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' => number_format($valor_total_jan, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_jan, 'Contas_Prestadas' => $confirmados_jan, 'Prestar_Contas' => $prestar_contas_jan]];

            }

        

            if($dados_freqData == 'Fev') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Fev, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Fev, 'Contas_Prestadas' => $confirmados_Fev, 'Prestar_Contas' => $prestar_contas_Fev]];

            }



            if($dados_freqData == 'Mar') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Mar, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Mar, 'Contas_Prestadas' => $confirmados_Mar, 'Prestar_Contas' => $prestar_contas_Mar]];

            }



            if($dados_freqData == 'Abr') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Abr, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Abr, 'Contas_Prestadas' => $confirmados_Abr, 'Prestar_Contas' => $prestar_contas_Abr]];

            }



            if($dados_freqData == 'Mai') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Mai, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Mai, 'Contas_Prestadas' => $confirmados_Mai, 'Prestar_Contas' => $prestar_contas_Mai]];

            }



            if($dados_freqData == 'Jun') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Jun, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Jun, 'Contas_Prestadas' => $confirmados_Jun, 'Prestar_Contas' => $prestar_contas_Jun]];

            }



            if($dados_freqData == 'Jul') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Jul, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Jul, 'Contas_Prestadas' => $confirmados_Jul, 'Prestar_Contas' => $prestar_contas_Jul]];

            }



            if($dados_freqData == 'Ago') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Ago, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Ago, 'Contas_Prestadas' => $confirmados_Ago, 'Prestar_Contas' => $prestar_contas_Ago]];

            }



            if($dados_freqData == 'Set') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Set, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Set, 'Contas_Prestadas' => $confirmados_Set, 'Prestar_Contas' => $prestar_contas_Set]];

            }



            if($dados_freqData == 'Out') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Out, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Out, 'Contas_Prestadas' => $confirmados_Out, 'Prestar_Contas' => $prestar_contas_Out]];

            }



            if($dados_freqData == 'Nov') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Nov, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Nov, 'Contas_Prestadas' => $confirmados_Nov, 'Prestar_Contas' => $prestar_contas_Nov]];

            }



            if($dados_freqData == 'Dez') {

                $freqData[$key] = ['State' => $dados_freqData, 'valor_anual' => $valor_total_anual, 'valor_total' =>  number_format($valor_total_Dez, '2', ',', ''), 'freq' => ['Cadastradas' => $cadastradas_Dez, 'Contas_Prestadas' => $confirmados_Dez, 'Prestar_Contas' => $prestar_contas_Dez]];

            }

           

            

        }



        $ano_option= [];

        for ($i=0; $i < 50 ; $i++) { 

            if($i == 0) {

                $ano = 2018;

            }else{

                $ano = $ano + 1;

            }



            if(!in_array($ano, $ano_option)) {               

                $ano_option[$ano] =  $ano;

            } 



            if($ano == Date('Y')) {

                break;

            }

        }

            

        // $viewName = 'Dashboard/dashboard';

        $dados['freqData'] = $freqData;

        $dados['tabela'] = $table;



        $dados['viewName'] = 'Dashboard/dashboard';

        $this->load->view('index', $dados); 

    

    }



    public function formato_valor($num) {      
        
        if($num != 0) {
            $val = explode('.', $num);
            $separador = explode('.', $num);
         
            if(strlen( $separador[0]) > 3) {
                if(strlen( $separador[0]) == 4 ) {
                    $milhares  = $separador[0][0] . '.';
                    $centenas =  $separador[0][1] . $separador[0][2] . $separador[0][3] . ',';
                }elseif(strlen( $separador[0]) == 5){
                    $milhares  = $separador[0][0] .  $separador[0][1] . '.' ; 
                    $centenas =  $separador[0][2] . $separador[0][3] . $separador[0][4] . ',';
                }elseif(strlen( $separador[0]) == 6){
                    $milhares  = $separador[0][0] .  $separador[0][1] .  $separador[0][2] . '.' ; 
                    $centenas =  $separador[0][3] . $separador[0][4] . $separador[0][5] . ',';
                }elseif(strlen( $separador[0]) == 7){
                    $milhares  = $separador[0][0] . '.' .  $separador[0][1] .  $separador[0][2] . $separador[0][3] . '.' ; 
                    $centenas =  $separador[0][4] . $separador[0][5] . $separador[0][6] . ',';            }
            }else{
                if(strlen( $separador[0]) == 3) {
                    $milhares = '';
                    $centenas = $separador[0][0] .  $separador[0][1] .  $separador[0][2] . ',';
                }else{

                }
            }
    
            if(!empty($separador[1])) {
                $valor_retorno =  $milhares . $centenas . ((strlen($separador[1]) == 1) ? $separador[1]. '0': $separador[1]);
            }else{
                $valor_retorno =  number_format($num, '2', ',', '.');
            }
    
            return $valor_retorno;
        }else{
            return '0,00';
        }

        // // $valor_retorno = '';

        // if(strlen($val[0]) == 3) {

        //     $valor_retorno = $val[0].','.$val[1];

        // }



        // if(strlen($val[0]) == 4) {

        //     $val[0] = $val[0][0]. '.'.$val[0][1].$val[0][2].$val[0][3];

        //     $valor_retorno = $val[0].','.$val[1];

        // }



        // if(strlen($val[0]) == 5) {

        //     $val[0] = $val[0][0]. $val[0][1].'.'.$val[0][2].$val[0][3].$val[0][4];

        //     $valor_retorno = $val[0].','.$val[1];

        // }



        // if(strlen($val[0]) == 6) {

        //     $val[0] = $val[0][0]. $val[0][1].$val[0][2].'.'.$val[0][3].$val[0][4].$val[0][5];

        //     $valor_retorno = $val[0].','.$val[1];

        // }


    }



    public function relatorio($table, $id_secretaria,  $exercicio = null, $servidor = null, $mesInit = null, $mesFim = null) {

        // $this->load->library('Sendmail');

        $this->load->library('tcpdf/tcpdf');      

        $id = 'id_'.$table;

        $dados['id_diaria'] = str_replace('s', '', $id);

        if($servidor == 'none') {
            $servidor = null;
        }

        $dados['relatorio'] = $this->Dashboard->dados_diaria($table, $id_secretaria, $servidor, $exercicio, $mesInit, $mesFim);

        $val = 0;
        $cont = 0;

        foreach( $dados['relatorio'] as $info) {

            $val = $val + $info['valor_total'];

            $cont ++;

        }

        $dados['contador_registro'] =  $cont;

        if($mesInit != '') {
            $mesRelatorio = explode('-', $mesInit);
            $dados['periodo'] = ucwords($this->formataMes($mesRelatorio[1])) . ' de ' . $mesRelatorio[0];
        }else{
            $dados['periodo'] = 'Janeiro a Dezembro de ' . $exercicio;
        }

        $this->load->view('Dashboard/PdfRelatorio', $dados);    
    }

    public function dump($ret) {
        echo '<pre>';
        var_dump($ret);
        die;
    }


    public function formataMes($mes) {

        switch($mes) {

            case '01':
                $mes = 'Janeiro';
                break;
            case '02':
                $mes = 'Fevereiro';
                break;
            case '03':
                $mes = 'Março';
                break;
            case '04':
                $mes = 'Abril';
                break;
            case '05':
                $mes = 'Maio';
                break;
            case '06':
                $mes = 'Jonho';
                break;
            case '07':
                $mes = 'Julho';
                break;
            case '08':
                $mes = 'Agosto';
                break;
            case '09':
                $mes = 'Setembro';
                break;
            case '10':
                $mes = 'Outubro';
                break;
            case '11':
                $mes = 'Novembro';
                break;
            case '12':
                $mes = 'Dezembro';
                break;
        }
        return $mes;
    }



}