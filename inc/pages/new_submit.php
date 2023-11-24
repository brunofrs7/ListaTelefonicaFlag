<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$name = $_POST['text_name'] ?? null;
$phone = $_POST['text_phone'] ?? null;
$email = $_POST['text_email'] ?? null;
$photo = $_FILES["photo"];

$user_id = $_SESSION['id'] ?? null;

if (empty($name) || empty($phone) || empty($email) || empty($user_id)) {
    $_SESSION['error'] = 'Please insert all fields';
    header('Location: ?p=new');
    exit;
}

$db = new database();
$res = $db->insertContact($name, $phone, $email, $user_id);
$new_contact_id = $res['lastID'];

//upload da foto
$resUpload = functions::uploadImage($new_contact_id, $photo);

if ($resUpload['status'] == 'error') {
    $_SESSION['error'] = $resUpload['message'];
    header('Location: ?p=new');
    exit();
}

$resPhoto = $db->insertPhoto($new_contact_id);

if ($res['status'] == 'success' && $resPhoto['status'] == 'success') {
    header('Location: ?p=contacts');
} else {
    $_SESSION['error'] = 'Error creating new contact';
    header('Location: ?p=new');
}
