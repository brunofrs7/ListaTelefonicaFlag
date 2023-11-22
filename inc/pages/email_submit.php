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
$user_id = $_SESSION['id'] ?? null;

if(empty($user_id)){
    header("Location: ?p=404");
    exit;
}

$db = new database();
$res = $db->selectUserByID($user_id);

$text_from_name = $res['data'][0]->name;
$text_from_address = $res['data'][0]->email;

require_once('../inc/utils/sendMail.php');

if ($res == true) {
    $_SESSION['success'] = "Message successfully sended";
} else {
    $_SESSION['error'] = "Error sending messagem";
}
header("Location: ?p=email&id=$text_id");

