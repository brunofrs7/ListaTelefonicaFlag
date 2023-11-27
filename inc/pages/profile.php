<?php
//validate access
defined('CONTROL') or die('Access denied');

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
<div class="row">
    <div class="col text-center">
        <?php if ($profile->photo != null) : ?>
            <img class="w-50 m-1" src="../inc/img/user/<?= $profile->photo ?>" alt="">
            <a href="" class="btn btn-danger my-2">Remove image</a>
        <?php else : ?>
            <img class="w-50 m-1" src="../inc/img/default.png" alt="">
        <?php endif; ?>
        <a href="" class="btn btn-primary">Upload image</a>
    </div>
    <div class="col">
        <div class="mb-3">
            <label for="text_name" class="form-label">Name:</label>
            <input type="text" name="text_name" id="text_name" class="form-control" placeholder="Insert your name" value="<?= $profile->name ?>" required readonly>
        </div>
        <div class="mb-3">
            <label for="text_email" class="form-label">Email:</label>
            <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert your email" value="<?= $profile->email ?>" required readonly>
        </div>
    </div>
</div>