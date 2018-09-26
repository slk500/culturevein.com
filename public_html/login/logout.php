<?php require_once("../../app/bootstrap.php"); ?>
<?php

session_unset();

session_destroy();

header('Location:' . "http://culturevein.com/");