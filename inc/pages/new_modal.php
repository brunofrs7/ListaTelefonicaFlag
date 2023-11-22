<?php
//validate access
defined('CONTROL') or die('Access denied');
?>
<!-- Modal -->
<div class="modal fade" id="new-contact-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New Contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?p=new_submit" method="post">
                <div class="modal-body text-start">
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
                    <div>
                        <label for="photo" class="form-label">Photo:</label>
                        <input type="file" name="photo" id="photo" class="form-control">
                        <div class="form-text text-white opacity-50">Image up to 5MB (jpg, png, jpeg, gif)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>            <?php
            $error = $_SESSION['error'] ?? null;
            unset($_SESSION['error']);
            
            
            if (!empty($error)) : ?>
                <div class="alert alert-danger mt-3 p-2 text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>