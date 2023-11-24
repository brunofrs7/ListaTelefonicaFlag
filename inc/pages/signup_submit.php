<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$email = $_POST['text_email'] ?? null;
$name = $_POST['text_name'] ?? null;
$password = $_POST['text_password'] ?? null;
$password2 = $_POST['text_password2'] ?? null;

if (empty($email) || empty($name) || empty($password) || empty($password2)) {
    $_SESSION['error'] = 'Please fill all fields';
    header('Location: ?p=signup');
    exit;
}

if ($password != $password2) {
    $_SESSION['error'] = "Passwords don't match";
    header('Location: ?p=signup');
    exit;
}

$new_link_valid = false;
$email_link = "";
$db = new database();

while(!$new_link_valid){
    $email_link = functions::generateLink();
    $new_link_valid = $db->validateSignupLinkExists($email_link);
}

$email_link = functions::generateLink();

$db = new database();
$res = $db->signup($email, $name, $password, $email_link);

if ($res['status'] == 'error') {
    $_SESSION['error'] = "Error signing up";
    header('Location: ?p=signup');
    exit();
}

//SEND MAIL
$text_to_name = $name;
$text_to_address = $email;
$text_from_name = "Contacts APP";
$text_from_address = "listacontactos573@gmail.com";
$text_subject = "Activate account";
//$text_message = "Click <a href=\"http://localhost/ListaTelefonicaFlag/public/?p=validate&email_link=$email_link\">here</a> to activate your account";
$text_message = 'Click <a href="http://localhost/ListaTelefonicaFlag/public/?p=validate&email_link=' . $email_link . '">here</a> to activate your account';

require_once('../inc/utils/sendMail.php');

if ($res_email == true) {
    $_SESSION['warning'] = 'Verify your email to activate your account';
    header('Location: ?p=signin');
} else {
    $_SESSION['error'] = "Error signing up";
    header('Location: ?p=signup');
}
