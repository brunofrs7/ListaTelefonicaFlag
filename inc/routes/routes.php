<?php

$p = 'signin';

if($p == 'signin'){
    include('../inc/pages/signin.php');
}else{
    include('../inc/pages/signup.php');
}