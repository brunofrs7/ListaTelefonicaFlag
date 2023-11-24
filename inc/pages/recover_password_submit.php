<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$text_to_address = $_POST['text_email'] ?? null;

if (empty($text_to_address)) {
    $_SESSION['error'] = 'Invalid parameters, try again';
    header("Location: ?p=recover_password");
    exit;
}


$new_link_valid = false;
$email_recover = "";
$db = new database();

while(!$new_link_valid){
    $email_recover = functions::generateLink();
    $new_link_valid = $db->validateRecoverLinkExists($email_recover);
}

$res = $db->generateRecoverPasswordLink($email, $email_recover);


$text_from_name = "Contacts APP";
$text_from_address = "listacontactos573@gmail.com";
$text_subject = "Contacts APP - Recover password";
$text_message = 'Click <a href="http://localhost/ListaTelefonicaFlag/public/?p=new_password&email_recover=' . $email_recover . '">here</a> to set a new password for your account';


require_once('../inc/utils/sendMail.php');

if ($res_email == true) {
    $_SESSION['success'] = "Message successfully sended";
} else {
    $_SESSION['error'] = "Error sending messagem";
}
header("Location: ?p=email&id=$text_id");

