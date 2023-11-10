<?php 
    //validate access
    defined('CONTROL') or die('Access denied');
?>
<header class="container-fluid bg-dark text-white p-3">
    <div class="row h-100">
        <div class="col">
            <img src="../inc/img/logo.png" alt="Logo" class="img-logo">
            <h3 class="d-inline-flex ms-3">Contacts</h3>
        </div>
        <div class="col text-end my-auto">
            <nav>
                <?php require_once('nav.php')?>
            </nav>
        </div>
    </div>
</header>
<main class="container m-3 mx-auto">