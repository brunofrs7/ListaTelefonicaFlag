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
$password = $_POST['text_password'] ?? null;

if(empty($email) || empty($password)){
    $_SESSION['error'] = 'Please insert both fields';
    header('Location: ?p=signin');
    exit;
}

$db = new database();
$res = $db->signin($email, $password);

if($res['status'] == 'success'){
    header('Location: ?p=contacts');
}else{
    header('Location: ?p=signin');
}


