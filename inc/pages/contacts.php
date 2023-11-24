<?php
//validate access
defined('CONTROL') or die('Access denied');

$user_id = $_SESSION['id'];

$search = $_GET['search'] ?? null;

$db = new database();
if (empty($search)) {
    $res = $db->selectContactsByUserID($user_id);
} else {
    $res = $db->selectContactsByUserID($user_id, $search);
}

$contacts = $res['data'];
$count = count($contacts);
?>

<!-- HEADER CONTACTS -->
<div class="row">
    <div class="col">
        <?php if ($count > 0) : ?>
            <form action="?p=contacts" method="get">
                <div class="d-flex">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search..." value="<?= $search ?>">
                    <button class="btn btn-outline-dark ms-1"><i class="bi bi-search"></i></button>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <div class="col text-end">
        <a href="?p=new" class="btn btn-outline-dark"><i class="bi bi-person-add me-2"></i>New Contact</a>
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#new-contact-modal">
            <i class="bi bi-person-add me-2"></i>
            New Contact (modal)
        </button>
        <?php require_once('new_modal.php') ?>
    </div>
</div>
<hr>

<!-- TABLE CONTACTS -->
<?php if ($count > 0) : ?>
    <table class="table table-dark table-striped text-center h-100">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">NAME</th>
                <th scope="col">PHONE</th>
                <th scope="col">EMAIL</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr>
                    <td class="align-middle">
                        <?php if ($contact->photo == null) : ?>
                            <img class="table-img" src="../inc/img/default.png" alt="">
                        <?php else : ?>
                            <img class="table-img" src="../inc/img/contacts/<?= $contact->photo ?>" alt="">
                        <?php endif; ?>
                    </td>
                    <td class="align-middle"><?= $contact->name ?></td>
                    <td class="align-middle"><?= $contact->phone ?></td>
                    <td class="align-middle"><?= $contact->email ?></td>
                    <td class="align-middle">
                        <a href="?p=email&id=<?= $contact->id ?>" class="btn btn-outline-light me-2"><i class="bi bi-envelope-plus"></i></a>
                        <a href="?p=edit&id=<?= $contact->id ?>" class="btn btn-outline-light me-2"><i class="bi bi-pencil-square"></i></a>
                        <a href="?p=delete&id=<?= $contact->id ?>" class="btn btn-outline-light"><i class="bi bi-trash"></i></a>
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#delete-contact-modal<?= $contact->id ?>">
                            <i class="bi bi-trash"></i>M
                        </button>
                        <?php require('delete_modal.php') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- MESSAGES CONTACTS -->
<?php elseif (isset($_GET['search'])) : ?>
    <div class="container text-center">
        <p class="opacity-50 mt-5">There are no contacts registered according to the filter</p>
        <a href="?p=contacts" class="text-center btn btn-outline-dark"><i class="bi bi-people me-2"></i>See All Contacts</a>
    </div>

<?php else : ?>
    <p class=" text-center opacity-50 my-5">There are no registered contacts</p>
<?php endif; ?>