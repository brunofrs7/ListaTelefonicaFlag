<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$text_id = $_POST['text_id'] ?? null;
$text_to_name = $_POST['text_to_name'] ?? null;
$text_to_address = $_POST['text_to_address'] ?? null;
$text_subject = $_POST['text_subject'] ?? null;
$text_message = $_POST['text_message'] ?? null;

if (empty($text_to_name) || empty($text_to_address) || empty($text_subject) || empty($text_message)) {
    $_SESSION['error'] = 'Invalid parameters, try again';
    header("Location: ?p=email&id=$text_id");
    exit;
}

// envio do email
// dados de envio: 
// remetente:    NOME E EMAIL DO UTILIZADOR DA SESSÃO           - FALTA!!
// destinatário: NOME E EMAIL DO CONTACTO PASSADO POR POST 
// assunto: passado por POST
// mensagem: passada por POST

$res = false;   // substituir por envio de email com info de resultado 

if ($res == true) {
    $_SESSION['success'] = "Message successfully sended";
} else {
    $_SESSION['error'] = "Error sending messagem";
}
header("Location: ?p=email&id=$text_id");

