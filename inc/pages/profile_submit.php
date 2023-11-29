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
$name = $_POST['text_profile_name'] ?? null;
$email = $_POST['text_profile_email'] ?? null;

if (empty($id) || empty($name) || empty($email)) {
    $_SESSION['error'] = 'Please insert all fields';
    header("Location: ?p=profile");
    exit;
}

$db = new database();
$res = $db->updateUser($id, $name, $email);
functions::logger('User Profile data updated', 'info', ['user_id' => $id]);

if ($res['affectedRows'] == 1) {
    $_SESSION['success'] = 'Success editing contact';
    header('Location: ?p=profile');
} else {
    $_SESSION['error'] = 'Error editing contact';
    header("Location: ?p=profile");
}
