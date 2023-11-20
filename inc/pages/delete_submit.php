<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$id = $_GET['id'] ?? null;
$user_id = $_SESSION['id'] ?? null;

if (empty($id) || empty($user_id)) {
    $_SESSION['error'] = 'Invalid ID, try again';
    header("Location: ?p=delete&id=$id");
    exit;
}

$db = new database();
//$res = $db->deleteContact($id, $user_id);
$res = $db->softDeleteContact($id, $user_id);

if ($res['affectedRows'] == 1) {
    header('Location: ?p=contacts');
} else {
    $_SESSION['error'] = 'Error deleting contact';
    header("Location: ?p=delete&id=$id");
}
