<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$id = $_SESSION['id'] ?? null;
$password = $_POST['text_password'] ?? null;
$password2 = $_POST['text_password2'] ?? null;

if (empty($id) || empty($password) || empty($password2)) {
    $_SESSION['error'] = 'Please insert all fields';
    header("Location: ?p=profile");
    exit;
}
if ($password != $password2) {
    $_SESSION['error'] = "Password won't match";
    header("Location: ?p=profile");
    exit;
}

$db = new database();
$res = $db->updatePasswordUser($id, $password);

if ($res['affectedRows'] == 1) {
    $_SESSION['success'] = 'Success editing contact';
    header('Location: ?p=profile');
} else {
    $_SESSION['error'] = 'Error editing contact';
    header("Location: ?p=profile");
}
