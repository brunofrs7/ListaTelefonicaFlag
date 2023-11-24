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

$db = new database();
$email_exists = $db->userEmailExists($text_to_address);

if(!$email_exists){
    //$_SESSION['success'] = "Check your email to recover password";
    $_SESSION['error'] = "Email not exists in APP";
    header("Location: ?p=recover_password");
    exit;
}

$new_link_valid = false;
$email_recover = "";

while(!$new_link_valid){
    $email_recover = functions::generateLink();
    $new_link_valid = $db->validateRecoverLinkExists($email_recover);
}

$res = $db->generateRecoverPasswordLink($text_to_address, $email_recover);

if ($res['status'] == 'error') {
    $_SESSION['error'] = "Error signing up";
    header('Location: ?p=recover_password');
    exit();
}

$text_from_name = "Contacts APP";
$text_from_address = "listacontactos573@gmail.com";
$text_subject = "Contacts APP - Recover password";
$text_message = 'Click <a href="http://localhost/ListaTelefonicaFlag/public/?p=new_password&email_recover=' . $email_recover . '">here</a> to set a new password for your account';


require_once('../inc/utils/sendMail.php');

$_SESSION['success'] = "Check your email to recover password";
header("Location: ?p=recover_password");

