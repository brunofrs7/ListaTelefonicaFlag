<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

// get user_id from SESSION
$user_id = $_SESSION['id'] ?? null;

if (empty($user_id)) {
    header('Location: ?p=404');
    exit();
}
?>

<!-- Modal -->
<div class="modal fade" id="delete-contact-modal<?= $contact->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Delete contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark">Are you sure you want to delete <?= $contact->name ?> contact?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle me-2"></i>No</button>
                <a class="btn btn-outline-dark" href="?p=delete_submit&id=<?= $contact->id ?>"><i class="bi bi-check-circle me-2"></i>YES</a>
            </div>
        </div>
    </div>
</div>