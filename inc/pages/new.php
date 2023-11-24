<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">New Contact</h3>
        <hr>
        <form action="?p=new_submit" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="text_name" class="form-label">Name:</label>
                <input type="text" name="text_name" id="text_name" class="form-control" placeholder="Insert contact name" required>
            </div>
            <div class="mb-3">
                <label for="text_phone" class="form-label">Phone:</label>
                <input type="phone" name="text_phone" id="text_phone" class="form-control" placeholder="Insert contact phone" required>
            </div>
            <div class="mb-3">
                <label for="text_email" class="form-label">Email:</label>
                <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert contact email" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo:</label>
                <input type="file" name="photo" id="photo" class="form-control">
                <div class="form-text text-white opacity-50">Image up to 5MB (jpg, png, jpeg, gif)</div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Save</button>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
