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

if(empty($email) || empty($name) || empty($password) || empty($password2)){
    $_SESSION['error'] = 'Please fill all fields';
    header('Location: ?p=signup');
    exit;
}

if($password != $password2){
    $_SESSION['error'] = "Passwords don't match";
    header('Location: ?p=signup');
    exit;
}

$db = new database();
$res = $db->signup($email, $name, $password);

if($res['status'] == 'success'){
    $_SESSION['warning'] = 'Verify your email to activate your account';
    header('Location: ?p=signin');
}else{
    $_SESSION['error'] = "Error signing up";
    header('Location: ?p=signup');
}




