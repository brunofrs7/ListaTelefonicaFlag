<?php
//validate access
defined('CONTROL') or die('Access denied');

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
        <form action="?p=recover_password_submit" method="post">
            <div class="mb-3">
                <label for="text_email" class="form-label">Email:</label>
                <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert your email" required>
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