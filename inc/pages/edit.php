<?php
//validate access
defined('CONTROL') or die('Access denied');

//check errors
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

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
$contact = $db->selectContactByID($id, $user_id);

if (empty($contact) || $contact['status'] == 'error' || count($contact['data']) != 1) {
    header('Location: ?p=404');
    exit();
}
?>

<div class="form-wrapper">
    <div class="form-box">
        <h3 class="text-center">Edit Contact</h3>
        <hr>
        <form action="?p=edit_submit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="text_id" value="<?= $contact['data'][0]->id ?>">
            <div class="mb-3">
                <label for="text_name" class="form-label">Name:</label>
                <input type="text" name="text_name" id="text_name" class="form-control" placeholder="Insert contact name" value="<?= $contact['data'][0]->name ?>" required>
            </div>
            <div class="mb-3">
                <label for="text_phone" class="form-label">Phone:</label>
                <input type="phone" name="text_phone" id="text_phone" class="form-control" placeholder="Insert contact phone" value="<?= $contact['data'][0]->phone ?>" required>
            </div>
            <div class="mb-3">
                <label for="text_email" class="form-label">Email:</label>
                <input type="email" name="text_email" id="text_email" class="form-control" placeholder="Insert contact email" value="<?= $contact['data'][0]->email ?>" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo:</label>
                <?php if ($contact['data'][0]->photo != null) : ?>
                    <img class="table-img m-1" src="../inc/img/contacts/<?= $contact['data'][0]->photo ?>" alt="">
                    <a href="?p=remove_image_submit&id=<?= $contact['data'][0]->id ?>" class="btn btn-danger">Remove Image</a>
                <?php else : ?>
                    <img class="table-img m-1" src="../inc/img/default.png" alt="">
                <?php endif; ?>
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