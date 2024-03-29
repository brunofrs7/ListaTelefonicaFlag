<?php
//validate access
defined('CONTROL') or die('Access denied');

// validate access method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?p=404');
    exit;
}

// save POST data
$id = $_POST['text_id'] ?? null;
$name = $_POST['text_name'] ?? null;
$phone = $_POST['text_phone'] ?? null;
$email = $_POST['text_email'] ?? null;
$photo = $_FILES['photo'] ?? null;
$user_id = $_SESSION['id'] ?? null;

if (empty($id) || empty($name) || empty($phone) || empty($email) || empty($user_id)) {
    $_SESSION['error'] = 'Please insert all fields';
    header("Location: ?p=edit&id=$id");
    exit;
}

$db = new database();

if ($photo['size'] > 0) {
    $photo_id = $id . ".png";
    $res = $db->updateContact($id, $name, $phone, $email, $user_id, $photo_id);

    if ($res['affectedRows'] == 1) {

        // upload new photo
        $resUpload = functions::uploadImage($id, $photo);

        if ($resUpload['status'] == 'error') {
            $_SESSION['error'] = $resUpload['message'];
            header("Location: ?p=edit&id=$id");
            exit();
        } else {
            header('Location: ?p=contacts');
        }
    } else {
        $_SESSION['error'] = 'Error editing contact';
        header("Location: ?p=edit&id=$id");
    }
} else {
    $res = $db->updateContact($id, $name, $phone, $email, $user_id);

    if ($res['affectedRows'] == 1) {
        header('Location: ?p=contacts');
    } else {
        $_SESSION['error'] = 'Error editing contact';
        header("Location: ?p=edit&id=$id");
    }
}
