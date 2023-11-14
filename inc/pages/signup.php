<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">Sign up</h3>
        <hr>
        <form action="?p=signup_submit" method="post">
            <div class="mb-3">
                <label for="text_email" class="form-label">Email:</label>
                <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert your email" required>
            </div>
            <div class="mb-3">
                <label for="text_name" class="form-label">Name:</label>
                <input type="text" name="text_name" id="text_name" class="form-control" placeholder="Insert your name" required>
            </div>
            <div class="mb-3">
                <label for="text_password" class="form-label">Password:</label>
                <input type="password" name="text_password" id="text_password" class="form-control" placeholder="Insert your password" required>
            </div>
            <div class="mb-3">
                <label for="text_password2" class="form-label">Confirm Password:</label>
                <input type="password" name="text_password2" id="text_password2" class="form-control" placeholder="Repeat your password" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Sign up</button>
            </div>
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>