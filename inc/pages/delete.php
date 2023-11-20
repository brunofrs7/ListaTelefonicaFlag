<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

// contact_id of selected contact
$id = $_GET['id'] ?? null;

if (empty($id)) {
    header('Location: ?p=404');
    exit();
}

// get user_id from SESSION
$user_id = $_SESSION['id'] ?? null;

if (empty($user_id)) {
    header('Location: ?p=404');
    exit();
}
?>
<div class="row text-center">
    <h2>Delete contact</h2>
    <p>Are you sure you want to delete this contact?</p>
</div>
<div class="row">
    <div class="col text-center"><a class="btn btn-outline-dark" href="?p=delete_submit&id=<?=$id?>"><i class="bi bi-check-circle me-2"></i>YES</a></div>
    <div class="col text-center"><a class="btn btn-outline-danger" href="?p=contacts"><i class="bi bi-x-circle me-2"></i>NO</a></div>
</div>
<?php if (!empty($error)) : ?>
    <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>