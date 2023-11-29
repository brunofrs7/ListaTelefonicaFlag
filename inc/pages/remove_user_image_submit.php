<?php
//validate access
defined('CONTROL') or die('Access denied');

$id = $_SESSION['id'] ?? null;

if (empty($id)) {
    header('Location: ?p=404');
    exit;
}

$db = new database();
$db->updateUserRemovePhoto($id);
functions::removeImage($id, "users");

header("Location: ?p=profile");
