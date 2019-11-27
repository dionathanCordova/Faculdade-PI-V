<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sendmail {
    // Adiciona o arquivo class.phpmailer.php - você deve especificar corretamente o caminho da pasta com o este arquivo.
    
    public function __construct() {
        require_once("phpmailer/PHPMailerAutoload.php");
        // Inicia a classe PHPMailer
        $mail = new PHPMailer();
            
        // DEFINIÇÃO DOS DADOS DE AUTENTICAÇÃO - Você deve auterar conforme o seu domínio!
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host ='smtp.gmail.com';// Seu endereço de host SMTP
        $mail->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
        $mail->Port = 587; // Porta de comunicação SMTP - Mantenha o valor "587"
        // $mail->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
        $mail->SMTPSecure = 'tls';  
        $mail->SMTPAutoTLS = false; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
        $mail->Username = 'defaltern@gmail.com'; // Conta de email existente e ativa em seu domínio
        $mail->Password = 'fodassegmail@'; // Senha da sua conta de email
        
        // DADOS DO REMETENTE
        $mail->Sender = "defaltern@gmail.com"; // Conta de email existente e ativa em seu domínio
        $mail->From = "defaltern@gmail.com"; // Sua conta de email que será remetente da mensagem
        $mail->FromName = "Desafio Mega"; // Nome da conta de email
        
        // DADOS DO DESTINATÁRIO
        $mail->AddAddress($_POST['email'], 'Nome - Recebe1'); // Define qual conta de email receberá a mensagem
        //$mail->AddAddress('recebe2@dominio.com.br'); // Define qual conta de email receberá a mensagem
        // $mail->AddCC(''); // Define qual conta de email receberá uma cópia
        //$mail->AddBCC('copiaoculta@dominio.info'); // Define qual conta de email receberá uma cópia oculta
        
        // Definição de HTML/codificação
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
        
        // DEFINIÇÃO DA MENSAGEM
        // if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['mensagem'])) {
        $mail->Subject  = "Formulário de Contato"; // Assunto da mensagem
        $mail->Body .= " Olá, <br>recebemos o pedido de redefinição de senha do seguinte email<br>"; // Texto da mensagem
        $mail->Body .= " E-mail: ". $_POST['email']."<br><br>"; // Texto da mensagem
        $mail->Body .= " Para efetuar o login, segue logo abaixo uma chave de acesso. <br><br> Acesse o endereço: <strong>". base_url('').'welcome/index' ."</strong><br>"; // Texto da mensagem
        $mail->Body .= " Chave para Acesso: <br>"; // Texto da mensagem
        $mail->Body .= ' <br>Caso o pedido não tenha pedido a redefinição de senha, pedimos que entre em contato Suporte da MegaWeb. <br><br>Obrigado.';
    

        // ENVIO DO EMAIL
        $enviado = $mail->Send();
        // Limpa os destinatários e os anexos
            
        $mail->ClearAllRecipients();
        
        // Exibe uma mensagem de resultado do envio (sucesso/erro)
        if ($enviado) {
            $_SESSION['enviado'] = 'E-mail enviado com sucesso. Aguarde contato.';
            $dados['email_enviado'] = 'E-mail enviado com sucesso. Aguarde contato.';
            
        } else {
            $_SESSION['enviado'] = 'Erro ao enviar o email. Favor enviar um e-mail para xxx@xxx.com.br';
            $dados['email_enviado'] = 'Erro ao enviar o email. Favor enviar um e-mail para xxx@xxx.com.br';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        // echo "<b>Detalhes do erro:</b> " . $mail->ErrorInfo;
        }
      
    }
}