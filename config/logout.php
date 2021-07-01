<?php

require_once '../views/session.php';

session_destroy();
header('location: ../index.php');

?>
