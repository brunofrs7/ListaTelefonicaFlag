<?php

$p = $_GET['p'];

if($p == 'signin'){
    include('../inc/pages/signin.php');
}else if($p == 'signup'){
    include('../inc/pages/signup.php');
}else if($p == 'profile'){
    include('../inc/pages/profile.php');
}else if($p == 'contacts'){
    include('../inc/pages/contacts.php');
}else if($p == 'logout'){
    include('../inc/pages/logout.php');
}else{
    include('../inc/pages/404.php');
}