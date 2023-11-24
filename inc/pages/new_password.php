<?php
//validate access
defined('CONTROL') or die('Access denied');

$email_recover = $_GET['email_recover'] ?? null;
if (empty($email_recover)) {
    header('Location: ?p=404');
    exit;
}

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

//check warning
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">Recover password</h3>
        <hr>
        <form action="?p=new_password_submit" method="post">
            <input type="hidden" name="text_email_recover" value="<?= $email_recover ?>">
            <div class="mb-3">
                <label for="text_password" class="form-label">New Password:</label>
                <input type="password" name="text_password" id="text_password" class="form-control" placeholder="Insert your new password" required>
            </div>
            <div class="mb-3">
                <label for="text_password2" class="form-label">Confirm you new password:</label>
                <input type="password" name="text_password2" id="text_password2" class="form-control" placeholder="Insert your new password" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Recover password</button>
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

        </form>
    </div>
</div>