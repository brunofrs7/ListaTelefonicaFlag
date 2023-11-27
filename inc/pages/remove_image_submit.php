<?php
//validate access
defined('CONTROL') or die('Access denied');

$id = $_GET['id'] ?? null;

$user_id = $_SESSION['id'] ?? null;

if (empty($id) || empty($user_id)) {
    header('Location: ?p=404');
    exit;
}

$db = new database();
$db->updateContactRemovePhoto($id, $user_id);
functions::removeImage($id);

header("Location: ?p=edit&id=$id");