<?php
//validate access
defined('CONTROL') or die('Access denied');

// unset   -> clears all session data
// destroy -> remove the session

//session_unset();
session_destroy();
header('Location: ?p=signin');