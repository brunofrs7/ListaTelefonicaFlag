<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

//check warning
$warning = $_SESSION['warning'] ?? null;
unset($_SESSION['warning']);
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">Sign in</h3>
        <hr>
        <form action="?p=signin_submit" method="post">
            <div class="mb-3">
                <label for="text_email" class="form-label">Email:</label>
                <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert your email" required>
            </div>
            <div class="mb-3">
                <label for="text_password" class="form-label">Password:</label>
                <input type="password" name="text_password" id="text_password" class="form-control" placeholder="Insert your password" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Sign in</button>
            </div>
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($warning)) : ?>
                <div class="alert alert-warning mt-3 p-2 text-center" role="alert">
                    <?= $warning ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>