<?php 
    //validate access
    defined('CONTROL') or die('Access denied');

$_SESSION['id'] = 1;
header('Location: ?p=contacts');