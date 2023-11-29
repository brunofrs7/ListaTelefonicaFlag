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
$photo = $_FILES['photo'] ?? null;

if (empty($id)) {
    $_SESSION['error'] = 'Please insert all fields';
    header("Location: ?p=profile");
    exit;
}


$db = new database();

if ($photo['size'] > 0) {
    $res = $db->updateImageUser($id);
    if ($res['affectedRows'] == 1) {

        // upload new photo
        $resUpload = functions::uploadImage($id, $photo, "users");

        if ($resUpload['status'] == 'error') {
            $_SESSION['error'] = $resUpload['message'];
            header("Location: ?p=profile");
            exit();
        } else {
            $_SESSION['success'] = 'Image successfully changed';
            header('Location: ?p=profile');
        }
    } else {
        $_SESSION['error'] = 'Error editing user';
        header("Location: ?p=profile");
    }
} else {
    $_SESSION['error'] = 'Invalid image';
    header("Location: ?p=profile");
}
