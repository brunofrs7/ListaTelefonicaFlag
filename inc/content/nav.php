<?php 
    //validate access
    defined('CONTROL') or die('Access denied');
 
if (!isset($_SESSION['id'])) : ?>
    <a href="?p=signup" class="btn btn-outline-light ms-2"><i class="bi bi-person-add me-2"></i>Signup</a>
    <a href="?p=signin" class="btn btn-outline-light ms-2"><i class="bi bi-box-arrow-in-right me-2"></i>Signin</a>
<?php else : ?>
    <a href="?p=profile" class="btn btn-outline-light ms-2"><i class="bi bi-person me-2"></i>Profile</a>
    <a href="?p=contacts" class="btn btn-outline-light ms-2"><i class="bi bi-people me-2"></i>Contacts</a>
    <a href="?p=logout" class="btn btn-outline-light ms-2"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
<?php endif ?>