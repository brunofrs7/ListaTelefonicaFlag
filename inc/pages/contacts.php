<?php
//validate access
defined('CONTROL') or die('Access denied');

$user_id = $_SESSION['id'];

$db = new database();
$res = $db->selectContactsByUserID($user_id);

$contacts = $res['data'];
$count = count($contacts);
?>

<!-- HEADER CONTACTS -->
<div class="row">
    <div class="col">
        <?php if ($count > 0) : ?>
            <div class="d-flex">
                <input type="text" name="text_search" id="text-search" class="form-control" placeholder="Search...">
                <button class="btn btn-outline-dark ms-1"><i class="bi bi-search"></i></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="col text-end">
        <a href="?p=new" class="btn btn-outline-dark"><i class="bi bi-person-add me-2"></i>New Contact</a>
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
            <tr>
                <td class="align-middle">
                    <img class="table-img" src="../inc/img/logo.png" alt="">
                </td>
                <td class="align-middle">Nome</td>
                <td class="align-middle">911222333</td>
                <td class="align-middle">email@email.pt</td>
                <td class="align-middle">
                    <a href="" class="btn btn-outline-light me-2"><i class="bi bi-envelope-plus"></i></a>
                    <a href="" class="btn btn-outline-light me-2"><i class="bi bi-pencil-square"></i></a>
                    <a href="" class="btn btn-outline-light"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
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