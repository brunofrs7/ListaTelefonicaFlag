<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

//check success
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

$id = $_SESSION['id'] ?? null;

if (empty($id)) {
    header('Location: ?p=404');
    exit;
}

$db = new database();
$res = $db->selectUserByID($id);

$profile = $res['data'][0];
?>
<div class="row">
    <div class="col">
        <h1>Profile</h1>
    </div>
</div>
<div class="row mb-3">
    <div class="col text-center">
        <?php if ($profile->photo != null) : ?>
            <img class="w-50 m-1" src="../inc/img/users/<?= $profile->photo ?>" alt="">
            <a href="?p=remove_user_image_submit" class="btn btn-danger my-2">Remove image</a>
        <?php else : ?>
            <img class="w-50 m-1" src="../inc/img/default.png" alt="">
        <?php endif; ?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalImage">Upload image</button>
    </div>
    <div class="col">
        <form action="?p=profile_submit" method="post">
            <div class="mb-3">
                <label for="text_profile_name" class="form-label">Name:</label>
                <input type="text" name="text_profile_name" id="text_profile_name" class="form-control" placeholder="Insert your name" value="<?= $profile->name ?>" required readonly>
            </div>
            <div class="mb-3">
                <label for="text_profile_email" class="form-label">Email:</label>
                <input type="email" name="text_profile_email" id="text_profile_email" class="form-control" placeholder="Insert your email" value="<?= $profile->email ?>" required readonly>
            </div>
            <div class="mb-3" id="div_profile_edit">
                <button type="button" class="btn btn-primary" onclick="showEdit()">Edit</button>
            </div>
            <div class="mb-3" id="div_profile_save_cancel">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="?p=profile" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col text-center">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPassword">Change password</button>
    </div>
    <div class="col text-center">
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">Delete account</button>
    </div>
</div>
<?php if (!empty($error)) : ?>
    <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<?php if (!empty($success)) : ?>
    <div class="alert alert-success mt-3 p-2 text-center" role="alert">
        <?= $success ?>
    </div>
<?php endif; ?>

<?php
require('profile_change_image_modal.php');
require('profile_change_password_modal.php');
require('profile_delete_account_modal.php');
