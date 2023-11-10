<?php
// variable to control access to scripts/pages
define('CONTROL', true);

//start session
session_start();

// load allowed routes
$allowed_routes = [];

if (isset($_SESSION['id'])) {
    $allowed_routes = require_once __DIR__ . '/../inc/routes/routes_logged_in.php';
} else {
    $allowed_routes = require_once __DIR__ . '/../inc/routes/routes_logged_out.php';
}

// set route by GET or default = null
$page = $_GET['p'] ?? null;

// if user is logged out and trying to access not allowed route
if (!isset($_SESSION['id']) && !in_array($page, $allowed_routes)) {
    $page = 'signin';
}

// if user is logged in and trying to access not allowed route
if (isset($_SESSION['id']) && !in_array($page, $allowed_routes)) {
    $page = 'contacts';
}

// load database
// ...

// load functions
// ...

// load page parts
require_once __DIR__ . '/../inc/content/head.php';
require_once __DIR__ . '/../inc/content/header.php';
require_once __DIR__ . "/../inc/pages/$page.php";
require_once __DIR__ . '/../inc/content/footer.php';
