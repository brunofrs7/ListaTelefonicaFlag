<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$id = $_SESSION['id'] ?? null;

if (empty($id)) {
    $_SESSION['error'] = 'Invalid ID, try again';
    header("Location: ?p=profile");
    exit;
}

$db = new database();
//$res = $db->deleteUser($id);
$res = $db->softDeleteUser($id);

// delete image
functions::removeImage($id, "user");

if ($res['affectedRows'] == 1) {
    header('Location: ?p=logout');
} else {
    $_SESSION['error'] = 'Error deleting contact';
    header("Location: ?p=profile");
}
