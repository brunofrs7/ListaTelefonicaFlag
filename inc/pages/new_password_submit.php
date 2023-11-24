<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$text_email_recover = $_POST['text_email_recover'] ?? null;
$text_password = $_POST['text_password'] ?? null;
$text_password2 = $_POST['text_password2'] ?? null;

if (empty($text_email_recover) || empty($text_password) || empty($text_password2)) {
    $_SESSION['error'] = 'Invalid parameters, try again';
    header("Location: ?p=new_password&email_recover=$text_email_recover");
    exit;
}

if ($text_password != $text_password2) {
    $_SESSION['error'] = "Passwords won't match, try again";
    header("Location: ?p=new_password&email_recover=$text_email_recover");
    exit;
}

$db = new database();
$recover_link_exists = $db->recoverLinkExists($text_email_recover);

if (!$recover_link_exists) {
    //$_SESSION['success'] = "Check your email to recover password";
    $_SESSION['error'] = "Link not exists";
    header("Location: ?p=new_password&email_recover=$text_email_recover");
    exit;
}

$res = $db->updatePassword($text_email_recover, $text_password);

if ($res['status'] == 'error') {
    $_SESSION['error'] = "Error setting new password";
    header("Location: ?p=new_password&email_recover=$text_email_recover");
} else {
    $_SESSION['warning'] = "Password changed, please signin";
    header('Location: ?p=signin');
}
