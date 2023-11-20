<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

//check errors
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

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

$db = new database();
$result = $db->selectContactByID($id, $user_id);

if (empty($result) || $result['status'] == 'error' || count($result['data']) != 1) {
    header('Location: ?p=404');
    exit();
}

$contact = $result['data'][0];
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">Send email</h3>
        <hr>
        <form action="?p=email_submit" method="post">
            <input type="hidden" name="text_id" value="<?= $id ?>">
            <input type="hidden" name="text_to_name" value="<?= $contact->name ?>">
            <input type="hidden" name="text_to_address" value="<?= $contact->email ?>">
            <div class="mb-3">
                <label for="text_to" class="form-label">To:</label>
                <input type="text" name="text_to" id="text_to" class="form-control" placeholder="Destination address" value="<?= $contact->name ?> <<?= $contact->email ?>>" required readonly>
            </div>
            <div class="mb-3">
                <label for="text_subject" class="form-label">Subject:</label>
                <input type="text" name="text_subject" id="text_subject" class="form-control" placeholder="Subject" value="" required>
            </div>
            <div class="mb-3">
                <label for="text_message" class="form-label">Message:</label>
                <textarea class="form-control" name="text_message" id="text_message" rows="5" placeholder="Text your message..." required></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">Send message</button>
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
