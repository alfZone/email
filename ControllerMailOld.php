<?php

/**
 * @autores alf
 * @copyright 2026
 * @ver 1.1
 */


namespace app;
use src\Connection;
use PDO;


class ControllerMail {

    private $conn;
    private $database;
    private $emissor = "remetente@exemplo.com";
    private $noReplay = "nao-responder@exemplo.com";
    private $sendOk="Email enviado com sucesso!";
    private $sendFail="Falha ao enviar email.";

    public function __construct() {
        $this->database = new Connection();
        $this->conn = $this->database->getConnection();
    }

    //public function sendMail($to, $subject, $message) {
    public function getMail() {
        // Configurações do servidor SMTP
        $para= $_REQUEST['email'];
        $assunto= $_REQUEST['assunto'];
        $mensagem= $_REQUEST['mensagem'];
        //$para = "alf@esmonserrate.org";
        //$assunto = "Assunto do Email";
        //$mensagem = "Olá! Este é um email de teste.";
        $this->sendMail($para, $assunto, $mensagem);
    }

    //public function sendMail($to, $subject, $message) {
    public function sendMail($para, $assunto, $mensagem ) {
        // Configurações do servidor SMTP
        //$para = "alf@esmonserrate.org";
        //$assunto = "Assunto do Email";
        //$mensagem = "Olá! Este é um email de teste.";
        $cabecalhos = "From: " . $this->emissor . "\r\n";
        $cabecalhos .= "Reply-To: " . $this->noReplay . "\r\n";
        $cabecalhos .= "X-Mailer: PHP/" . phpversion();

        if(mail($para, $assunto, $mensagem, $cabecalhos)) {
            echo $this->sendOk;
        } else {
            echo $this->sendFail;
        }
    }

    public function setSender($email) {
        $this->emissor = $email;
    }   

    public function setNoReply($email) {
        $this->noReplay = $email;
    }
    
    public function getMensageSendOK() {
        return $this->sendOk;
    }
    
    public function getMensageSendFail() {
        return $this->sendFail;
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function __toString() {
        return "ControllerMail: Emissor={$this->emissor}, NoReply={$this->noReplay}";
    }   

    public function formHTML(){
        return '
        <form method="post" action="' . route("email.simple") . '">
            <label for="email">Email do destinatário:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="assunto">Assunto:</label><br>
            <input type="text" id="assunto" name="assunto" required><br>
            <label for="mensagem">Mensagem:</label><br>
            <textarea id="mensagem" name="mensagem" required></textarea><br>
            <input type="submit" value="Enviar Email">
        </form>';   
    }
}
?>
