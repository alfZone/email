<?php
use app\ControllerMail;


$controller = new ControllerMail();
$controller->sendMail("alf246@gmail.com", "Teste de email", "o corpo está funcionando");


?>
