<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = null;

$email_link = $_GET['email_link'] ?? null;

if (empty($email_link)) {
    header('Location: ?p=404');
    exit;
}

$db = new database();
$res = $db->validate($email_link);

if ($res['affectedRows'] == 0) {
    $error = 'Invalid link';
} else {
    $_SESSION['warning'] = 'Account successfully validated, please signin';
    header('Location: ?p=signin');
    exit;
}
?>
<?php if (!empty($error)) : ?>
    <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>