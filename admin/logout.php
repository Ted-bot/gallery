<?php require_once("includes/header.php"); ?>
<?php

// session class contains func logout to logout
$session->logout();

// redirect function from functions.php
redirect("login.php");

?>