<link href="css/my-style.css" rel="stylesheet" type="text/css">
<?php
require("login.phtml");
require_once("session_helper.php");

$view = new stdClass();
$view->pageTitle = 'login';